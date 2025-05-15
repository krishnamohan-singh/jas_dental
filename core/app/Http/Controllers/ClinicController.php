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

        // Load all doctors for this clinic
        $clinic->load('doctors.location');

        // Static content
        $sections = Page::where('tempname', activeTemplate())
            ->where('slug', 'doctors/all')
            ->firstOrFail();

        return view('templates.basic.clinics.show', compact(
            'clinic',
            'sections',
            'pageTitle'
        ));
    }
}

