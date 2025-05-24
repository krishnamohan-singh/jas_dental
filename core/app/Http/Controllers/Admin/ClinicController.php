<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\FileManager;
use App\Models\Clinic;
use App\Models\Location;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClinicController extends Controller
{
    public function index()
    {
        $pageTitle = "All Clinics";
        $emptyMessage = "No Clinics Found";

        $clinics = Clinic::with('location')->latest()->paginate(getPaginate());
        $locations = Location::orderBy('name')->get();

        return view('admin.clinic.index', compact('pageTitle', 'emptyMessage', 'clinics', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'map_location' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $clinic = new Clinic();

        if ($request->hasFile('image')) {
            try {
                $clinic->photo = fileUploader($request->image, getFilePath('clinic'), getFileSize('clinic'), $clinic->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $clinic->name = $request->name;
        $clinic->email = $request->email;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->location_id = $request->location_id;
        $clinic->status = $request->status;
        $clinic->map_location = $request->map_location;
        $clinic->fees = $request->consultation_fee;
        $clinic->save();

        $notify[] = ['success', 'Clinic added successfully'];
        return back()->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'map_location' => 'nullable|string',
            'status' => 'required|in:0,1',
            'consultation_fee' => 'required|numeric|min:0'
        ]);


        if ($request->hasFile('image')) {
            try {
                $fileManager = new FileManager($request->file('image'));
                $fileManager->path = getFilePath('clinic');
                $fileManager->size = getFileSize('clinic');

                $fileManager->old = $clinic->photo;

                $fileManager->upload();

                $clinic->photo = $fileManager->filename;
            } catch (Exception $e) {
                Log::error('error in updating image:', ['error' => $e->getMessage()]);
            }
        }

        Log::info($clinic->photo);

        $clinic->name = $request->name;
        $clinic->email = $request->email;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->location_id = $request->location_id;
        $clinic->map_location = $request->map_location;
        $clinic->fees = $request->consultation_fee;
        $clinic->status = $request->status;

        // $clinic->slot_type = $request->slot_type;

        // $clinic->serial_or_slot = $request-> serial_or_slot;
        // $clinic->start_time = $request->start_time;
        // $clinic->end_time = $request->end_time;
        // $clinic->start_time1 = $request->start_time1;
        // $clinic->end_time1 = $request->end_time1;
        // $clinic->start_time2 = $request->start_time2;
        // $clinic->end_time2 = $request->end_time2;
        // $clinic->serial_or_slot1 = $request->serial_or_slot1;
        // $clinic->serial_or_slot2 = $request->serial_or_slot2;
        // $clinic->serial_day = $request->serial_day;
        // $clinic->max_serial = $request->max_serial;
        // $clinic->duration = $request->duration;

        if ($request->slot_type == 1 && $request->max_serial > 0) {
            ///Morning Sessions
            $serialOrSlot = [];
            for ($i = 1; $i <= $request->max_serial; $i++) {
                array_push($serialOrSlot, "$i");
            }
            $clinic->serial_or_slot = $serialOrSlot;
            $clinic->max_serial = $request->max_serial;
        } elseif ($request->slot_type == 2 && $request->duration > 0) {
            ///Morning Sessions
            $startTime    = Carbon::parse($request->start_time);
            $endTime      = Carbon::parse($request->end_time);
            $totalMinutes = $startTime->diffInMinutes($endTime);
            $totalSlot   = $totalMinutes / $request->duration;

            $serialOrSlot = [];
            for ($i = 1; $i <= $totalSlot; $i++) {
                array_push($serialOrSlot, date('h:i:a', strtotime($startTime)));
                $startTime->addMinutes((int)$request->duration);
            }
            $clinic->serial_or_slot = $serialOrSlot;
            $clinic->duration       = $request->duration;
            $clinic->start_time     = ($request->start_time) ? Carbon::parse($request->start_time)->format('h:i a') : null;
            $clinic->end_time       = ($request->end_time) ? Carbon::parse($request->end_time)->format('h:i a') : null;

            ///AfterNoon Sessions
            $startTime    = Carbon::parse($request->start_time1);
            $endTime      = Carbon::parse($request->end_time1);
            $totalMinutes = $startTime->diffInMinutes($endTime);
            $totalSlot   = $totalMinutes / $request->duration;

            $serialOrSlot = [];
            for ($i = 1; $i <= $totalSlot; $i++) {
                array_push($serialOrSlot, date('h:i:a', strtotime($startTime)));
                $startTime->addMinutes((int)$request->duration);
            }
            $clinic->serial_or_slot1 = $serialOrSlot;
            $clinic->duration       = $request->duration;
            $clinic->start_time1     = ($request->start_time1) ? Carbon::parse($request->start_time1)->format('h:i a') : null;
            $clinic->end_time1      = ($request->end_time1) ? Carbon::parse($request->end_time1)->format('h:i a') : null;

            ///Evening Sessions
            $startTime    = Carbon::parse($request->start_time2);
            $endTime      = Carbon::parse($request->end_time2);
            $totalMinutes = $startTime->diffInMinutes($endTime);
            $totalSlot   = $totalMinutes / $request->duration;

            $serialOrSlot = [];
            for ($i = 1; $i <= $totalSlot; $i++) {
                array_push($serialOrSlot, date('h:i:a', strtotime($startTime)));
                $startTime->addMinutes((int)$request->duration);
            }
            $clinic->serial_or_slot2 = $serialOrSlot;
            $clinic->duration       = $request->duration;
            $clinic->start_time2     = ($request->start_time2) ? Carbon::parse($request->start_time2)->format('h:i a') : null;
            $clinic->end_time2      = ($request->end_time2) ? Carbon::parse($request->end_time2)->format('h:i a') : null;
        } else {
            $notify[] = ['error', 'Select the maximum serial or duration'];
            return back()->withNotify($notify);
        }

        $clinic->slot_type  = $request->slot_type;
        $clinic->serial_day = $request->serial_day;

        $clinic->save();

        $notify[] = ['success', 'Clinic updated successfully'];
        return back()->withNotify($notify);
    }
}
