<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    public function ClientRegistration(Request $request)
    {
        // try {
            DB::beginTransaction();
            $data = new User();

            $data->name = $request->name;

            $email_check = User::where('email', $request->email)->first();
            if($request->phone){
                $phone_check = User::where('phone', $request->phone)->first();
                if($phone_check)
                {
                    return response()->json(['error' => 'Phone Already Exists']);
                }
            }
            
            if($email_check)
            {
                return response()->json(['error' => 'Email Already Exists']);
            }
            
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->user_type = 2;
            $password = $request->password;
            $data->password = Hash::make($password);
            $data->save();
            DB::commit();
            return response()->json('Registration Successfully');
        // }catch (\Exception $e) {
        // return response()->json([
        //     "error" => "Something Error"
        // ], 400);
        // }
    }
}
