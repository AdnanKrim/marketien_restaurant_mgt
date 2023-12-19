<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function getOrderListApi()
  {
    // $data = Order::where('orderStage','=','pending')->get();
    $data = Order::all();
    return response([
      'orderList' => $data
    ]);
  }
  public function addOrderApi(Request $req)
  {
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
    if ($result) {
      return response([
        'message' => 'Order submitted, wait for the next process',
        'status' => '201'
      ]);
    } else {
      return response([
        'message' => 'failed, Something Went Wrong',
        'status' => '202'
      ]);
    }
  }
  public function orderDetails($id)
  {
    $data = Order::where('id', $id)->first();
    $items = json_decode($data['foodItems']);
    $data['items'] = $items;
    $time = $data->created_at;
    $date = $time->format('d/m/Y');
    $data['date'] = $date;
    $data['vat'] = 2;
    $vat = $data['vat'];
    $data['deliveryCharge'] = 50;
    $dc = $data['deliveryCharge'];
    $data['grandTotal'] = (($vat / 100) * $data->totalAmount) + $data->totalAmount + $dc;
    unset($data['created_at']);
    unset($data['foodItems']);
    return response([
      'order' => $data,

    ]);
  }
  public function orderStageApproved($id)
  {
    $data = Order::find($id);
    $data->orderStage = 'cooking';
    $result = $data->save();
    if ($result) {
      return response([
        'message' => 'Order is in cooking process now',
        'status' => '201'
      ]);
    } else {
      return response([
        'message' => 'failed, Something Went Wrong',
        'status' => '202'
      ]);
    }
  }
  public function orderStageOnTheWay($id)
  {
    $data = Order::find($id);
    $data->orderStage = 'on the way';
    $result = $data->save();
    if ($result) {
      return response([
        'message' => 'Order is on the way',
        'status' => '201'
      ]);
    } else {
      return response([
        'message' => 'failed, Something Went Wrong',
        'status' => '202'
      ]);
    }
  }
  public function orderStageDelivered($id)
  {
    $data = Order::find($id);
    $data->orderStage = 'delivered';
    $result = $data->save();
    if ($result) {
      return response([
        'message' => 'Order is delivered',
        'status' => '201'
      ]);
    } else {
      return response([
        'message' => 'failed, Something Went Wrong',
        'status' => '202'
      ]);
    }
  }
  public function userOrderTracking()
  {
    $data = Order::where('clientIp', Request()->ip())->where('orderStage', '!=', 'delivered')->get();
    return response([
      'orders' => $data
    ]);
  }
  public function userOrderDetail($id){
     $data = Order::where('id',$id)->first();
     if($data->clientIp != Request()->ip()){
      return response([
        'message'=>'this is not your order',
        'status'=> '401'
      ]);
     }
     else{
      return response([
        'order'=> $data,
        'status'=> '201'

      ]);
     }

  }
}
