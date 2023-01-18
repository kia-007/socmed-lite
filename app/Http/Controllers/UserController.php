<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $mail_check = User::where('email', $request->email)->first();
        if($mail_check != NULL){
            $pass_check = Crypt::decryptString($mail_check->password);
            $isTrue = ($request->password == $pass_check)?true:false;
            if($isTrue){
                $result = response()->json([
                    "message" => "Login Successfully",
                    "data" => [
                        "fullname" => $mail_check->name,
                        "email" => $mail_check->email
                    ]
                ], 200);
            }
            else{
                $result = response()->json([
                    "message" => "Wrong Password",
                    "data" => []
                ], 401);
            }
        }else{
            $result = response()->json([
                "message" => "No Email Found",
                "data" => []
            ], 401);
        }
        return $result;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if($validator->fails()){
            $result = response()->json([
                "message" => "Make sure your input are proper",
                "data" => []
            ], 403);
        }else{
            $mail_check = User::where('email', $request->email)->first();
            $username_check = User::where('username', $request->username)->first();
            if($mail_check == NULL && $username_check == NULL){
                $image_path = $request->file('image')->store('image', 'public');
                $user = new User;
                $user->image = $image_path;
                $user->fullname = $request->input('fullname');
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->password = Crypt::encryptString($request->input('password'));
                $whole_data = $user->getDirty();
                $sending = $user->save();
                if($sending){
                    $result = response()->json([
                        "message" => "Register Successfully",
                        "data" => $whole_data
                    ], 200);
                }else{
                    $result = response()->json([
                        "message" => "Register Failed",
                        "data" => []
                    ], 403);
                }
            }else{
                $result = response()->json([
                    "message" => "Email or  Username was Existing",
                    "data" => []
                ], 403);
            }
        }
        return $result;
    }
}
