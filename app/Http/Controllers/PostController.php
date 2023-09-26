<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'data' => Post::with('author:id,first_name,last_name')->get()->makeHidden(['author_id']),
            'message' => 'success'
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|min:0',
            'content' => 'required|string|max:255|min:20',
            'featured_image' => 'required|url',
            'author_id' => 'required|integer|exists:authors,id'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->featured_image = $request->featured_image;
        $post->author_id = $request->author_id;

        $post->save();

        return response()->json([
            'data' => [
                'insertedId' => $post->id
            ],
            'message' => 'success'
        ]);
    }
}

