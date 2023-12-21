<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function adminLogin(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.'],
                    'status'=>"404"
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token,
                'status'=>'201'

            ];
        
             return response($response, 201);
    }
    public function adminLogoutApi(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => ['logged out successfully'],
            'status'=>'405'
        ]);
    }
    public function getAdminGraphInfo(){
        $data = Order::where('orderStage','=','delivered')->sum('totalAmount');
        $user = Order::where('orderStage','=','delivered')->count();
        return response([
        'totalSale'=>$data,
        'totalDelivery'=>$user
        ]);
    }

}
