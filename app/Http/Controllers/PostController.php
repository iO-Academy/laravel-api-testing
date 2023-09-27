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











    /**
     * Route for the posts view page
     */
    public function postsPage()
    {
        $posts = Post::all();
        // When we use the view function
        // the first argument is the name of the view
        // we want to display
        // This does not include the .blade.php extension

        // The second argument is an assoc array of data
        // Blade will take the keys from this array, and make
        // them available in the template file as variables
        return view('posts', [
            'title' => 'My amazing blog posts page',
            'subtitle' => 'Posts by Ash',
            'posts' => $posts
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

