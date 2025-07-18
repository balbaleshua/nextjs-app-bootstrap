<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $this->authorize('admin-only');
        return Category::all();
    }

    public function store(Request $request)
    {
        $this->authorize('admin-only');
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'description' => 'nullable|string',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        $this->authorize('admin-only');
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('admin-only');
        $validated = $request->validate([
            'name' => 'sometimes|required|string|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $category->update($validated);
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('admin-only');
        $category->delete();
        return response()->json(null, 204);
    }
}
