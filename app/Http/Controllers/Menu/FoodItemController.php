<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;
use App\Models\FoodItem;
use App\Models\Review;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function getFoodItemApi()
    {
        $data = DB::table('food_items')
            ->leftJoin('categories', 'food_items.categoryId', '=', 'categories.id')
            ->leftJoin('subcategories', 'food_items.subCategoryId', '=', 'subcategories.id')
            ->select('food_items.*', 'categories.categoryName as categoryId', 'subcategories.subCategoryName as subCategoryId')
            ->get();
        $foodItem = [];
        // $review = Review::all();

        foreach ($data as $food) {
            $review = Review::where('foodId',$food->id)->avg('review');
            $fileName = $food->image;
            $path = asset('/upload/image/' . $fileName);
            $food->imgLink = $path;
            $food->review = $review;
            unset($food->image);
            unset($food->rating);
            $foodItem[] = $food;
        }
        return response([
            'foodItem' => $foodItem
        ]);
    }
    public function getSubcategoryId($id)
    {
        $data = Subcategory::where('categoryId', $id)->get();
        return response([
            'subCategory' => $data
        ]);
    }
    public function addFoodItemApi(Request $req)
    {
        $data = new FoodItem();
        $data->categoryId = $req->categoryId;
        $data->subCategoryId = $req->subCategoryId;
        $data->foodName = $req->foodName;
        $data->foodCode = $req->foodCode;
        $data->description = $req->description;
        $data->rating = $req->rating;
        $data->price = $req->price;
        if ($req->hasFile('image')) {
            $file = $req['image'];
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move('upload/image', $fileName);
            $data->image = $fileName;
        } else {
            unset($data['image']);
        }
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'FoodItem Added Sucessfully',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function editFoodItemFormApi($id)
    {
        $data = FoodItem::find($id);
        return response([
            'foodItem' => $data
        ]);
    }
    public function updateFoodItemApi(Request $req)
    {
        $data = FoodItem::find($req->id);
        $data->categoryId = $req->categoryId;
        $data->subCategoryId = $req->subCategoryId;
        $data->foodName = $req->foodName;
        $data->foodCode = $req->foodCode;
        $data->description = $req->description;
        $data->rating = $req->rating;
        $data->price = $req->price;
        if ($req->hasFile('image')) {
            $file = $req['image'];
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move('upload/image', $fileName);
            $data->image = $fileName;
        } else {
            unset($data['image']);
        }
        $result = $data->save();
        if ($result) {
            return response([
                'message' => 'FoodItem Updated Sucessfully',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function foodItemDeleteApi($id)
    {
        $data = FoodItem::find($id);
        if (!$data) {
            return response([
                "message" => 'Food Item doesnt exist',
                "status" => 202
            ]);
        } else {
            $data->delete();
            return response([
                "message" => 'Food Item deleted successfuly',
                "status" => 201
            ]);
        }
    }
    public function getDropdownApi()
    {

        $cat = Category::with('subcategories')->get();
        $catData = $cat->toArray();
        return response()->json([
            "category" => $catData
        ]);
    }
    public function getIp(Request $req)
    {

        $data = $req->getClientIp();
        return $data;
    }
    public function priority($id){
        $data = FoodItem::find($id);
        if($data->priority === "normal"||$data->priority === null){
            $data->priority = "special";
            $result = $data->save();
        }else{
            $data->priority = "normal";
            $result = $data->save();
        }

        if ($result) {
            return response([
                'message' => 'Priority has set Sucessfully',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function status($id){
        $data = FoodItem::find($id);
        if($data->status === "unavailable" || $data->status === null){
            $data->status = "available";
            $result = $data->save();
        }else{
            $data->status = "unavailable";
            $result = $data->save();
        }

        if ($result) {
            return response([
                'message' => 'Status has set Sucessfully',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }

}
