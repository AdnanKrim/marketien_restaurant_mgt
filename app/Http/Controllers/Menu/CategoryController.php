<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class CategoryController extends Controller
{
    public function getCategoryApi(){
        $data = Category::all();
        return response([
        'category'=>$data
        ]);
    }
    public function addCategoryApi(Request $req){
        $data = new Category();
        $data->categoryName = $req->categoryName;
        $data->categoryCode = $req->categoryCode;
        $data->description = $req->description;
        $result = $data->save();
        if($result){
            return response([
                'message'=>'Category Added Successfully',
                'status'=> '201'
            ]);
        }else{
            return response([
                'message'=>'Something went wrong',
                'status' => '403'
            ]);
        }
    }
    public function editCategoryFormApi($id){
        $data = Category::find($id);
        return response([
           'category'=> $data
        ]);
    }
    public function updateCategoryApi(Request $req){
        $data = Category::find($req->id);
        $data->categoryName = $req->categoryName;
        $data->categoryCode = $req->categoryCode;
        $data->description = $req->description;
        $result = $data->save();
        if($result){
            return response([
                'message'=>'Category Updated Successfully',
                'status'=> '201'
            ]);
        }else{
            return response([
                'message'=>'Something went wrong',
                'status' => '403'
            ]);
        }

    }
    public function categoryDeleteApi($id)
    {
        $data = Category::find($id);
        if(!$data){
            return response([
                "message"=>'category doesnt exist',
                "status"=> 202
            ]);
        }else{
            $data->delete();
            return response([
                "message"=>'category deleted successfuly',
                "status"=> 201
            ]);
        }
    }
    
}
