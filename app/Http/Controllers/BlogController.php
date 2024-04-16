<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

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
