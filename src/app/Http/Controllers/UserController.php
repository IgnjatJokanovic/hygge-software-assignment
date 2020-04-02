<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use JWTAuth;


class UserController extends Controller
{
   
    public function store()
    {
       $validator = Validator::make(request()->all(), [
           'name' => 'required|alpha',
           'email' => 'required|email',
           'password' => 'required|alpha_num'
       ]);
       if($validator->fails()){
            $errors = array();
            foreach($validator->errors()->all() as $error)
            {
                array_push($errors, $error);
            }
            return response()->json(["messages" => $errors], 422);
       }else{
            $user = new User();
            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = bcrypt(request()->password);
            if($user->save()){
                return response()->json("Sucessfully registered", 201);
            }else{
                return response()->json("Something went wrong", 422);
            }
       }
        
    }

    public function login(){
        $credentials = request()->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|alpha_num'
        ]);
        if($validator->fails()){
            $errors = array();
            foreach($validator->errors()->all() as $error)
            {
                array_push($errors, $error);
            }
            return response()->json(["messages" => $errors], 422);
        }else{
            $token = auth()->attempt($credentials);
            dd($token);
            if($token){
                return response()->json(['token' => $token], 202);
            }else {
                return response()->json(['messages' => ['Invalid username or password']], 401);
            }
        }
    }

    public function sendFriendRequest(){
        $to = User::find(request()->firendId);
        $from = JWTAuth::parseToken()->authenticate();
        if($to != null){
            if($from->friends->contains($to)){
                return response()->json("Request Already sent", 422); 
            }else{
                $from->friends()->attach($to, ['status' => 0]);
                return response()->json("Friend request sent to $to->name");
            }
        }else{
            return response()->json("User doesent exist", 404);
        }
       
       
    }

    public function friendAction(){
        $user = JWTAuth::parseToken()->authenticate();
        $sender = request()->id;
        $tmp = $user->friends()->where('user_id', $sender)->first();
        $tmp->pivot->status = request()->action;
        $tmp->pivot->save();
        return response()->json("Success", 201);
       
    }

}
