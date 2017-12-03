<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->get();
        return response()->json([
            'comments' => $comments,
            'status' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $comment = new Comment();
        $comment->text = $request->post('comment');

        $user = Auth::guard('api')->user();
        $user->comments()->save($comment);

        $post->comments()->attach($comment->id);

        return response()->json([
            'comment' => $comment,
            'status' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        return response()->json([
            'comment' => $comment,
            'status' => 'success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $comment->text = $request->get('comment');
        $flag = $comment->save();
        return response()->json([
            'comment' => $comment,
            'status' => $flag ? 'success': 'fail'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Post $post, Comment $comment)
    {
        $post->comments()->detach($comment->id);
        return response()->json([
            'status' => $comment->delete() ? 'success': 'fail'
        ]);
    }
}
