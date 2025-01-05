<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->get('term');
        $posts = Post::where('title', 'like', '%' . $term . '%')
                 ->orWhere('content', 'like', '%' . $term . '%')
                 ->with(['category','tags'])
                ->get();

        return PostResource::collection($posts);
    }

    /**
     * Get posts from a specific category.
     * @param  int  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostsByCategory($category)
    {
        $posts = Post::where('category_id', $category)->get();

        return response()->json(PostResource::collection($posts));
    }

    /**
     * Get posts from a specific tag.
     * @param  int  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostsByTag($tag)
    {
        $posts = Post::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.id', $tag);
        })->get();

        return response()->json(PostResource::collection($posts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());

        // Associate the category to the post
        $post->category()->associate($request->category_id);

        // Associate the tags to the post
        if($request->has('tag_ids')) {
            $post->tags()->sync($request->tag_ids);
        }

        $post->save();

        return response()->json([
            'message'  => 'Post created successfully',
            'post'     => new PostResource($post)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get specific post
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        // Get specific post
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Update the post
        $post->update($request->validated());

        return response()->json([
            'message'  => 'Post updated successfully',
            'post'     => new PostResource($post)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get specific post
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Remove the post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
