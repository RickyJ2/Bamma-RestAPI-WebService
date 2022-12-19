<?php

namespace App\Http\Controllers;
use App\Models\cabang;
use Illuminate\Http\Request;

class cabangController extends Controller
{
    public function index(){
        $cabang = cabang::all();
        if(count($cabang) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $cabang
            ], 200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id)
    {
        $cabang = cabang::find($id);

        if(!is_null($cabang)){
            return response([
                'message' => 'Retrieve cabang Success',
                'data' => $cabang
            ], 200);
        }
        
        return response([
            'message' => 'cabang Not Found',
            'data' => null
        ], 404);
    }
}
