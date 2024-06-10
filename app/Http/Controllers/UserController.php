<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FoodItem;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

class UserController extends Controller
{
    function adminLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
                'status' => '404'
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'status' => '201'

        ];

        return response($response, 201);
    }
    public function adminLogoutApi(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => ['logged out successfully'],
            'status' => '405'
        ]);
    }
    public function getAdminGraphInfo()
    {
        $data = Order::where('orderStage', '=', 'delivered')->sum('totalAmount');
        $user = Order::where('orderStage', '=', 'delivered')->count();
        $item = FoodItem::count();
        $data = Visitor::count();
        return response([
            'totalSale' => $data,
            'totalDelivery' => $user,
            'item' => $item,
            'visitors' =>$data
        ]);
    }
    public function orderGraphInfo()
    {
        // $menu = FoodItem::all();
        $data = Order::all();
        //   $data = json_decode($jsonData, true);
        $foodQuantities = [];
        $abc = [];
        foreach ($data as $order) {
            $foodItems = json_decode($order['foodItems'], true);
            foreach ($foodItems as $foodItem) {

                $foodName = $foodItem['foodName'];
                $quantity = $foodItem['quantity'];
                if (isset($foodQuantities[$foodName])) {
                    $foodQuantities[$foodName] += $quantity;
                } else {
                    $foodQuantities[$foodName] = $quantity;
                }
            }
        }
        foreach ($foodQuantities as $foodName => $quantity) {
            //     // echo "Food Name :$foodName, Total Quantity:$quantity\n";
            //     // $abc[] = $foodName;
            //     // $bcd[] = $quantity;
            // $abc[]['name']=$foodName;
            // $abc[]['quantity']=$quantity;
            // $abc =[
            //     'name'=>$foodName,
            //     'quantity'=>$quantity
            // ];

            //     return response([
            //         'foodname' => $foodName,
            //         'quantity'  =>$quantity

            //        ]);
        }

        return response([
            // 'foodname' => 
            // 'quantity'  =>
            'items' => $foodQuantities

        ]);
    }
    public function visitor(){
      $data = Visitor::count();
      return response([
        'visitors' =>$data
      ]);
    }
  
}
