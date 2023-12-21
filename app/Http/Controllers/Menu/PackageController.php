<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function packageListApi(){
        $data = Package::all();
        return response([
         'packages' => $data
        ]);
    }
    public function addPackageApi(Request $req){
        $data = new Package();
        $data->packageName = $req->packageName;
        $data->foodItems = json_decode($req->foodItems);
        $data->numOfPeople = $req->numOfPeople;
        $data->price = $req->price;
        $data->packageState = null;
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'Successfully added a package',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function getFoodItemDropdown(){

        $cat = Category::with('fooditems')->get();
        $catData = $cat->toArray();
        return response()->json([
            "category"=>$catData
        ]);
        
    }
    public function editPackageFormApi($id){
        $data = Package::find($id);
        $data['items'] = json_encode($data->foodItems);
        return response([
           'package'=> $data,    
        ]);
    
    }
    public function getPackageItemApi($id){
        $data = Package::find($id);
        // $data['items'] = json_encode($data->foodItems);
        return response([
           'package'=> $data,    
        ]);
    
    }
    public function updatePackageApi(Request $req)
    {
        $data =Package::find($req->id);
        $data->packageName = $req->packageName;
       
        $data->numOfPeople = $req->numOfPeople;
        $data->price = $req->price;
        $data->packageState = null;
        
        if($req->has('foodItems')){
            $data->foodItems = json_decode($req->foodItems);
        }
        else{
            unset($data->foodItems);
            array_values($data->foodItems);
        }
        $result = $data->save();
        if ($result) {
            return response([
               'message' => 'Successfully updated a package',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function packageDeleteApi($id){
    
        $data = Package::find($id);
        if(!$data){
            return response([
                "message"=>'package doesnt exist',
                "status"=> 202
            ]);
        }else{
            $data->delete();
            return response([
                "message"=>'package deleted successfuly',
                "status"=> 201
            ]);
        }
       
}
}
