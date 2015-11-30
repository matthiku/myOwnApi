<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFileRequest;

use Carbon\Carbon;

use App\File;

use File as FileManager;

class FileController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get a list of all files
        $data = File::all();

        return response()->json(['data' => $data], 200);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileRequest $request)
    {
        //
        $title = $request->get('title');
        $description = $request->get('description');

        $file = $request->file('file');

        // name of the folder we created to store uploaded files
        $path = '/files/';
        // create an random file name using the current time and with the appropriate file extension
        $name = sha1(Carbon::now()).'.'.$file->guessExtension();

        // move the file to the aforementioned folder
        $file->move(public_path().$path, $name);

        // create tha database table record for this new file
        $instance = File::create([
                'title' => $title,
                'description' => $description,
                'path' => $path.$name,
            ]);

        return response()->json(['data' => "The file {$instance->name} was created with id {$instance->id}"], 200);
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the existing file record
        $file = File::find($id);

        if ($file) 
        {
            return response()->json(['data' => $file], 200);
        }

        return response()->json(['message' => "A file record with id {$id} does not exist."], 404);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, $id)
    {
        // get the existing file record
        $file = File::find($id);

        if ($file) 
        {
            $file->title = $request->get('title');
            $file->description = $request->get('description');

            if ($request->hasFile('file')) {

                FileManager::delete(public_path().$file->path);

                $path = $this->storeFile($request);
                $file->path = $path;
            }

            $file->save();

            return response()->json(['data' => "The file with id {$file->id} was updated."], 201);
        }

        return response()->json(['message' => "A file record with id {$id} does not exist."], 404);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get the existing file record
        $file = File::find($id);

        if ($file) 
        {
            // get the file name and delete the local copy
            FileManager::delete(public_path().$file->path);

            // delete from the DB
            $file->delete();

            return response()->json(['data' => "The file with id {$file->id} was updated."], 201);
        }

        return response()->json(['message' => "A file record with id {$id} does not exist."], 404);
    }



    function storeFile($request)
    {
        $file = $request->file('file');

        $path = '/files/';
        $name = sha1(Carbon::now()).'.'.$path.$guessExtension();

        $file->move(public_path().$path, $name);

        return $path.$name;
    }

}
