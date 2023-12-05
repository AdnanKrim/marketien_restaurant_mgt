<?php

namespace App\Http\Controllers;
use App\Models\FoodCart;
use App\Models\FoodItem;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($id){
      $cart = FoodCart::where('foodId',$id)->first();
      
      if($cart){
        return response([
          'message'=>'You have added this item already',
          'status'=>'402'
      ]);
      }else{

        $data = new FoodCart();
        $data->foodId = $id;
        $data->userIp = Request()->ip();
        $result = $data->save();
      if($result){
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
      
      

    }
    public function getCartApi(Request $req){
      $foodCart=[];
      $data = FoodCart::where('userIp',$req->ip())->get();
      foreach($data as $item){
        $foodItem = FoodItem::where('id',$item->foodId)->first();
        $fileName = $foodItem->image;
        $path = asset('/upload/image/'. $fileName );   
         $foodItem->imgLink = $path;
         unset($foodItem->image); 
        $foodCart[] = $foodItem ;
      }
      return response([
        'foodCart'=> $foodCart
      ]);
    }
    public function foodCartDeleteApi($id){
      $data = FoodCart::where('foodId',$id)->first();
      if(!$data){
          return response([
              "message"=>'Cart Item doesnt exist',
              "status"=> 202
          ]);
      }else{
          $data->delete();
          return response([
              "message"=>'Cart Item deleted successfuly',
              "status"=> 201
          ]);
      }
  }
}
