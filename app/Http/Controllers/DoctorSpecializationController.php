<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use App\Models\SubSpecialization;
use Illuminate\Support\Facades\DB;

class DoctorSpecializationController extends Controller
{
    public function index() {
        return view('doctor_specialization');
    }   
 
    public function get_records() {
        return response()->json([
            'data' => DoctorSpecialization::leftJoin('doctor_details', 'doctor_details.id', 'doctor_specializations.doctor_detail_id')
             ->leftJoin('specializations', 'specializations.id', 'doctor_specializations.specialization_id')
             ->leftJoin('sub_specializations', 'sub_specializations.id', 'doctor_specializations.sub_specialization_id')
             ->select(
              'doctor_specializations.id', 
              DB::raw("CONCAT(doctor_details.last_name, ', ', doctor_details.first_name, ' ', doctor_details.middle_name)as full_name"),
              'specializations.name as specialization_name',
              'sub_specializations.name as sub_specialization_name')
              ->get(),

              'doctors' => DoctorDetails::select('id',DB::raw("CONCAT(last_name, ', ', first_name, ' ', middle_name)as full_name"))->get(),
              'specializations' => Specialization::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'doctor_detail_id' => 'required',
            'specialization_id' => 'required',
            // 'sub_specialization_id' => 'required',
        ],[
            'doctor_detail_id.required' => 'Doctor is required',
            'specialization_id.required' => 'Specialization  is required',
            // 'sub_specialization_id.required' => 'Sub Specialization is required',
        ]);
        $data = isset($request->id) ? DoctorSpecialization::where('id', $request->id)->first() : new DoctorSpecialization();
        $data->doctor_detail_id = $request->doctor_detail_id;
        $data->specialization_id = $request->specialization_id;
        $data->sub_specialization_id = $request->sub_specialization_id;
        $data->save();

    return response()->json(['message' => 'Data successfully added.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => DoctorSpecialization::first(),
        ]);
    }

    public function destroy($id) {
        $data = DoctorSpecialization::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }

    public function get_sub_specialization_by_specialization($id) {
        return response()->json(['data' => SubSpecialization::where('specialization_id', $id)->get()]);
    }
}
