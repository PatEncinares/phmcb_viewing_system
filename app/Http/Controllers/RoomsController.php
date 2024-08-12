<?php

namespace App\Http\Controllers;

use App\Models\DoctorDetails;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
 
    public function index() {
        return view('master_data.rooms');
    }   
 
    public function get_records() {
        return response()->json([
            'doctors' => DoctorDetails::select('id', DB::raw("CONCAT(last_name, ',', first_name, ' ', middle_name) as full_name"))->get(),
            'data' => Rooms::leftJoin('doctor_details', 'doctor_details.id', 'rooms.doctor_detail_id')
            ->select('rooms.*', DB::raw("CONCAT(doctor_details.last_name, ',', doctor_details.first_name, ' ', doctor_details.middle_name) as full_name"))
            ->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'doctor_detail_id' => 'required',
            'building_name' => 'required|max:255',
            'room_number' => 'required|max:255',
          
        ],[
            'doctor_detail_id.required' => 'Doctor is required',
            'building_name.required' => 'Building is required',
            'room_number.required' => 'Room Number is required',
        ]);
        $data = isset($request->id) ? Rooms::where('id', $request->id)->first() : new Rooms();
        $data->doctor_detail_id = $request->doctor_detail_id;
        $data->building_name = $request->building_name;
        $data->room_number = $request->room_number;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => Rooms::leftJoin('doctor_details', 'doctor_details.id', 'rooms.doctor_detail_id')
            ->where('rooms.id', $id)
            ->select('rooms.id', 'rooms.doctor_detail_id', 'rooms.building_name', 'rooms.room_number')
            ->first(),
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
