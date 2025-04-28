<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get Cart Items
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return response()->json($cartItems);
    }

    // Add Item to Cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Check if product already exists in cart
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
    
        if ($cart) {
            // If product exists, return a message saying it's already in the cart
            return response()->json([
                'message' => '✅ Item is already in the cart!',
               
            ]);
        } else {
            // If product does not exist, create a new entry
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
    
            return response()->json([
                'message' => '✅ Item added to cart successfully!',
                'cart' => $cart,
            ]);
        }
    }
    

    // Update Item Quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        $cart->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Cart updated successfully']);
    }

    // Remove Item from Cart
    public function destroy($id)
    {
        $cart = Cart::where('product_id', $id)->where('user_id', Auth::id())->first();
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        $cart->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
    //
}
