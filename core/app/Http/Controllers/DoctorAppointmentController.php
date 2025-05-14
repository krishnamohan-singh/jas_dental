<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Location;
use App\Models\Page;
use App\Traits\AppointmentManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    use AppointmentManager;

    public function doctors(Request $request)
    {
        $pageTitle   = 'Our Doctors';
        $locations   = Location::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $departments = Department::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $doctors     = Doctor::active();
        if ($request->location) {
            $doctors = $doctors->where('location_id', $request->location);
        }
        if ($request->department) {
            $doctors = $doctors->where('department_id', $request->department);
        }
        if ($request->doctor) {
            $doctors = $doctors->where('id', $request->doctor);
        }

        $locationId = !empty($request->location) ? $request->location : 0;
        $locationName = !empty($request->area) ? $request->area : "";
        

        $doctors = $doctors->orderBy('id', 'DESC')->with('department', 'location')->paginate(getPaginate());
        $sections       = Page::where('tempname', activeTemplate())->where('slug', 'doctors/all')->firstOrFail();
        return view('Template::search', compact('pageTitle', 'locations', 'departments', 'doctors', 'sections','locationId','locationName'));
    }

    public function locations($location)
    {
        $pageTitle   = 'Location wise Doctors';
        $locations   = Location::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $departments = Department::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $doctors     = Doctor::active()->where('location_id', $location)->orderBy('id', 'DESC')->with('department', 'location')->paginate(getPaginate());
        $locationId = 0;
        $locationName = "";
        return view('Template::search', compact('pageTitle', 'locations', 'departments', 'doctors','locationId','locationName'));
    }

    public function departments($department)
    {
        $pageTitle   = 'Department wise Doctors';
        $locations   = Location::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $departments = Department::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $doctors     = Doctor::active()->where('department_id', $department)->orderBy('id', 'DESC')->with('department', 'location')->paginate(getPaginate());
        $locationId = 0;
        $locationName = "";
        return view('Template::search', compact('pageTitle', 'locations', 'departments', 'doctors','locationId','locationName'));
    }

    public function featured()
    {
        $pageTitle   = 'All featured Doctors';
        $locations   = Location::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $departments = Department::orderBy('id', 'DESC')->whereHas('doctors')->get();
        $doctors     = Doctor::active()->where('featured', Status::YES)->orderBy('id', 'DESC')->with('department', 'location')->paginate(getPaginate());
        $locationId = 0;
        $locationName = "";
        return view('Template::search', compact('pageTitle',  'locations', 'departments', 'doctors','locationId','locationName'));
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
        $doctor = Doctor::findOrFail($id);

        if (!$doctor->status) {
            $notify[] = ['error', 'This doctor is inactive!'];
            return to_route('doctors.all')->withNotify($notify);
        }

        $pageTitle = $doctor->name . ' - Booking';
        $availableDate = [];
        $date = Carbon::now();
        for ($i = 0; $i < $doctor->serial_day; $i++) {
            array_push($availableDate, date('Y-m-d', strtotime($date)));
            $date->addDays(1);
        }
        return view('Template::booking',  compact('availableDate', 'doctor', 'pageTitle'));
    }
}
