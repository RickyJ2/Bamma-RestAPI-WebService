<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Http\Request;
use App\Models\userData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\ActivationMail;

class ResetPasswordController extends Controller
{
    public function index($id){
        $user = userData::find($id);

        if(is_null($user)){
            return view('resetPasswordPage')->with(['status' => 'User not found!']);
        }
        return view('resetPasswordPage')->with(['id'=> $id, 'status' => 'User']);
    }
    public function requestLink(Request $request){
        $username = $request->all();

        $validate = Validator::make($username,[
            'username' => 'required',
        ]);

        if($validate-> fails())
            return response(['error' => $validate-> errors()], 400);
        
        $user = userData::where('username',$username['username'])
            ->first();
        if(!is_null($user) && $user['activation']){
            try{
                $content =[
                    'body' => 'Reset Password',
                    'link' => config('constant.constant.mainLink') . 'resetPassword/' . $user->id,
                ];
                Mail::to($user->email)->send(new ActivationMail($content));
    
                return response([
                    'message' => 'Request reset password Success'
                ], 200); 
            }catch(Exception $e){
                return response([
                    'message' => 'Request reset password Failed'
                ], 405);
            }
        }
        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }
    public function resetPassword(Request $request, $id){
        $user = userData::find($id);

        if(is_null($user)){
            return view('resetPasswordPage')->with(['status' => 'User not found!']);
        }
        $newPassword = $request->all();
        $this->validate($request, [
            'password' => 'required|min:8'
        ]);

        $user->password = bcrypt($newPassword['password']);
        
        if($user->save()){
            return view('resetPasswordPage')->with(['status' => 'Reset password Success']);
        }

        return view('resetPasswordPage')->with(['status' => 'Reset password Failed!']);
    }
}
