<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\SubSpecialization;

class SubSpecializationController extends Controller
{
    public function index() {
        return view('master_data.subspecialization');
    }   
 
    public function get_records() {
        return response()->json([
            'specializations' => Specialization::get(),
            'data' => SubSpecialization::leftJoin('specializations', 'specializations.id', 'sub_specializations.specialization_id')
            ->select('sub_specializations.*', 'specializations.name as specialization_name')
            ->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'specialization_id' => 'required',
            'name' => 'required|max:255',
          
        ],[
            'specialization_id.required' => 'Specialization is required',
            'name.required' => 'Sub Specialization required',
        ]);
        $data = isset($request->id) ? SubSpecialization::where('id', $request->id)->first() : new SubSpecialization();
        $data->specialization_id = $request->specialization_id;
        $data->name = $request->name;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => SubSpecialization::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = SubSpecialization::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
