<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            $token = auth('api')->attempt($credentials);
            if(!$token){
                return response()->json(['success' => 0, 'message' => 'Email & Password does not match with our records'], 404);
            }    
            

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['success' => 0, 'message' => 'token expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['success' => 0, 'message' => 'token invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['success' => 0, 'message' => 'unknown error'], 500);

        }
        
        $user = auth('api')->user();
        if($request->guest_id != "" || $request->guest_id != null){
            $carts = Cart::where("guest_id",$request->guest_id)->get();
            foreach($carts as $cart){
                $data = Cart::findOrFail($cart->id);
                $data->user_id = $user->id;
                $data->save();
            }
        }
        return response()->json([
            'success' => 1,
            'access_token' => $token,
            'user' => $user
        ]);

    }

    function checkLogin()
    {
        if(Auth::user()) {
            return response()->json(['success' => 1]);
        }

        return response()->json(['success' => 0]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function DeleteDeliveryAddress(Request $request)
    {
        try{
            $address_id = $request->address_id;
            $address = DeliveryAddress::where('id', $address_id)->first();
            $address->delete();
            return response()->json([
                "success" => "Address Deleted Successfully"
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }

    }

    public function AddDeliveryAddress(Request $request)
    {
        // try{
            $id = Auth::guard('api')->user()->id;
            $data = new DeliveryAddress();
            $data->user_id = $id;
            $data->title = $request->title;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->country_code = $request->country_code;
            $data->phone = $request->phone;
            $data->country = $request->country;
            $data->house_no = $request->house_no;
            $data->city = $request->city;
            $data->post_code = $request->post_code;
            $data->address1 = $request->address1;
            $data->address = $request->address;
            $data->save();
            DB::commit();
            return response()->json([
                "success" => "Address Added Successfully"
            ], 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "error" => "Something Error"
        //     ], 400);
        // }
    }

    public function UpdateDeliveryAddress(Request $request)
    {
        try{
            $id = Auth::guard('api')->user()->id;
            $data = DeliveryAddress::findOrFail($request->address_id);
            $data->user_id = $id;
            $data->title = $request->title;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->country_code = $request->country_code;
            $data->phone = $request->phone;
            $data->country = $request->country;
            $data->house_no = $request->house_no;
            $data->city = $request->city;
            $data->post_code = $request->post_code;
            $data->address1 = $request->address1;
            $data->address = $request->address;
            $data->save();
            DB::commit();
            return response()->json([
                "success" => "Address Added Successfully"
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }
    }

    public function GetDeliveryAddresses(Request $request)
    {
        try{
            $id = Auth::guard('api')->user()->id;
            $data = DeliveryAddress::where('user_id',$id)->orderby("id","desc")->get();
            
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }
    }

    public function GetOrderList()
    {
        try{
            $id = Auth::guard('api')->user()->id;
            $order_info = Order::where('user_id', $id)->orderBy('id', 'desc')->get();
            return response()->json($order_info);
        }
        catch (\Exception $e) {
            return response()->json([
                "error" => "Something Error"
            ], 400);
        }
    }

}

