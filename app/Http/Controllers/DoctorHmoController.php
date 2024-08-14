<?php

namespace App\Http\Controllers;

use App\Models\Hmo;
use App\Models\DoctorHmo;
use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use Illuminate\Support\Facades\DB;

class DoctorHmoController extends Controller
{
    public function index() {
        return view('doctor_hmo');
    }   
 
    public function get_records() {
        $data = DoctorHmo::leftJoin('doctor_details', 'doctor_details.id', 'doctor_hmos.doctor_detail_id')
            ->leftJoin('hmos', 'hmos.id', 'doctor_hmos.hmo_id')
            ->select(
            'doctor_hmos.doctor_detail_id',
            DB::raw("CONCAT(doctor_details.last_name, ', ', doctor_details.first_name, ' ', doctor_details.middle_name)as full_name"),
            DB::raw("GROUP_CONCAT(hmos.name SEPARATOR ' | ') as hmos"))
            ->groupBy(
                'doctor_hmos.doctor_detail_id',
                'doctor_details.last_name',
                'doctor_details.first_name',
                'doctor_details.middle_name'
            )
            ->get()
            ->map(function ($item) {
                $item->hmos = str_replace(', ', ',   ', $item->hmos); // Add more spacing if needed
                return $item;
            });

        return response()->json([
            'data' => $data,
            'doctors' => DoctorDetails::select('id',DB::raw("CONCAT(last_name, ', ', first_name, ' ', middle_name)as full_name"))->get(),
            'master_data_hmos' => Hmo::get(),
            
        ]);
    }

    public function store(Request $request) {
        $request->validate([
           'doctor_detail_id' => 'required|exists:doctor_details,id',
            'selectedHmos' => 'required',
        ],[
            'doctor_detail_id.required' => 'Doctor is required',
            'selectedHmos.required' => 'Health Maintenance Organizations are required',
        ]);

        DoctorHmo::where('doctor_detail_id', $request->doctor_detail_id)->delete();

        foreach($request->selectedHmos as $item) {
            $data = new DoctorHmo();
            $data->doctor_detail_id = $request->doctor_detail_id;
            $data->hmo_id = $item;
            $data->save();
        } 
       

    return response()->json(['message' => 'Doctor added successfully.']);

    }

   public function edit($id) {
    $doctorHmos = DoctorHmo::where('doctor_detail_id', $id)->get();
    if ($doctorHmos->isEmpty()) {
        return response()->json(['error' => 'No HMOs found for this doctor'], 404);
    }

    return response()->json([
        'data' => [
            'doctor_detail_id' => $doctorHmos[0]['doctor_detail_id'],
            'hmos' => $doctorHmos->pluck('hmo_id')->toArray(), // Collect all associated HMO IDs
            'master_data_hmos' => Hmo::get(),
        ],
    ]);
}

    public function destroy($id) {
        $data = DoctorHmo::where('doctor_detail_id', $id)->get();

        if(!$data) {
            return response()->json([
                'message' => 'No Record Found',
            ]);
        }

        foreach($data as $item) {
            $item->delete();
        }
        return response()->json(['message' => 'Data successfully deleted',]);
    }
}
