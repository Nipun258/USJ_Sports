<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function UserView()
    {   //$allData = User::all();
    	$data['allData'] = User::all();

    	return view('backend.user.view',$data);
    }

    public function UserAdd()
    {
    	return view('backend.user.add');
    }

    public function UserStore(Request $request)
    {
    	$validatedData = $request->validate([
    		'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|confirmed|min:8',
    	]);

    	$data = new User();

    	$data->usertype = $request->usertype;
    	$data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();
        
        $notification = array(
           'message' => 'User Inserted Successfully',
           'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notification);
    }

    public function UserEdit($id)
    {
    	$editData = User::find($id);
    	return view('backend.user.edit',compact('editData'));
    }

    public function UserUpdate(Request $request,$id){
       
        $validatedData = $request->validate([
    		'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|confirmed|min:8',
    	]);

    	$data = User::find($id);

    	$data->usertype = $request->usertype;
    	$data->name = $request->name;
        $data->email = $request->email;
        $data->save();
        
        $notification = array(
           'message' => 'User Updated Successfully',
           'alert-type' => 'info'
        );

        return redirect()->route('user.view')->with($notification);
    }

    public function UserDelete($id){

    	$user = User::find($id);
    	$user->delete();

    	$notification = array(
           'message' => 'User Deleted Successfully',
           'alert-type' => 'error'
        );

        return redirect()->route('user.view')->with($notification);
    }
}
