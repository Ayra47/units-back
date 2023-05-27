<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function createCart()
    {
        $cart = new Cart;
        $cart->user_id = auth()->id();
        $cart->save();

        return $cart;
    }

    public function getCart()
    {
        $model = Cart::where('user_id', auth()->id())->with('items.product.farmer')->first();

        if (!$model) {
            $model = $this->createCart();
        }

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function addItem($product_id)
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();
        if (!$cart) {
            $cart = $this->createCart();
        }
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product_id,
        ]);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function removeItem($id)
    {
        $cart = CartItem::find($id);
        $newId = $cart->cart_id;
        $cart->delete();
        $model = Cart::where('id', $newId)->with('items.product')->first();

        return response()->json([
            'success' => 1,
            'data' => [
                'newData' => $model
            ]
        ]);
    }
}
