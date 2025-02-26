<?php

namespace App\Http\Controllers\admin\Catalog;

use Illuminate\Http\Request;
use App\Models\Catalog\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $brands
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $brand = Brand::create([
            'name' => $request->name,
            'status' => $request->status ?? 1
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Brand created successfully',
            'data' => $brand,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $brand = Brand::find($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $brand
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
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

        $brand->update([
            'name' => $request->name,
            'status' => $request->status ?? $brand->status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Brand updated successfully',
            'data' => $brand,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
                'data' => []
            ], 404);
        }

        $brand->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Brand deleted successfully',
        ], 200);
    }
}
