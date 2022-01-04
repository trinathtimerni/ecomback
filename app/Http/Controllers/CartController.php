<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetProductsCart(Request $request)
    {
        // try {
            if($request->user_id != null){
                $carts = Cart::orderby("id","desc")->where("user_id",$request->user_id)->with('product')->get();
            }
            else if($request->guest_id != null){
                $carts = Cart::orderby("id","desc")->where("guest_id",$request->guest_id)->with('product')->get();
            }
            else{
                $carts = [];
            }
                return response()->json($carts);
        // }
        // catch (\Exception $e) {
        //     return response()->json([
        //         "error" => "Something Error"
        //     ], 400);
        // }
    }
    public function AddProductsCart(Request $request)
    {
            try {
                Cart::create([
                    'user_id' => $request->user_id,
                    'guest_id' => $request->guest_id,   
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,                    
                    'price' => $request->price,
                ]);
                $message = "success";
                return response()->json($message);
            }
            catch (\Exception $e) {
                return response()->json([
                    "error" => "Something Error"
                ], 400);
            }
    }
    public function UpdateProductsCart(Request $request)
    {
        try {
            $cart = Array();
            $cart['quantity'] = $request->quantity;
            $cart['product_id'] = $request->product_id;
            $cart['price'] = $request->price;
            Cart::where('id',$request->cart_id)->update($cart);
            $message = "success";
            return response()->json($message);
        }
        catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }
    }
    public function DeleteProductsCart(Request $request)
    {
        try {
                Cart::where('id',$request->cart_id)->delete();
                $message = "success";
                return response()->json($message);
        }
        catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }
    }
}
