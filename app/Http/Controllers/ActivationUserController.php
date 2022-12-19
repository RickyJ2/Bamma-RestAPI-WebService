<?php

namespace App\Http\Controllers;

use App\Models\userData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ActivationUserController extends Controller
{
    public function index($id){
        $user = userData::find($id);

        if(is_null($user)){
            return view('activationPage')->with(['status' => 'Activation Failed!']);
        }

        $user->activation = true;
        if($user->save()){
            return view('activationPage')->with(['status' => 'Activation Success!']);
        }

        return view('activationPage')->with(['status' => 'Activation Failed!']);
    }
}
