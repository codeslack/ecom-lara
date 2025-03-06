<?php

namespace App\Http\Controllers\front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Http\Controllers\Controller;

class Products extends Controller
{
    public function getProduct($id)
    {
        $product = Product::with('product_images', 'product_sizes.size')
                        ->find($id);

        if ( $product == null ) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        // filter products by category
        // if (!empty($request->category)) {
        //     $catArray = explode(',', $request->category);
        //     $products = $products->whereIn('category_id', $catArray);
        // }

        // // filter products by brand
        // if (!empty($request->brand)) {
        //     $brandArray = explode(',', $request->brand);
        //     $products = $products->whereIn('brand_id', $brandArray);
        // }

        // $products = $products->get();

        return response()->json([
            'status' => 200,
            'data' => $product
        ], 200);
    }

    public function getProducts(Request $request)
    {
        $products = Product::orderBy('created_at', 'DESC')
                    ->where('status', 1);


        // filter products by category
        if (!empty($request->category)) {
            $catArray = explode(',', $request->category);
            $products = $products->whereIn('category_id', $catArray);
        }

        // filter products by brand
        if (!empty($request->brand)) {
            $brandArray = explode(',', $request->brand);
            $products = $products->whereIn('brand_id', $brandArray);
        }

        $products = $products->get();

        return response()->json([
            'status' => 200,
            'data' => $products
        ], 200);
    }
    
    public function latestProducts()
    {
        $products = Product::orderBy('created_at', 'DESC')
                    ->where('status', 1)
                    ->limit(8)
                    ->get();


        return response()->json([
            'status' => 200,
            'data' => $products
        ], 200);
    }

    public function featuredProducts()
    {
        $products = Product::orderBy('created_at', 'DESC')
                    ->where('status', 1)
                    ->where('is_featured', 'yes')
                    ->limit(8)
                    ->get();
                    

        return response()->json([
            'status' => 200,
            'data' => $products
        ], 200);
    }

    public function getCategories()
    {
        $categories = Category::orderBy('name', 'ASC')
                    ->where('status', 1)
                    ->get();
                    

        return response()->json([
            'status' => 200,
            'data' => $categories
        ], 200);
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('name', 'ASC')
                    ->where('status', 1)
                    ->get();
                    

        return response()->json([
            'status' => 200,
            'data' => $brands
        ], 200);
    }
}
