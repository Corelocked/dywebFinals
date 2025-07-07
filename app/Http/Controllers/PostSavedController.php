<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostSavedController extends Controller
{

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
    public function index()
    {
        $saved = SavedPost::where('user_id', Auth::User()->id)->orderBy('id', 'DESC')->get();

        return view('post.saved', [
            'posts' => $saved,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:65535',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the uploaded image and get its path
            $uploadedPath = $request->file('image')->store('images/posts', 'public');
            $imagePath = 'storage/' . $uploadedPath;
        }

        $post = SavedPost::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $imagePath,
            'is_published' => $request->is_published == 'on',
            'category_id' => $request->category_id ? $request->category_id : null,
            'read_time' => $this->calculateReadTime($request->body),
        ]);

        return response()->json(['message' => 'Saved!', 'id' => $post->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function edit(int $id)
    {
        $saved = SavedPost::findOrFail($id);

        $this->checkUserIdPost($saved);

        return redirect('dashboard/posts/create?edit='.$saved->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $SavedPost = SavedPost::where('id', $id)->firstOrFail();

        $this->checkUserIdPost($SavedPost);

        // Validate the request
        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:65535',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $input['title'] = $request->title;
        $input['excerpt'] = $request->excerpt;
        $input['body'] = $request->body;
        $input['is_published'] = $request->is_published == 'on';
        $input['category_id'] = $request->category_id ? $request->category_id : null;
        $input['read_time'] = $this->calculateReadTime($request->body);

        // Handle image upload if present
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the uploaded image and get its path
            $uploadedPath = $request->file('image')->store('images/posts', 'public');
            $input['image_path'] = 'storage/' . $uploadedPath;
        }

        $SavedPost->update($input);

        return response()->json(['message' => 'saved']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $SavedPost = SavedPost::findOrFail($id);

        $this->checkUserIdPost($SavedPost);

        $SavedPost->delete();

        return redirect()->back();
    }

    private function checkUserIdPost(SavedPost $SavedPost): void
    {
        if ($SavedPost->user_id != Auth::id() && ! Auth::User()->hasPermissionTo('post-super-list')) {
            abort(403);
        }
    }
}
