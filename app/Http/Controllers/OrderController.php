<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function getOrderListApi(){
    $data = Order::all();
    return response([
        'orderList'=>$data
    ]);
  }
    public function addOrderApi(Request $req){
      $data = new Order();
      $data->clientName = $req->clientName;
      $data->email = $req->email;
      $data->phoneNo = $req->phoneNo;
      $data->location = $req->location;
      $data->orderCode = rand(123456, 999999);
      $data->foodItems = json_encode($req->foodItems);
      $data->orderStage = 'pending';
      $data->clientIp = $req->getClientIp();
      $data->orderHandler = null;
      $data->totalAmount = $req->totalAmount;
      $result = $data->save();
      if($result){
        return response([
          'message'=>'Order submitted, wait for the next process',
          'status'=>'201'
        ]);
    }
    else{
        return response([
            'message'=>'failed, Something Went Wrong',
            'status'=>'202'
          ]);
    }
    }
}
