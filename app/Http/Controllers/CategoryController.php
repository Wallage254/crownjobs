<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('is_active', true)
                             ->orderBy('name')
                             ->get();
        return response()->json($categories);
    }

    public function show(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'gif_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'gif_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
