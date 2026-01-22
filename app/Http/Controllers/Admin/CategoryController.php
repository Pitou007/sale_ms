<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('items'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name']
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('ok', 'Created');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // ✅ FIX: Use Route Model Binding
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id]
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('ok', 'Updated');
    }

    // ✅ FIX: Use Route Model Binding
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('ok', 'Deleted');
    }
}
