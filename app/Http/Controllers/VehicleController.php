<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Vehicle;

class VehicleController extends Controller
{

    /**
     * Display a full listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$vehicles = Vehicle::all();
        // return all vehciles
        return response()->json(['data' => $vehicles], 200);
    }


    public function vehiclesFull($id = null)
    { 
        if ($id === null) {
            $vehicles = Vehicle::with('type','maker')->get();
        } else {
            $vehicles = Vehicle::with('type','maker');dd($vehicles);
              //  ->where('serie', $id)
                //->get();
        }

        return response()->json(['data' => $vehicles], 200);
    }

}
