<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function getReview(Request $req){
    $exist = Review::where('foodId',$req->id)->where('userIP',Request()->ip())->first();
    if($exist){
    $exist->delete();
    }
     $data = new Review();
     $data->foodId = $req->id;
     $data->userIP = Request()->ip();
     $data->review = $req->review;
     $result = $data->save();
     if($result){
        return response([
            'message'=>'Your review is taken Successfully',
            'status'=> '201'
        ]);
    }else{
        return response([
            'message'=>'Something went wrong',
            'status' => '403'
        ]);
    }
    }
}
