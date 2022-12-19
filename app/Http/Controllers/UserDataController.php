<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Http\Request;
use App\Models\userData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\ActivationMail;

class UserDataController extends Controller
{   
    public function register(Request $request){
        $registrationData = $request-> all();
        $validate = Validator::make($registrationData, [
            'username' => 'required|max:60|unique:user_data',
            'email' => 'required|email:rfc, dns',
            'password' => 'required|min:8',
            'dateOfBirth' => 'required',  
            'handphone' => 'required',
        ]);

        if($validate->fails())
            return response([
                'error' => $validate->errors()
            ], 400);

        $registrationData['password'] = bcrypt($request->password);
        $registrationData['activation'] = false;

        $user = userData::create($registrationData);

        try{
            $content =[
                'body' => 'Aktivasi Akun',
                'link' => config('constant.constant.mainLink') . 'activation/' . $user->id,
            ];
            Mail::to($user->email)->send(new ActivationMail($content));

            return response([
                'message' => 'Register Success'
            ], 200); 
        }catch(Exception $e){
            return response([
                'message' => 'Register Success, Email Activation Failed send',
            ], 405);
        }
    }
    public function login(Request $request){
        $loginData = $request->all();

        $validate = Validator::make($loginData,[
            'username' => 'required',
            'password' => 'required'
        ]);
        
        if($validate-> fails())
            return response(['error' => $validate-> errors()],400);

        $user = userData::where('username',$loginData['username'])
            ->first();

        if(!is_null($user) && Hash::check($loginData['password'], $user['password'])){
            if($user['activation']){
                return response([
                    'message' => 'Login User Success',
                    'data' => $user
                ], 200);
            }else{
                return response([
                    'message' => 'User not Actived yet',
                    'data' => null
                ], 400);
            }
        }
        
        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }
    public function show($id)
    {
        $user = userData::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }
        
        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }
    public function update(Request $request, $id)
    {
        $user = userData::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }
        
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username' => 'required|max:60|unique:user_data,username,'.$id,
            'email' => 'required|email:rfc, dns',
            'dateOfBirth' => 'required',  
            'handphone' => 'required',
        ]);

        if($validate->fails())
            return response(['error' => $validate->errors()], 400);
        
        $user->username = $updateData['username'];
        $user->email = $updateData['email'];
        $user->dateOfBirth = $updateData['dateOfBirth'];
        $user->handphone = $updateData['handphone'];

        if($user->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 500);
    }
    public function updateProfileImage(Request $request, $id){
        $user = userData::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }
        
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'image' => 'required|image:jpeg,png,jpg,svg| max: 2048',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $uploadFolder = 'users';
        $image = $request->file('image');
        $updateData['image'] = $image->store($uploadFolder, 'public');
        
        $user->image = $updateData['image'];

        if($user->save()){
            return response([
                'message' => 'Update Image Profile User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Image Profile User Failed',
            'data' => null
        ], 500);
    }
}
