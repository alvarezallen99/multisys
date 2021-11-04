<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function createOrder() {
        $req = Request();

        $validator = Validator::make($req->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], 422);
        }

        $product = Product::where('id', $req->product_id)->first();
        if($req->quantity > $product->available_stock) {
            return response()->json(['message'=>'Failed to order this product due to unavailability of the stock'], 400);
        }
        Order::create([
            'user_id' => auth()->user()->id,
            'product_id' => $req->product_id,
            'quantity' => $req->quantity,
        ]);
        $product->available_stock = $product->available_stock - $req->quantity;
        $product->save();
        return response()->json(['message' => 'You have successfully order this product'], 201);
    }
}
