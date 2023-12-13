<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employeeListApi()
    {
        $data = Employee::all();
        $employee = [];

        foreach ($data as $emp) {
            $fileName = $emp->image;
            $path = asset('/upload/image/' . $fileName);
            $emp->imgLink = $path;
            unset($emp->image);
            $employee[] = $emp;
        }
        return response([
            'employee' => $employee
        ]);
    }
    public function addEmployeeApi(Request $req)
    {
        $user = new Employee();
        $user->name = $req->name;
        $user->phoneNo = $req->phoneNo;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->designation = $req->designation;
        $user->salary = $req->salary;
        $user->jobType = $req->jobType;
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
                'message' => 'Successfully added an employee',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function editEmployeeFormApi($id){
        $data = Employee::find($id);
        return response([
           'employee'=> $data,    
        ]);
    
    }
    public function updateEmployeeApi(Request $req)
    {
        $user =Employee::find($req->id);
        $user->name = $req->name;
        $user->phoneNo = $req->phoneNo;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->designation = $req->designation;
        $user->salary = $req->salary;
        $user->jobType = $req->jobType;
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
                'message' => 'Successfully updated an employee',
                'status' => '201'
            ]);
        } else {
            return response([
                'message' => 'failed, Something Went Wrong',
                'status' => '202'
            ]);
        }
    }
    public function adminEmployeeDetailApi($id){
        $data = Employee::find($id);
        $fileName = $data->image;
        $path = asset('/upload/image/'. $fileName );
        // $path = public_path().'/image/upload/'.$fileName;
        // $file = Response::download($path);
        return response()->json([
            'employee'=> $data,
            'file'=> $path,
        ]);
    }
    public function employeeDeleteApi($id){
    
        $data = Employee::find($id);
        if(!$data){
            return response([
                "message"=>'employee doesnt exist',
                "status"=> 202
            ]);
        }else{
            $data->delete();
            return response([
                "message"=>'employee deleted successfuly',
                "status"=> 201
            ]);
        }
       
}
}
