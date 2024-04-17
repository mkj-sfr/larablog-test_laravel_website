<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\CommentsRelation;

class BlogController extends Controller
{
    public function index() {
        return view('blogs.index', [
            'blogs' => Blog::latest()->paginate(6),
        ]);
    }

    public function show(Blog $blog) {
        return view("blogs.show", [
            'blog' => $blog,
        ]);
    }

    public function create() {
        return view("blogs.create");
    }

    public function store() {
        $formFields = request()->validate([
            'title' => ['required', 'min:3'],
            'category_id' => ['required', 'numeric'],
            'tags' => 'nullable',
            'image' => 'nullable',
            'body' => 'required',
            'status' => ['required', 'boolean'],
        ]);

        $formFields['user_id'] = auth()->id();

        if(request()->hasFile('image')) {
            $formFields['image'] = request()->file('image')->store('images', 'public');
        }

        Blog::create($formFields);

        return redirect()->route('blogs')->with('message', 'Blog created successfully.');
    }

    public function store_comment(Blog $blog) {
        // check if commenter is logged in
        if(auth()->user()) {
            $formFields = request()->validate([
                'body' => 'required',
                'reply' => ['nullable', 'numeric'],
            ]);
            $formFields['user_id'] = auth()->id();
            $formFields['email'] = auth()->user()->email;
            $formFields['name'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        } else {
            $formFields = request()->validate([
                'email' => ['required', 'email'],
                'name' => ['required', 'min:3'],
                'body' => 'required',
                'reply' => ['nullable', 'numeric'],
            ]);
    
            $formFields['user_id'] = null;
        }

        // set comment blog_id
        $formFields['blog_id'] = $blog->id;

        //check if commenter is manager
        if((auth()->user()->role > 1) || !(auth()->user())) {
            $formFields['status'] = 0;
        } else {
            $formFields['status'] = 1;
        }

        //check if comment is a reply
        if($formFields['reply']) {
            $parent_comment_id = $formFields['reply'];
            unset($formFields['reply']);
        }

        //create comment
        $comment = Comment::create($formFields);

        // create reply relation
        if(isset($parent_comment_id) && $parent_comment_id) {
            $comment_relation = [
                'reply_id' => $comment->id,
                'parent_comment_id' => $parent_comment_id,
            ];
            CommentsRelation::create($comment_relation);
        }

        return back()->with('message','Comment submitted.');
    }

    public function edit(Blog $blog) {
        return view("blogs.edit", [
            'blog', $blog,
        ]);
    }

    public function update(Blog $blog) {
        if(($blog->user_id != auth()->id()) || (!in_array(auth()->user()->role, [0, 1], true))) {
            abort(403, 'Unauthorized Access!');
        }

        $formFields = request()->validate([
            'title' => ['required', 'min:3'],
            'category_id' => ['required', 'numeric'],
            'tags' => 'nullable',
            'image' => 'nullable',
            'body' => 'required',
            'status' => ['required', 'boolean'],
        ]);

        if(request()->hasFile('image')) {
            $formFields['image'] = request()->file('image')->store('images', 'public');
        }

        $blog::update($formFields);

        return back()->with('message', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog) {
        if(($blog->user_id != auth()->id()) || (!in_array(auth()->user()->role, [0, 1], true))) {
            abort(403, 'Unauthorized Access!');
        }

        $blog::delete();

        redirect()->route('blogs')->with('message', 'Blog deleted!');
    }
}
