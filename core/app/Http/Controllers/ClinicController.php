<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\ClinicDepartmentDoctor;
use App\Models\Doctor;
use App\Models\Location;
use App\Models\Page;
use App\Models\Department;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    // Display a list of clinics with optional location filtering
    public function index(Request $request)
    {
        $pageTitle   = 'Our Clincs';
        $locations   = Location::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $departments = Department::orderBy('id', 'DESC')->whereHas('doctors')->get();
        
        // Initialize the query to fetch clinics
        $clinicsQuery = Clinic::with('location'); // Include location details for each clinic

        // Apply location filter if specified
        if ($request->has('location') && !empty($request->location)) {
            $clinicsQuery->where('location_id', $request->location);
        }

        // Fetch the clinics with pagination (12 per page)
        $clinics = $clinicsQuery->paginate(12);

        // Fetch all locations for the location filter dropdown
        $locations = Location::all();

        // Return the view with clinics and locations data
        $sections       = Page::where('tempname', activeTemplate())->where('slug', 'doctors/all')->firstOrFail();
        return view('templates.basic.clinics.index', compact('clinics', 'locations','sections','pageTitle','departments'));
    }

    // Show clinic details including departments and doctors (via JSON pivot)
    public function show(Clinic $clinic)
    {
        $pageTitle = 'Our Doctors';

        $departments = Department::orderBy('id', 'desc')->whereHas('doctors')->get();

        // dd($clinic->id);
        // Load departments and related doctors using the JSON pivot structure
        $clinicDepartments = ClinicDepartmentDoctor::where('clinic_id', $clinic->id)->get();

        $departmentDoctors = [];


        foreach ($clinicDepartments as $entry) {
            $department = Department::find($entry->department_id);
            if (!$department) continue;


            // Decode doctor_ids safely and query doctors
            // $doctorIds = json_decode($entry->doctor_ids, true) ?? [];
            $doctorIds = Doctor::where('id', $entry->doctor_id)->get();


            // $doctors = !empty($doctorIds) ? Doctor::whereIn('id', $doctorIds)->get() : collect(); // empty collection if no doctors
            $departmentDoctors[] = [
                'department' => $department,
                'doctors'    => $doctorIds
            ];
        }

        // dd($departmentDoctors);
        // dd($departmentDoctors);

        $sections = Page::where('tempname', activeTemplate())
            ->where('slug', 'doctors/all')
            ->firstOrFail();

        // dd($departmentDoctors);

        return view('templates.basic.clinics.show', compact(
            'clinic',
            'sections',
            'pageTitle',
            'departments',
            'departmentDoctors'
        ));
    }
}
