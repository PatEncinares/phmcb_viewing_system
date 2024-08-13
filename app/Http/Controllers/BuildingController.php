<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index() {
        return view('master_data.building');
    }   
 
    public function get_records() {
        return response()->json([
            'data' => Building::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
          
        ],[
            'name.required' => 'Name is required',
        ]);
        $data = isset($request->id) ? Building::where('id', $request->id)->first() : new Building();
        $data->name = $request->name;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => Building::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = Building::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
