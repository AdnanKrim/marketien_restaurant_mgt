<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    public function getSubCategoryApi(){
        $data = DB::table('subcategories')
        ->leftJoin('categories','subcategories.categoryId','=','categories.id')
        ->select('subcategories.*','categories.categoryName as categoryId')
        ->get();
        return response([
        'subCategory'=>$data
        ]);
    }
    public function addSubCategoryApi(Request $req){
        $data = new Subcategory();
        $data->categoryId = $req->categoryId;
        $data->subCategoryName = $req->subCategoryName;
        $data->subCategoryCode = $req->subCategoryCode;
        $data->description = $req->description;
        $result = $data->save();
        if($result){
            return response([
                'message'=>'Subcategory Added Successfully',
                'status'=> '201'
            ]);
        }else{
            return response([
                'message'=>'Something went wrong',
                'status' => '403'
            ]);
        }
    }
    public function editSubCategoryFormApi($id){
        $data = Subcategory::find($id);
        return response([
           'subCategory'=> $data
        ]);
    }
    public function updateSubCategoryApi(Request $req){
        $data = Subcategory::find($req->id);
        $data->categoryId = $req->categoryId;
        $data->subCategoryName = $req->subCategoryName;
        $data->subCategoryCode = $req->subCategoryCode;
        $data->description = $req->description;
        $result = $data->save();
        if($result){
            return response([
                'message'=>'Subcategory Updated Successfully',
                'status'=> '201'
            ]);
        }else{
            return response([
                'message'=>'Something went wrong',
                'status' => '403'
            ]);
        }

    }
    public function subCategoryDeleteApi($id)
    {
        $data = Subcategory::find($id);
        if(!$data){
            return response([
                "message"=>'Subcategory doesnt exist',
                "status"=> 202
            ]);
        }else{
            $data->delete();
            return response([
                "message"=>'Subcategory deleted successfuly',
                "status"=> 201
            ]);
        }
    }
}
