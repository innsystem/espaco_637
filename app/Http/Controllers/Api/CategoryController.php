<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('statusRelation')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:categories,title',
            'slug' => 'required|unique:categories,slug',
            'description' => 'nullable',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::with(['statusRelation', 'products'])->findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $rules = [
            'title' => "required|unique:categories,title,$id,id",
            'slug' => "required|unique:categories,slug,$id,id",
            'description' => 'nullable',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}