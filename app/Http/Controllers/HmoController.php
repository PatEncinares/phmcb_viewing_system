<?php

namespace App\Http\Controllers;

use App\Models\Hmo;
use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use Illuminate\Support\Facades\DB;

class HmoController extends Controller
{
    public function index() {
        return view('master_data.hmo');
    }   
 
    public function get_records() {
        return response()->json([
            'data' => Hmo::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255'
          
        ],[
            'name.required' => 'Specialization required',
        ]);
        $data = isset($request->id) ? Hmo::where('id', $request->id)->first() : new Hmo();
        $data->name = $request->name;
        $data->save();

    return response()->json(['message' => 'Doctor added successfully.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => Hmo::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = Hmo::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
