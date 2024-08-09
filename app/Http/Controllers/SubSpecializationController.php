<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\SubSpecialization;
use Illuminate\Http\Request;

class SubSpecializationController extends Controller
{
    public function index() {
        return view('master_data.subspecialization');
    }


    public function get_records() {
        return response()->json([
           'data' => SubSpecialization::leftJoin('specializations', 'specializations.id', 'sub_specializations.specialization_id')->select('sub_specializations.id', 'specializations.name as specialization_name', 'sub_specializations.name')->get(), 
           'specializations' => Specialization::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'specialization_id' => 'required',
            'name' => 'required',
        ],[
            'specialization_id.required' => 'Specialization field is required',
            'name.required' => 'Name field is required',
        ]);

        $data = isset($request->id) ? SubSpecialization::where('id', $request->id)->first() : new SubSpecialization(); 
        $data->specialization_id = $request->specialization_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Data Successfully Saved'], 200);
    }


    public function edit($id) {
        return response()->json([
            'data' => SubSpecialization::where('id', $id)->first(),
        ]);
    }


    public function destroy($id) {
        $data = SubSpecialization::where('id', $id)->first();
        if(!$data) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Record deleted successfully.'], 200);
    }
}
