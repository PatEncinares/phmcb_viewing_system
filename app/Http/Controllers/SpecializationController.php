<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    public function index() {
        return view('master_data.specialization');
    }   
 
    public function get_records() {
        return response()->json([
            'doctors' => DoctorDetails::select('id', DB::raw("CONCAT(last_name, ',', first_name, ' ', middle_name) as full_name"))->get(),
            'data' => Specialization::leftJoin('doctor_details', 'doctor_details.id', 'specializations.doctor_detail_id')
            ->select('specializations.*', DB::raw("CONCAT(doctor_details.last_name, ',', doctor_details.first_name, ' ', doctor_details.middle_name) as full_name"))
            ->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'doctor_detail_id' => 'required',
            'name' => 'required|max:255',
          
        ],[
            'doctor_detail_id.required' => 'Doctor is required',
            'name.required' => 'Specialization required',
        ]);
        $data = isset($request->id) ? Specialization::where('id', $request->id)->first() : new Specialization();
        $data->doctor_detail_id = $request->doctor_detail_id;
        $data->name = $request->name;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => Specialization::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = Specialization::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
