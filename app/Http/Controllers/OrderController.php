<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use DB;
use Str;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function AddOrder(Request $request)
    {
        // return response()->json($request->cart);0
        // try {
            DB::beginTransaction();
            $data = new Order();
            $check = Order::orderby("id","desc")->first();
            if($check){
                $str = substr($check->order_id, 5);
                $main = substr($check->order_id, 0,5);
                $num = intval($str) + 1;
                $order_id = $main.$num;
            }
            else{
                $rand = Str::random(4);
                $order_id = "O".$rand."0";
            }
            $data->user_id = $request->user_id;
            $data->order_id = $request->order_id;
            $data->order_id = $order_id;
            $data->shipping_address = $request->shipping_address;
            $data->payment_type = $request->payment_type;
            if($request->payment_status){
                $data->payment_status = $request->payment_status;
            }
            $data->payment_details = $request->payment_details;
            $data->total = $request->total;
            if($request->discount){
                $data->discount = $request->discount;
            }
            $data->code = $request->code;
            $data->date = date("d/m/y");
            $data->save();
            
            foreach($request->cart as $key => $cart)
            {
                $details = new OrderDetails();
                $details->order_id = $data->id;
                $details->product_id = $cart['id'];
                $details->shipping_cost = $cart['shipping_cost'];
                $details->quantity = $cart['quantity'];
                $details->price = $cart['price'];
                if($request->payment_status){
                    $details->payment_status = $request->payment_status;
                }
                if($request->pickup_point_id){
                    $details->pickup_point_id = $request->pickup_point_id;
                }
                if($request->product_referral_code){
                    $details->product_referral_code = $request->product_referral_code;
                }
                $details->save();
            }
            if($request->user_id){
                Cart::where("user_id",$request->user_id)->delete();
            }
            else{
                Cart::where("guest_id",$request->guest_id)->delete();
            }            
            DB::commit();

            return response()->json(['order' => $data,
                "message" => "Order Created Successfully"
            ], 201);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         "error" => "Order Created Not Successfully"
        //     ], 400);
        // }
    }
    public function getOrders(){
            $orders = Order::orderby("id","desc")->with('order_details','user')->paginate(15);
            return response()->json(['orders' => $orders], 200);
    }

    public function getUserOrders(){
        $user_id = auth()->guard('api')->user()->id;
        $orders = Order::orderby("id","desc")->where("user_id",$user_id)->with('order_details','user')->paginate(15);
        return response()->json($orders);
    }

    public function acceptOrder(Request $request){
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->save();
        return response()->json(["message" => "approved successfully"],200);
    }
}
