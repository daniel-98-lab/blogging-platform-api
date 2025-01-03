<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(TagRequest $request)
    {
            // Validate the open data
            $tag = Tag::create($request->validated());

            return response()->json([
                'message' => 'Tag created successfully',
                'tag'     => $tag
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get a specific tag
        $tag = Tag::find($id);

        if(!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        // Get a specific tag
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Update the tag
        $tag->update($request->validated());

        return response()->json([
            'message' => 'Tag updated successfully',
            'tag' => $tag
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get a specific tag
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Remove the tag
        $tag->delete();

        return response()->json(['message' => 'Tag deleted successfully'], 204);
    }
}
