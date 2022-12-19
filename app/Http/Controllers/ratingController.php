<?php

namespace App\Http\Controllers;

use App\Models\rating;
use Illuminate\Http\Request;

class ratingController extends Controller
{
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function get( Request $request, $id_user)
    {
        $rating = rating::where('id_user', $id_user)->where('id_mobil', $request->id_mobil)->first();

        if(!is_null($rating)){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $rating
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
        $rating = $request->all();
        $findRating = rating::where('id_user', $request->id_user)->where('id_mobil', $request->id_mobil)->first();
        if(is_null($findRating)){
            $ratingCreated = rating::create($rating);
        }else{
            $findRating->rating = $request->rating;
            if($findRating->save()){
                return response([
                    'message' => 'Update Rating Success',
                    'data' => $findRating
                ], 200);
            }
            return response([
                'message' => 'Update rating failed',
                'data' => null
            ], 500);
        }
        
        $rating = rating::where('id_user', $ratingCreated->id_user)->get();
        return response([
            'message' => 'Succes giving rating',
            'data' => $rating
        ], 200);
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id)
    {
        $findRating = rating::find($id);
        if(is_null($findRating)){
            return response([
                'message' => 'Rating Not Found',
                'data' => null
            ], 404);
        }
        $rating = rating::where('id_user', $findRating->id_user)->get();
        if($findRating->delete()){
            return response([
                'message' => 'Delete Rating Success',
                'data' => $rating
            ], 200);
        }
        return response([
            'message' => 'Delete rating failed',
            'data' => null
        ], 500);
    }
}
