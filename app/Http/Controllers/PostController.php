<?php

namespace App\Http\Controllers;

use App\Models\HighlightPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts = Post::with('category')
            ->select('posts.*', DB::raw('(SELECT COUNT(*) FROM highlight_posts WHERE post_id = posts.id) > 0 AS is_highlighted'))
            ->orderBy('id', 'desc')->get();

        $highlighted_posts = HighlightPost::whereHas('post', function ($query) {
            $query->where('is_published', 1);
        })->get();

        return view('welcome', [
            'posts' => $posts,
            'highlighted_posts' => $highlighted_posts,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return Factory|View
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $nextPost = Post::where('id', '>', $post->id)->first();

        $user = User::find($post->user_id);

        if (!$post->is_published) {
            if (Auth::user()) {
                if (Auth::id() == $user->id || Auth::user()->hasPermissionTo('post-super-list')) {
                    // allow
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        return view('post.show', [
            'post' => $post,
            'nextPost' => $nextPost,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function get(Request $request)
    {
        if ($request->input('offset')) {
            $offset = $request->input('offset');
            $posts = Post::with([
                    'category' => function ($query) {
                        $query->select('id', 'name', 'backgroundColor', 'textColor');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'firstname', 'lastname', 'image_path');
                    },
                ])
                ->where('is_published', true)
                ->select('posts.*', DB::raw('(SELECT COUNT(*) FROM highlight_posts WHERE post_id = posts.id) > 0 AS is_highlighted'))
                ->offset($offset)
                ->limit(20)
                ->orderBy('id', 'desc')->get()
                ->makeHidden(['additional_info', 'category_id', 'user_id', 'change_user_id', 'changelog', 'id', 'created_at', 'updated_at', 'is_published']);
            foreach ($posts as $post) {
                $post->category->makeHidden('id');
                $post->user->makeHidden('id');
                $post->created_at_formatted = \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F, Y');
            }
            return response()->json($posts);
        } else {
            return response()->json('Not Acceptable', 406);
        }
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Example: store the uploaded image and get its path
            $imagePath = $request->file('image')->store('images/posts', 'public');
            $imagePath = 'storage/' . $imagePath;
        } else {
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
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'image_path' => $imagePath,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'user_id' => auth()->id(),
            'is_published' => $request->has('is_published'),
            'category_id' => $request->category_id,
            'read_time' => $request->read_time ?? 0,
            // add other fields as needed
        ]);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            // Add other fields and rules as needed
        ]);

        $post = Post::findOrFail($id);

        // Handle image upload if present
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images/posts', 'public');
            $imagePath = 'storage/' . $imagePath;
        } elseif (!$post->image_path || $request->input('remove_image')) {
            // No image uploaded and either no image exists or user wants to remove it
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
                $imagePath = 'images/default-post.jpg'; // fallback
            }
        } else {
            // Keep the current image
            $imagePath = $post->image_path;
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'image_path' => $imagePath,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'is_published' => $request->has('is_published'),
            'category_id' => $request->category_id,
            'read_time' => $request->read_time ?? 0,
            // Add other fields as needed
        ]);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully.');
    }
}
