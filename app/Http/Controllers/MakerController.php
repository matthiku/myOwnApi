<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\Maker;
use App\Vehicle;
use App\Http\Requests\CreateMakerRequest;

// to use caching of requests:
use Illuminate\Support\Facades\Cache;

class MakerController extends Controller
{


    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // un-cached version:
        //$makers = Maker::all();
        // cached version: (cached for 15 seconds)
        $makers = Cache::remember('makers', 15/60, 
            function() {
                return Maker::simplePaginate(15);
            });
        //
        return response()->json(['next' => $makers->nextPageUrl(), 'previous' => $makers->previousPageUrl(), 'data' => $makers->items()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * CreateMakerRequest is defined in the respective class under Requests!
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMakerRequest $request)
    {
        //var_dump($request);die();
        $values = $request->only(['name', 'phone']);


        // prevent creation of another maker with the same name
        $name = $request->get('name');
        $maker = Maker::where('name', $name)->first();
        // alternative way....
        //$search = DB::select('select * from makers where name = ?', [$name]);
        //if ( sizeof($search) > 0 ) {
        if ( $maker ) {
            return response()->json(['message' => 'This maker already exists!', 'code' => 404], 404 );
        }

        $result = Maker::create($values);
        //var_dump($result);die();

        return response()->json(['message' => "Maker correctly added", 'id' =>  $result->id, 'code' => 201], 201);

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $maker = Maker::find($id);

        if (!$maker) {
            return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404 );
        }

        return response()->json(['data' => $maker], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * Using our own object (CreateMakerRequest) where we can make the validations
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMakerRequest $request, $id)
    {
        // verify first if this maker exists
        $maker = Maker::find($id);
        if (!$maker) {
            return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404 );
        }

        $name  = $request->get('name');
        $phone = $request->get('phone');

        $maker->name  = $name;
        $maker->phone = $phone;

        $maker->save();

        return response()->json(['message' => 'The maker has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // verify first if this maker exists
        $maker = Maker::find($id);
        if (!$maker) {
            return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404 );
        }
        // Also check if ther are linked vehicles to this maker
        $vehicles = $maker->vehicles;
        //var_dump($vehicles);die();
        if ( sizeof($vehicles) > 0 ) {
            return response()->json(['message' => 'This maker has linked vehicles - delete vehicles first', 'code' => 409], 409 );
        }

        $maker->delete();

        return response()->json(['message' => 'The maker has been deleted', 'code' => 200], 200);
    }
}
