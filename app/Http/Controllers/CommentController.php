<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::where('parent_id', '=', null)->get()->reverse();

        return view('index', ['comments' => $comments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $comment = Comment::create($data);
        return redirect()->route('comments.index');
    }
}
