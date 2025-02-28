<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku',
            'qty' => 'integer',
            // 'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'qty' => $request->qty,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'status' => $request->status ?? 1,
            'is_featured' => $request->is_featured ?? 'no',
        ]);

        if (!empty($request->gallery)) {
            foreach ($request->gallery as $key => $tempImageId) {
                $tempImage = TempImage::find($tempImageId);

                // Large Thumbnail
                $extArray = explode('.', $tempImage->name);
                $ext = end($extArray);

                $imageName = $product->id.'-'.time().'.'.$ext;

                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/temp/' . $tempImage->name));
                $img->scaleDown(1200);
                $img->save(public_path('uploads/products/large/' . $imageName));

                // Small Thumbnail
                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/temp/' . $tempImage->name));
                $img->coverDown(400, 460);
                $img->save(public_path('uploads/products/small/' . $imageName));

                if ( $key === 0 ) {
                    $product->image = $imageName;
                    $product->save();
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product created successfully',
            'data' => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku,'.$id.',id',
            'qty' => 'integer',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $product->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
