<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HighlightPost;
use App\Models\Post;
use App\Models\User;
use App\Models\SavedPost;
use App\Models\HistoryPost;
use App\Notifications\PostNotification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostUpdateFormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:post-list', ['only' => ['index']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    private function calculateReadTime($body)
    {
        $readingSpeed = 200;
        $words = str_word_count(strip_tags($body));
        return ceil($words / $readingSpeed);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->input('q') !== null) {
            $terms = $request->input('q');
        } else {
            $terms = '';
        }

        if ($request->input('order') !== null) {
            $order = $request->input('order');
        } else {
            $order = 'desc';
        }
        if ($request->input('limit') !== null) {
            $limit = $request->input('limit');
        } else {
            $limit = 20;
        }

        $posts = Post::with('category')
            ->select('posts.*', DB::raw('(SELECT COUNT(*) FROM highlight_posts WHERE post_id = posts.id) > 0 AS is_highlighted'))
            ->orderBy('id', $order);
        if (Auth::User()->hasPermissionTo('post-super-list')) {
            if ($request->input('users') !== null && $request->input('users')[0] !== null) {
                if (isset($request->input('users')[1])) {
                    $temp = $request->input('users');
                } else {
                    $temp = explode(',', $request->input('users')[0]);
                }
                $posts->whereIn('user_id', $temp);
                $selected_users = User::whereIn('id', $temp)->withCount('posts')->get()->toArray();
                $selected_users_array = $temp;
            } else {
                $selected_users = null;
                $selected_users_array = null;
            }
        } else {
            $posts = Post::orderBy('id', $order)->where('user_id', Auth::Id());
            $selected_users = null;
            $selected_users_array = null;
        }

        if ($request->input('categories') !== null && $request->input('categories')[0] !== null) {
            if (is_array($request->input('categories'))) {
                $temp = explode(',', $request->input('categories')[0]);
            } else {
                $temp = explode(',', $request->input('categories'));
            }
            $posts->whereIn('category_id', $temp);
            if (Auth::User()->hasPermissionTo('post-super-list')) {
                $selected_categories = Category::whereIn('id', $temp)->withCount('posts')->get()->toArray();
            } else {
                $selected_categories = Category::whereIn('id', $temp)
                    ->withCount(['posts' => function ($query) {
                        $query->where('user_id', Auth::id());
                    }])
                    ->get()
                    ->toArray();
            }
            $selected_categories_array = $temp;
        } else {
            $selected_categories = null;
            $selected_categories_array = null;
        }

        if ($request->input('highlight') !== null && $request->input('highlight')[0] !== null) {
            try {
                if (is_array($request->input('highlight'))) {
                    $highlight = explode(',', $request->input('highlight')[0]);
                } else {
                    $highlight = explode(',', $request->input('highlight'));
                }
            } catch (\Exception $e) {
            }
            if ($highlight[0] && $highlight[1]) {
            } else {
                if ($highlight[0]) {
                    $posts->whereHas('highlightPosts');
                }
                if ($highlight[1]) {
                    $posts->doesntHave('highlightPosts');
                }
            }
        } else {
            $highlight = null;
        }

        $users = User::withCount('posts')->get();

        if (Auth::User()->hasPermissionTo('post-super-list')) {
            $categories = Category::withCount('posts')->get();
        } else {
            $categories = Category::withCount(['posts' => function ($query) {
                $query->where('user_id', Auth::id());
            }])->get();
        }

        if (Schema::hasColumn('posts', 'highlight_posts')) {
            $posts = $posts->where('highlight_posts', '=', true);
        }

        if ($terms !== null && $terms !== '') {
            $keywords = explode(' ', $terms);

            $posts->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('title', 'like', '%' . $keyword . '%');
                }
            });
        }

        if (Auth::User()->hasPermissionTo('post-super-list')) {
            $countPosts = Post::all()->count();
        } else {
            $countPosts = Auth::user()->posts()->count();
        }

        if ((int)$limit === 0) {
            $posts = $posts->get();
        } else {
            $posts = $posts->paginate($limit);
        }

        $countHighlighted = HighlightPost::all()->count();

        return view('post.index', [
            'posts' => $posts,
            'users' => $users,
            'order' => $order,
            'limit' => $limit,
            'terms' => $terms,
            'categories' => $categories,
            'selected_categories' => $selected_categories,
            'selected_categories_array' => $selected_categories_array,
            'selected_users' => $selected_users,
            'selected_users_array' => $selected_users_array,
            'countHighlighted' => $countHighlighted,
            'highlight' => $highlight,
            'countPosts' => $countPosts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|Factory|View
     */
    public function create(Request $request)
    {
        $saved = SavedPost::where('user_id', Auth::User()->id)->get();
        $categories = Category::all();

        if (count($saved) > 0 && ! $request->new && ! $request->edit) {
            return redirect()->route('posts.saved');
        }

        if ($request->edit) {
            $saved = SavedPost::findOrFail($request->edit);

            if ($saved->user_id != Auth::User()->id) {
                abort(404);
            }

            return view('post.create', [
                'post' => $saved,
                'categories' => $categories,
            ]);
        }

        // Always pass categories, even if post is not set
        return view('post.create', [
            'categories' => $categories,
            'post' => null, // explicitly set post to null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $SavedPost = SavedPost::find($request->id_saved_post);

        $this->checkUserIdPost(null, $SavedPost);

        $validation = [
            'title' => 'required|max:255|unique:posts,title',
            'excerpt' => 'required|max:510',
            'body' => 'required',
            'category_id' => [
                'required',
                'integer',
                'min:1'
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        $request->validate($validation);

        // Set a default image if none is provided
        $imagePath = null;

        // Debug logging
        Log::info('PostAdminController store - image handling', [
            'has_file' => $request->hasFile('image'),
            'file_valid' => $request->hasFile('image') ? $request->file('image')->isValid() : false,
            'saved_post_id' => $request->id_saved_post,
            'saved_post_exists' => $SavedPost ? true : false,
            'saved_post_image_path' => $SavedPost ? $SavedPost->image_path : null
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Use uploaded image file
            $imagePath = $request->file('image')->store('images/posts', 'public');
            $imagePath = 'storage/' . $imagePath;
            Log::info('Using uploaded image file: ' . $imagePath);
        } elseif ($SavedPost && $SavedPost->image_path) {
            // Use image from saved post
            $imagePath = $SavedPost->image_path;
            Log::info('Using saved post image: ' . $imagePath);
        } else {
            // Fall back to category default image
            $category = \App\Models\Category::find($request->category_id);
            if ($category) {
                $categoryImageMap = [
                    'Health and Fitness' => 'images/categories/default-health.jpg',
                    'Business and Finance' => 'images/categories/default-business.jpg',
                    'Technology' => 'images/categories/default-tech.jpg',
                    // ...other exceptions if needed
                ];

                if (isset($categoryImageMap[$category->name])) {
                    $imagePath = $categoryImageMap[$category->name];
                } else {
                    $slug = \Illuminate\Support\Str::slug($category->name);
                    $ext = ($category->name === 'Games') ? 'jpeg' : 'jpg';
                    $imagePath = "images/categories/default-{$slug}.{$ext}";
                }
            } else {
                $imagePath = 'images/default-post.jpg';
            }
            Log::info('Using category default image: ' . $imagePath);
        }

        // Ensure we have a valid image path
        if (empty($imagePath)) {
            $imagePath = 'images/default-post.jpg';
            Log::info('Fallback to default image: ' . $imagePath);
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $imagePath,
            'slug' => Str::slug($request->title),
            'is_published' => $request->is_published == 'on',
            'category_id' => $request->category_id,
            'read_time' => $this->calculateReadTime($request->body),
            'change_user_id' => Auth::id(),
            'changelog' => null,
        ]);

        if ($SavedPost) {
            $SavedPost->delete();
        }

        Auth::User()->notify(new PostNotification('SUCCESS', 'Post has been created!', "/post/$post->slug"));

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $post = Post::with('category')->findOrFail($id);

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);

        $hasAutoSave = !empty(HistoryPost::where('post_id', $id)->where('additional_info', 2)->get()[0]);

        $categories = Category::all();

        $this->checkUserIdPost($post);

        return view('post.edit', [
            'post' => $post,
            'hasAutoSave' => $hasAutoSave,
            'categories' => $categories,
            'editPost' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validation = [
            'title' => 'required|max:255|unique:posts,title,'.$id,
            'excerpt' => 'required|max:510',
            'body' => 'required',
            'category_id' => 'required|numeric|min:1',
        ];
        
        // Handle both file upload and string URL for image
        if ($request->hasFile('image')) {
            $validation += ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'];
        } elseif (!empty($request->image)) {
            $validation += ['image' => 'required|string'];
        } else {
            $validation += ['image' => 'nullable'];
        }
        
        $request->validate($validation);

        $post = Post::where('id', $id);

        if ($post->get()->isEmpty()) {
            abort(404);
        } else {
            $post = $post->get()[0];
        }

        $this->checkUserIdPost($post);

        $changelog = [];

        if ($post->title !== $request->title) {
            $changelog[] = 'Title';
        }
        if ($post->excerpt !== $request->excerpt) {
            $changelog[] = 'Excerpt';
        }
        if ($post->body !== $request->body) {
            $changelog[] = 'Body';
        }
        if ($post->is_published !== ($request->is_published == 'on' ? 1 : 0)) {
            $changelog[] = 'Visibility';
        }
        if ($post->category_id !== (int)$request->category_id) {
            $changelog[] = 'Category';
        }

        $input['title'] = $request->title;
        $input['excerpt'] = $request->excerpt;
        $input['body'] = $request->body;
        $input['slug'] = Str::slug($request->title);
        $input['is_published'] = $request->is_published == 'on';
        $input['additional_info'] = 0;
        $input['category_id'] = $request->category_id;
        $input['read_time'] = $this->calculateReadTime($request->body);
        $input['change_user_id'] = Auth::id();

        $method = $request->getMethod();

        $autoSave = HistoryPost::where('post_id', $id)->where('additional_info', 2)->first();

        // Handle image upload (file) or image URL (string)
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Handle file upload
            $imagePath = $request->file('image')->store('images/posts', 'public');
            $input['image_path'] = 'storage/' . $imagePath;
            $changelog[] = 'Image';
        } elseif (!empty($request->image)) {
            // Handle string URL from image picker
            $input['image_path'] = $request->image;
            $changelog[] = 'Image';
        }
        
        if (!empty($autoSave) && empty($request->image) && !$request->hasFile('image') && $post->image_path !== $autoSave->image_path) {
            $input['image_path'] = $autoSave->image_path;
            $changelog[] = 'Obraz';
        }

        $input['changelog'] = implode(", ", $changelog);

        if ($method === "PATCH") {
            if (!empty($autoSave)) {
                $autoSave->delete();
            }

            if (!empty($changelog)) {
                HistoryPost::create([
                    'post_id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => $post->excerpt,
                    'body' => $post->body,
                    'image_path' => $post->image_path,
                    'slug' => $post->slug,
                    'is_published' => $post->is_published,
                    'additional_info' => $post->additional_info,
                    'category_id' => $post->category_id,
                    'read_time' => $post->read_time,
                    'change_user_id' => $post->change_user_id,
                    'changelog' => $post->changelog,
                    'created_at' => $post->updated_at,
                    'updated_at' => $post->updated_at,
                ]);

                if (Auth::Id() !== $post->user_id) {
                    $post->user->notify(new PostNotification('INFO', 'The post was edited by '.Auth::User()->firstname.' '. Auth::User()->lastname. '.', "/dashboard/posts/$post->id/edit/history/current/show"));
                }

                $post->update($input);
            }

            return redirect()->route('posts.index');

        } elseif ($method === "PUT") {
            if (!empty($autoSave)) {
                $input['additional_info'] = 2;
                $input['changelog'] = null;
                $autoSave->update($input);
            } else {
                if (!empty($changelog)) {
                    HistoryPost::create([
                        'post_id' => $post->id,
                        'title' => $request->title,
                        'excerpt' => $request->excerpt,
                        'body' => $request->body,
                        'image_path' => $input['image_path'] ?? $post->image_path ?? asset('images/default-post.jpg'),
                        'slug' => Str::slug($request->title),
                        'is_published' => $request->is_published == 'on',
                        'additional_info' => 2,
                        'category_id' => $request->category_id,
                        'read_time' => $this->calculateReadTime($request->body),
                        'change_user_id' => Auth::id(),
                        'changelog' => null,
                    ]);
                }
            }
            return response()->json('OK');
        }

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);

        $this->checkUserIdPost($post);

        $post->delete();

        if (Auth::Id() !== $post->user_id) {
            $post->user->notify(new PostNotification('INFO', 'The post was deleted by '.Auth::User()->firstname.' '. Auth::User()->lastname. '.'));
        }

        return redirect()->route('posts.index');
    }

    /**
     * Highlight the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function highlight(Request $request)
    {
        // Only allow users with the 'Admin' role
        if (!Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $post = Post::findOrFail($request->id);

        $countHighlighted = HighlightPost::count();

        $highlighted_post = HighlightPost::where('post_id', $request->id)->first();

        $isHighlighted = !empty($highlighted_post);

        if ($isHighlighted) {
            $highlighted_post->delete();
        } else {
            if ($countHighlighted >= 5) {
                abort(403);
            }

            HighlightPost::create([
                'post_id' => $post->id,
            ]);

            if (Auth::id() !== $post->user_id) {
                $post->user->notify(new PostNotification('INFO', 'The post has been highlighted.', "/post/$post->slug"));
            }
        }

        return redirect()->back();
    }

    /**
     * Get the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function autoSave(int $id)
    {
        $post = HistoryPost::with('category')->where('post_id', $id)->where('additional_info', 2)->get();

        if (empty($post[0])){
            $post = null;
        } else {
            $post = $post[0];
        }

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function reject(int $id)
    {
        $post = HistoryPost::with('category')->where('post_id', $id)->where('additional_info', 2)->get();

        if (!empty($post[0])){
            $post[0]->delete();
        }

        return response()->json('OK');
    }

    public function calculate(Request $request)
    {
        $readingTime = $this->calculateReadTime($request->get('body'));

        return response()->json($readingTime);
    }

    private function checkUserIdPost(Post $post = null, SavedPost $savedPost = null): void
    {
        if ($post) {
            // If it's a delete operation, only check for post-delete permission
            $isDeleteOperation = request()->route()->getActionMethod() === 'destroy';
            if ($isDeleteOperation) {
                if ($post->user_id != Auth::id() && !Auth::User()->hasPermissionTo('post-delete')) {
                    abort(403);
                }
            } else {
                // For other operations like edit/update, require post-super-list for non-owned posts
                if ($post->user_id != Auth::id() && !Auth::User()->hasPermissionTo('post-super-list')) {
                    abort(403);
                }
            }
        }
        if ($savedPost) {
            if ($savedPost->user_id != Auth::id() && !Auth::User()->hasPermissionTo('post-super-list')) {
                abort(403);
            }
        }
    }
}
