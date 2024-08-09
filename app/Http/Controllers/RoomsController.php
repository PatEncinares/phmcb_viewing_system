<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function index() {
        return view('master_data.Rooms');
    }


    public function get_records() {
        return response()->json([
           'data' => Rooms::get(), 
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'building_name' => 'required',
            'name' => 'required',
        ],[
            'building_name.required' => 'Building name field is required',
            'name.required' => 'Name field is required',
        ]);

        $data = isset($request->id) ? Rooms::where('id', $request->id)->first() : new Rooms(); 
        $data->building_name = $request->building_name;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Data Successfully Saved'], 200);
    }


    public function edit($id) {
        return response()->json([
            'data' => Rooms::where('id', $id)->first(),
        ]);
    }


    public function destroy($id) {
        $data = Rooms::where('id', $id)->first();
        if(!$data) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Record deleted successfully.'], 200);
    }
}
