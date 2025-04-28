<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function vendorproduct()
{
   
    $products = Product::where('user_id',  Auth::id())->get();
    return response()->json($products, 200);
}

    // Get single product
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Store product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $data = $request->all();
        $data['user_id'] =  Auth::id(); // Add the authenticated user's ID
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;
        }
    
        // Create product
        $product = Product::create($data);
    
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }
    
    
    // Update product
    public function update(Request $request, $id)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Update Product Request:', $request->all());
    
            // Validate input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|max:100', // New category field
                'stock' => 'required|integer|min:0', // New stock field
                'price' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Updated image validation
            ]);
    
            if ($validator->fails()) {
                // Log the validation errors
                Log::error('Validation failed:', $validator->errors()->toArray());
    
                return response()->json(['error' => $validator->errors()], 422);
            }
    
            // Find the product
            $product = Product::find($id);
            if (!$product) {
                Log::error("Product not found with ID: $id");
    
                return response()->json(['error' => 'Product not found'], 404);
            }
    
            // Handle image upload if exists
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $product->image = 'uploads/products/' . $imageName;
    
                // Log the image path for debugging
                Log::info('Image uploaded:', ['image_path' => $product->image]);
            }
    
            // Update the product with validated data
            $product->name = $request->input('name', $product->name);
            $product->description = $request->input('description', $product->description);
            $product->category = $request->input('category', $product->category);
            $product->stock = $request->input('stock', $product->stock);
            $product->price = $request->input('price', $product->price);
    
            // Save the product
            $product->save();
    
            Log::info("Product updated successfully with ID: $product->id");
    
            return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error updating product: ' . $e->getMessage(), ['exception' => $e]);
    
            return response()->json(['error' => 'Failed to update product', 'message' => $e->getMessage()], 500);
        }
    }
    
    

    // Delete product
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
