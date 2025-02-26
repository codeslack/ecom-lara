<?php

namespace App\Http\Controllers\admin\Catalog;

use Illuminate\Http\Request;
use App\Models\Catalog\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status ?? 1
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
                'data' => []
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }        

        $category->update([
            'name' => $request->name,
            'status' => $request->status ?? $category->status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
                'data' => []
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
