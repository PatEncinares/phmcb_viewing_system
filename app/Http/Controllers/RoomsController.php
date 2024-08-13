<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Rooms;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
     public function index() {
        return view('master_data.rooms');
    }   
 
    public function get_records() {
        return response()->json([
            'data' => Rooms::leftJoin('buildings', 'buildings.id', 'rooms.building_id')
            ->select('rooms.*', 'buildings.name as building_name')
            ->get(),
            'buildings' => Building::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'building_id' => 'required',
            'name' => 'required|max:255',
          
        ],[
            'building_id.required' => 'Building is required',
            'name.required' => 'Name is required',
        ]);
        $data = isset($request->id) ? Rooms::where('id', $request->id)->first() : new Rooms();
        $data->building_id = $request->building_id;
        $data->name = $request->name;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => Rooms::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = Rooms::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }

}
