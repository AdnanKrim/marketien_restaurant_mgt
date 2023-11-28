<?php

namespace App\Http\Controllers;
use App\Models\FoodCart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $req){
      $data = FoodCart::create([
         'foodId'=>$req->id,
         'userIp'=>$req->ip()
      ]);
      if($data){
        return response([
            'message'=>'Food Added to Cart',
            'status'=>'201'
        ]);

      }else{
        return response([
            'message'=>'Something Went Wrong',
            'status'=>'404'
        ]);
        
      }
      

    }
    public function getCartApi(Request $req){
      $data = FoodCart::where('userIp',$req->ip())->get();
      return response([
        'foodCart'=> $data
      ]);
    }
}
