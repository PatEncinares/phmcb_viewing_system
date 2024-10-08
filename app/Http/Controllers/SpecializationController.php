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
            'data' => Specialization::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
          
        ],[
            'name.required' => 'Specialization required',
        ]);
        $data = isset($request->id) ? Specialization::where('id', $request->id)->first() : new Specialization();
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
