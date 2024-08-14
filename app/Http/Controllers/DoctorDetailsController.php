<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorDetailsController extends Controller
{
    public function index() {
        return view('master_data.doctordetails');
    }   
 
    public function get_records() {
        return response()->json([
            'data' => DoctorDetails::select('id',DB::raw("CONCAT(last_name, ', ', first_name, ' ', middle_name)as full_name"), 'secretary_contact_number', 'status', 'schedule', 'remarks')->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'secretary_contact_number' => 'required|numeric|digits:11',
            'status' => 'required|string',
            // 'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'last_name.required' => 'Last name is required',
            'first_name.required' => 'First name  is required',
            // 'middle_name.required' => 'Middle name is required',
            // 'secretary_contact_number.required' => 'Secretary Contact Number is required',
            'status.required' => 'Status is required',
        ]);

        $exists = DoctorDetails::where('first_name', $request->first_name)
        ->where('middle_name', $request->middle_name)
        ->where('last_name', $request->last_name)
        ->exists();

        if ($exists) {
            return response()->json(['message' => 'A doctor with this full name already exists.'], 422);
        }
        
        $data = isset($request->id) ? DoctorDetails::where('id', $request->id)->first() : new DoctorDetails();
        $data->last_name = $request->last_name;
        $data->first_name = $request->first_name;
        $data->middle_name = $request->middle_name;
        $data->secretary_contact_number = $request->secretary_contact_number;
        $data->status = $request->status;   
        $data->schedule = $request->schedule;
        $data->remarks = $request->remarks;
        $data->save();

    //    // Check if file is present
    //    if ($request->hasFile('profile_image')) {
    //     $file = $request->file('profile_image');
    //     $filename = time() . '.' . $file->getClientOriginalExtension();
    //     $path = $file->storeAs('public/images', $filename); // Store in storage/app/public/images

    //     // Check if there is an existing file associated with this doctor
    //     $existingFile = Files::where('doctor_details_id', $data->id)->first();
    //     if ($existingFile) {
    //         // Delete the old file from storage
    //         Storage::delete('public/images/' . $existingFile->name);

    //         // Update the file record in the database
    //         $existingFile->name = $filename;
    //         $existingFile->save();
    //     } else {
    //         // Save new file information in the Files table
    //         Files::create([
    //             'doctor_details_id' => $data->id,
    //             'name' => $filename,
    //         ]);
    //     }
    // }

    return response()->json(['message' => 'Data successfully added.']);

    }

    public function edit($id) {
        return response()->json([
            'data' => DoctorDetails::where('id', $id)->first(),
        ]);
    }

    public function destroy($id) {
        $data = DoctorDetails::where('id', $id)->first();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        $data->delete();
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
