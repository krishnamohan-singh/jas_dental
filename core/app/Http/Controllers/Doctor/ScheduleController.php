<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Schedule';
        $doctor = auth()->guard('doctor')->user();
       
        return view('doctor.schedule.index', compact('pageTitle', 'doctor'));
    }

    public function update(Request $request)
    {
        $request->validate([
                'slot_type'  => 'required|numeric|in:1,2',
                'serial_day' => 'required|numeric|gt:0',
                // 'start_time' => 'required_if:slot_type,2',
                // 'end_time'   => 'required_if:slot_type,2',
                'duration'   => 'numeric|required_if:slot_type,2',
                'max_serial' => 'numeric|required_if:slot_type,1',
            ]);

        $doctor = Doctor::findOrFail(auth()->guard('doctor')->user()->id);

        if ($request->slot_type == 1 && $request->max_serial > 0) {
            ///Morning Sessions
            $serialOrSlot = [];
            for ($i = 1; $i <= $request->max_serial; $i++) {
                array_push($serialOrSlot, "$i");
            }
            $doctor->serial_or_slot = $serialOrSlot;
            $doctor->max_serial = $request->max_serial;
 
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
            $doctor->serial_or_slot = $serialOrSlot;
            $doctor->duration       = $request->duration;
            $doctor->start_time     = ($request->start_time) ? Carbon::parse($request->start_time)->format('h:i a') : null;
            $doctor->end_time       = ($request->end_time) ? Carbon::parse($request->end_time)->format('h:i a') : null;

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
            $doctor->serial_or_slot1 = $serialOrSlot;
            $doctor->duration       = $request->duration;
            $doctor->start_time1     = ($request->start_time1) ? Carbon::parse($request->start_time1)->format('h:i a') : null;
            $doctor->end_time1      = ($request->end_time1) ? Carbon::parse($request->end_time1)->format('h:i a') : null;

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
            $doctor->serial_or_slot2 = $serialOrSlot;
            $doctor->duration       = $request->duration;
            $doctor->start_time2     = ($request->start_time2) ? Carbon::parse($request->start_time2)->format('h:i a') : null;
            $doctor->end_time2      = ($request->end_time2) ? Carbon::parse($request->end_time2)->format('h:i a') : null;

        } else {
            $notify[] = ['error', 'Select the maximum serial or duration'];
            return back()->withNotify($notify);
        }

        $doctor->slot_type  = $request->slot_type;
        $doctor->serial_day = $request->serial_day;
        $doctor->save();
        $notify[] = ['success', 'Schedule has been updated successfully'];
        return back()->withNotify($notify);
    }
}
