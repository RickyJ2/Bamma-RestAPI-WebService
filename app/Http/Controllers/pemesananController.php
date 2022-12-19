<?php

namespace App\Http\Controllers;

use App\Models\pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pemesananController extends Controller
{
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_user)
    {
        $pemesanan = pemesanan::where('id_user', $id_user)->get();

        if(!is_null($pemesanan)){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pemesanan
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
        $pemesanan = $request->all();
        $validate = Validator::make($pemesanan,[
            'id_user' => 'required',
            'id_mobil' => 'required',
            'tgl_pengembalian' => 'required',
            'tgl_peminjaman' => 'required',
        ]);

        if($validate->fails())
        return response([
            'error' => $validate->errors()
        ], 400);

        $pemesanan['status'] = 0;
        $pemesananCreated = pemesanan::create($pemesanan);

        if(is_null($pemesananCreated)){
            return response([
                'message' => 'Failed add the pemesanan',
                'data' => null
            ], 404);
        }

        $pemesanan = pemesanan::where('id_user', $pemesananCreated->id_user)->get();
        return response([
            'message' => 'Succes making pemesanan',
            'data' => $pemesanan
        ], 200);
    }
    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {   
        $findpemesanan = pemesanan::find($id);
        if(is_null($findpemesanan)){
            return response([
                'message' => 'pemesanan Not Found',
                'data' => null
            ], 404);
        }

        $pemesanan = $request->all();
        $validate = Validator::make($pemesanan,[
            'id_user' => 'required',
            'id_mobil' => 'required',
            'tgl_pengembalian' => 'required',
            'tgl_peminjaman' => 'required',
        ]);

        if($validate->fails())
        return response([
            'error' => $validate->errors()
        ], 400);
        
        $findpemesanan->id_user = $pemesanan['id_user'];
        $findpemesanan->id_mobil = $pemesanan['id_mobil'];
        $findpemesanan->tgl_pengembalian = $pemesanan['tgl_pengembalian'];
        $findpemesanan->tgl_peminjaman = $pemesanan['tgl_peminjaman'];

        $pemesanan = pemesanan::where('id_user', $findpemesanan->id_user)->get();
        if($findpemesanan->save()){
            return response([
                'message' => 'Update pemesanan Success',
                'data' => $pemesanan
            ], 200);
        }
        return response([
            'message' => 'Update pemesanan failed',
            'data' => null
        ], 500);
    }
}
