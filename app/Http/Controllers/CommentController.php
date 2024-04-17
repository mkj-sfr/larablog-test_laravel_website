<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index() {
        return view("comments.index", [
            'comments_by_status' => Comment::latest()->where('status', '=', 0)->get(),
            'comments_by_blog' => Comment::all()->groupBy('blog_id'),
            'comments_by_status_by_blog' => Comment::all()->where('status', '=', 0)->groupBy('blog_id'),
        ]);
    }

    public function destroy(Comment $comment) {
        if(!in_array(auth()->user()->role, [0, 1], true)) {
            abort(403, 'Unauthorized Access!');
        }

        $comment->delete();

        return back()->with('success','Comment deleted!');
    }
}
