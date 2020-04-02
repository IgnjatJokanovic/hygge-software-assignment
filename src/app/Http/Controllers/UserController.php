<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
   
    public function store()
    {
        // dd(request()->all());
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = request()->password;
        if($user->save()){
            return response()->json("Sucessfully registered", 201);
        }else{
            return response()->json("Something went wrong", 402);
        }
    }

    public function login(){

    }

    public function sendFriendRequest(){

    }

    public function friendAction(){

    }

}
