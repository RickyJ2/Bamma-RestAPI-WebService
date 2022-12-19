<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\daftarMobil;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class daftarMobilController extends Controller
{
    public function index()
    {
        $daftarMobil = daftarMobil::all();

        if(count($daftarMobil) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $daftarMobil
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
        $daftarMobil = daftarMobil::find($id);

        if(!is_null($daftarMobil)){
            return response([
                'message' => 'Retrieve daftarMobil Success',
                'data' => $daftarMobil
            ], 200);
        }
        
        return response([
            'message' => 'daftarMobil Not Found',
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
        $mobilData = $request-> all();
        $validate = Validator::make($mobilData, [
            'id_cabang' => 'required',
            'model'=> 'required|max:60',
            'tipe'=> ['required', Rule::in(['Manual', 'Matic'])],
            'kapasitas'=> 'required|numeric',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'image' => 'required|image:jpeg,png,jpg,svg| max: 2048'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $uploadFolder = 'mobils';
        $image = $request->file('image');
        $mobilData['image'] = $image->store($uploadFolder, 'public');

        $daftarMobil = daftarMobil::create($mobilData);

        return response([
            'message' => 'Adding Data DaftarMobil Success',
            'data' => $daftarMobil
        ], 200);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $daftarMobil = daftarMobil::find($id);

        if(is_null($daftarMobil)){
            return response([
                'message' => 'Data Mobil Not Found',
                'data' => null
            ], 404);
        }
        
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_cabang' => 'required',
            'model'=> 'required|max:60',
            'tipe'=> ['required', Rule::in(['Manual', 'Matic'])],
            'kapasitas'=> 'required|numeric',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'image' => 'required|image:jpeg,png,jpg,svg| max: 2048'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $daftarMobil->id_cabang = $updateData['id_cabang'];
        $daftarMobil->model = $updateData['model'];
        $daftarMobil->tipe = $updateData['tipe'];
        $daftarMobil->kapasitas = $updateData['kapasitas'];
        $daftarMobil->harga = $updateData['harga'];
        $daftarMobil->deskripsi = $updateData['deskripsi'];
        $daftarMobil->image = $updateData['image'];

        if($daftarMobil->save()){
            return response([
                'message' => 'Update Data Mobil Success',
                'data' => $daftarMobil
            ], 200);
        }

        return response([
            'message' => 'Update Data Mobil Failed',
            'date' => null
        ], 500);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id)
    {
        $daftarMobil = daftarMobil::find($id);

        if(is_null($daftarMobil)){
            return response([
                'message' => 'daftarMobil Not Found',
                'data' => null
            ], 404);
        }

        if($daftarMobil->delete()){
            return response([
                'message' => 'Delete daftarMobil Success',
                'data' => $daftarMobil
            ], 200);
        }

        return response([
            'message' => 'Delete daftarMobil Failed',
            'data' => null
        ], 500);
    }
}
