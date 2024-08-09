<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

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
            'name' => 'required',
        ],[
            'name.required' => 'Name field is required',
        ]);

        $data = isset($request->id) ? Specialization::where('id', $request->id)->first() : new Specialization(); 
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Data Successfully Saved'], 200);
    }


    public function edit($id) {
        return response()->json([
            'data' => Specialization::where('id', $id)->first(),
        ]);
    }


    public function destroy($id) {
        $data = Specialization::where('id', $id)->first();
        if(!$data) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Record deleted successfully.'], 200);
    }
}
