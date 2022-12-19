<?php

namespace App\Http\Controllers;

use App\Models\kritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class kritikSaranController extends Controller
{
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_user)
    {
        $kritikSaran = kritikSaran::where('id_user', $id_user)->get();

        if(!is_null($kritikSaran)){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $kritikSaran
            ], 200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }
    
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        $kritikSaran = $request->all();
        $validate = Validator::make($kritikSaran,[
            'content' => 'required',
        ]);

        if($validate->fails())
        return response([
            'error' => $validate->errors()
        ], 400);

        $kritikSaranCreated = kritikSaran::create($kritikSaran);

        if(is_null($kritikSaranCreated)){
            return response([
                'message' => 'Failed add the kritikSaran',
                'data' => null
            ], 404);
        }

        $kritikSaran = kritikSaran::where('id_user', $kritikSaranCreated->id_user)->get();
        return response([
            'message' => 'Succes making kritikSaran',
            'data' => $kritikSaran
        ], 200);
    }
    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {   
        $findkritikSaran = kritikSaran::find($id);
        if(is_null($findkritikSaran)){
            return response([
                'message' => 'kritikSaran Not Found',
                'data' => null
            ], 404);
        }

        $kritikSaran = $request->all();
        $validate = Validator::make($kritikSaran,[
            'content' => 'required',
        ]);

        if($validate->fails())
        return response([
            'error' => $validate->errors()
        ], 400);
    
        $findkritikSaran->content = $kritikSaran['content'];

        
        if($findkritikSaran->save()){
            $kritikSaran = kritikSaran::where('id_user', $findkritikSaran->id_user)->get();
            return response([
                'message' => 'Update kritikSaran Success',
                'data' => $kritikSaran
            ], 200);
        }
        return response([
            'message' => 'Update kritikSaran failed',
            'data' => null
        ], 500);
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id)
    {
        $kritikSaranDelete = kritikSaran::find($id);

        if(is_null($kritikSaranDelete)){
            return response([
                'message' => 'kritikSaran Not Found',
                'data' => null
            ], 404);
        }
        
        if($kritikSaranDelete->delete()){
            $kritikSaran = kritikSaran::where('id_user', $kritikSaranDelete->id_user)->get();
            return response([
                'message' => 'Delete kritikSaran Success',
                'data' => $kritikSaran
            ], 200);
        }

        return response([
            'message' => 'Delete kritikSaran Failed',
            'data' => null
        ], 500);
    }
}
