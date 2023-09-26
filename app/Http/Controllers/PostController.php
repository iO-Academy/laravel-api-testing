<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'data' => Post::all(),
            'message' => 'success'
        ]);
    }
}

