<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        return view("categories.index", [
            "categories" => Category::latest()->paginate(10),
        ]);
    }

    public function create() {
        return view("categories.create");
    }

    public function store(Category $category) {
        $formFields = request()->validate([
            'name'=>['required','string'],
        ]);

        Category::create($formFields);

        return redirect()->route('categories')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category) {
        return view("categories.edit", [
            "category" => $category,
        ]);
    }

    public function update(Category $category) {
        $formFields = request()->validate([
            'name'=>['required','string'],
        ]);

        $formFields['status'] = 0;

        Category::update($formFields);

        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category) {
        $category->delete();

        return redirect()->route('categories')->with('success','Category deleted!');
    }
}
