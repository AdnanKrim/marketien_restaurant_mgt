<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryController extends Controller
{
    public function deliveryManListApi()
    {
        $data = Employee::where('designation', '=', 'delivery man')->get();
        $delivery = [];
        foreach ($data as $dlvr) {
            $user = User::where('name', '=', $dlvr->name)->first();
            if ($user) {
                $dlvr->status = 2;
            } else {
                $dlvr->status = 1;
            }
            $delivery[] = $dlvr;
        }


        return response([
            'deliveryMan' => $delivery
        ]);
    }
    public function getDeliveryManInfo($id)
    {
        $data = Employee::find($id);
        return response([
            'deliveryMan' => $data
        ]);
    }
    public function createDeliveryPanel(Request $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = 2;
        $result = $user->save();
        if ($result) {
            return response([
                'message' => 'Successfully created a delivery panel',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function closeDeliveryPanel($id)
    {
        $data = Employee::find($id);
        $user = User::where('name', '=', $data->name)->first();
        if (!$user) {
            return response([
                "message" => 'delivery panel doesnt exist',
                "status" => 202
            ]);
        } else {
            $user->delete();
            return response([
                "message" => 'delivery panel disclosed successfully',
                "status" => 201
            ]);
        }
    }
    public function addDeliveryManApi(Request $req)
    {
        $user = new Employee();
        $user->name = $req->name;
        $user->phoneNo = $req->phoneNo;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->designation = 'delivery man';
        $result = $user->save();
        if ($result) {
            return response([
                'message' => 'Successfully added a delivery man',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function editDeliveryManFormApi($id)
    {
        $data = Employee::find($id);
        return response([
            'deliveryMan' => $data,
        ]);
    }
    public function updateDeliveryManApi(Request $req)
    {
        $user = Employee::find($req->id);
        $user->name = $req->name;
        $user->phoneNo = $req->phoneNo;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->designation = 'delivery man';
        $result = $user->save();
        if ($result) {
            return response([
                'message' => 'Successfully updated a delivery man',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }

    public function deliveryManDeleteApi($id)
    {

        $data = Employee::find($id);
        $user = User::where('name', '=', $data->name)->first();
        if (!$data) {
            return response([
                "message" => 'delivery man doesnt exist',
                "status" => 202
            ]);
        } else {
            if ($user) {
                $data->delete();
                $user->delete();
                return response([
                    "message" => 'delivery man and delivery panel deleted successfuly',
                    "status" => 203
                ]);
            }

            $data->delete();
            return response([
                "message" => 'delivery man deleted successfuly',
                "status" => 201
            ]);
        }
    }
    public function allDeliveryPanelList()
    {
        $data = User::where('role', '=', 2)->get();
        return response([
            'deliveryPanel' => $data
        ]);
    }
    public function assignOrderApi(Request $req)
    {
        $data = Order::find($req->id);
        $data->orderHandler = $req->name;
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'delivery man assigned to this order',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function getOrderDeliveryListApi()
    {
        // $data = Order::where('orderStage','=','pending')->get();
        $data = Order::where('orderHandler', '!=', null)->get();
        return response([
            'orderDeliveryList' => $data
        ]);
    }
    public function deliveryAssignList(){
        $data = Order::where('orderHandler', auth()->user()->name)->get();
        return response([
         'assignList'=> $data
        ]);
    }
    public function deliveryManInfo($id){
        $data = Order::find($id);
        $user = User::where('name',$data->orderHandler)->first();
        if($user){
        $dMan = Employee::where('email',$user->email)->first();
        return response([
            'deliveryMan'=> $dMan,
            'status' => '201'
             ]);
        }
        else{
            return response([
                'message'=>'Your delivery man has not been assigned yet',
                'status' =>'401'
            ]);
        }
        
        
    }
}
