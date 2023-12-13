<?php

namespace App\Http\Controllers;

use App\Models\Press;

use Illuminate\Http\Request;

class PressController extends Controller
{
    public function pressListApi()
    {
        $data = Press::all();
        $pressItem = [];

        foreach ($data as $press) {
            $fileName = $press->image;
            $path = asset('/upload/image/' . $fileName);
            $press->imgLink = $path;
            unset($press->image);
            $pressItem[] = $press;
        }
        return response([
            'press' => $pressItem
        ]);
    }
    public function addPressApi(Request $req)
    {
        $user = new Press();
        $user->eventName = $req->eventName;
        $user->eventDate = $req->eventDate;
        $user->description = $req->description;
        if ($file = $req->file('image')) {
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move('upload/image', $fileName);
            $user->image = $fileName;
        } else {
            unset($user['image']);
        }
        $result = $user->save();
        if ($result) {
            return response([
                'message' => 'Successfully added an event',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function editPressFormApi($id)
    {
        $data = Press::find($id);
        return response([
            'press' => $data,
        ]);
    }
    public function updatePressApi(Request $req)
    {
        $user = Press::find($req->id);
        $user->eventName = $req->eventName;
        $user->eventDate = $req->eventDate;
        $user->description = $req->description;
        if ($file = $req->file('image')) {
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move('upload/image', $fileName);
            $user->image = $fileName;
        } else {
            unset($user['image']);
        }
        $result = $user->save();
        if ($result) {
            return response([
                'message' => 'Successfully updated an event',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function pressDeleteApi($id)
    {

        $data = Press::find($id);
        if (!$data) {
            return response([
                "message" => 'employee doesnt exist',
                "status" => 202
            ]);
        } else {
            $data->delete();
            return response([
                "message" => 'employee deleted successfuly',
                "status" => 201
            ]);
        }
    }
}
