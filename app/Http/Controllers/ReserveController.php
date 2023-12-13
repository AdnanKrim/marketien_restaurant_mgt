<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReserveController extends Controller
{
    public function getReserveListApi()
    {
        // $data = Order::where('orderStage','=','pending')->get();
        $data = Reservation::all();
        return response([
            'reserveList' => $data
        ]);
    }
    public function userReserveInfoApi()
    {
        // $data = Order::where('orderStage','=','pending')->get();
        $data = Reservation::where('clientIp',Request()->ip())->first();
        if($data){
            if($data->reserveState === 'approved'){
                return response([
                    'reserve' => $data,
                    'status'=> '201',
                    'message'=>'You have an reservation'
                ]);
            } else
            return response([
                'message'=> 'Your request reservation is processing',
                'status'=> '202'
            ]);
        }
        else{
            return response([
              'message'=>'You do not have any reservation',
              'status'=> '401'
            ]);
        }
    }


    public function addReservationApi(Request $req)
    {
        $data = new Reservation();
        $data->clientName = $req->clientName;
        $data->email = $req->email;
        $data->phoneNo = $req->phoneNo;
        $data->location = $req->location;
        $data->reserveCode = rand(123456, 999999);
        $data->reserveState = 'requested';
        $data->clientIp = $req->getClientIp();
        $data->eventDate = $req->eventDate;
        $data->startTime = $req->startTime;
        $data->endTime = $req->endTime;
        $data->eventType = $req->eventType;
        $data->numbOfPeople = $req->numbOfPeople;
        $data->eventInfo = $req->eventInfo;
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'Reservation request completed, wait for the Approval',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function reservationApproved($id)
    {
        $data = Reservation::find($id);
        $data->reserveState = 'approved';
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'reservation is approved',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function reservationDeleteApi($id)
    {
        $data = Reservation::find($id);
        if(!$data){
            return response([
                "message"=>'Reservation doesnt exist',
                "status"=> 202
            ]);
        }else{
            $data->delete();
            return response([
                "message"=>'Reservation deleted successfuly',
                "status"=> 201
            ]);
        }
    }
}
