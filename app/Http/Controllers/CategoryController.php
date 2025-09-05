<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryEditRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()
            ->sortByDesc('created_at');

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        Category::query()->create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category successfully created.');
    }

    public function edit(CategoryEditRequest $request, Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Category successfully updated.');
    }

    public function destroy(CategoryDeleteRequest $request, Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted. As well as related posts.');
    }
}
