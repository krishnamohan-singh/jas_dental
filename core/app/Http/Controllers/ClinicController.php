<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Location;
use App\Models\Page;
use App\Models\Department;
use App\Traits\AppointmentManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    use AppointmentManager;
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

    public function show(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);
        $pageTitle = $clinic->name;
        

        // Paginate doctors (3 per page)
        $doctors = $clinic->doctors()->paginate(3);

        $sections = Page::where('tempname', activeTemplate())
            ->where('slug', 'doctors/all')
            ->firstOrFail();

        $availableDate = [];
        $date = Carbon::now();
        for ($i = 0; $i < $clinic->serial_day; $i++) {
            array_push($availableDate, date('Y-m-d', strtotime($date)));
            $date->addDays(1);
        }

        return view('templates.basic.clinics.show', compact(
            'clinic',
            'sections',
            'pageTitle',
            'availableDate',
            'doctors' // <-- Pass paginated doctors
        ));
    }

     public function booking($id = 0)
    {
        $dId = $id;
        try{
            $id = base64_decode($id);
            if (str_contains($id, '-')) { 
                $id = explode('-', $id)[0];
            }
        }catch(Exception $e){
            $id = $dId;
        }
        $clinic = Clinic::findOrFail($id);


        $pageTitle = $clinic->name . ' - Booking';
        $availableDate = [];
        $date = Carbon::now();
        for ($i = 0; $i < $clinic->serial_day; $i++) {
            array_push($availableDate, date('Y-m-d', strtotime($date)));
            $date->addDays(1);
        }
        return view('Template.basic.clinic.show',  compact('availableDate', 'clinic', 'pageTitle'));
    }


}

