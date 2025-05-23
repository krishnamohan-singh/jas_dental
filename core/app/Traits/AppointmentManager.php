<?php

namespace App\Traits;

use App\Constants\Status; 
use App\Models\Appointment;
use App\Models\AssistantDoctorTrack;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Notify\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
/**
 * All Common functionalities to make an appointment
 */
trait AppointmentManager
{
    public $userType;


    public function form()
    {
        $pageTitle = 'Make Appointment';
        $clinics   = Clinic::orderBy('name')->get();
        return view($this->userType . '.appointment.form', compact('pageTitle', 'clinics'));
    }

    public function details(Request $request)
    {
        /**;
         * If making appointment via doctor guard then do not check doctor! use else!
         */
        if ($this->userType == 'doctor') {
            $clinic = Clinic::findOrFail(auth()->guard('clinic')->id());
        } else {
            $request->validate([
                'clinic_id' => 'required|numeric|gt:0',
            ]);
            $clinic = Clinic::findOrFail($request->clinic_id);
        }


        if (!$clinic->serial_or_slot) {
            $notify[] = ['error', 'No available schedule for this Clinic!'];
            return back()->withNotify($notify);
        }

        $availableDate = [];
        $date          = Carbon::now();
        for ($i = 0; $i < $clinic->serial_day; $i++) {
            array_push($availableDate, date('Y-m-d', strtotime($date)));
            $date->addDays(1);
        }
        $pageTitle = 'Make Appointment';
        return view($this->userType . '.appointment.booking', compact('clinic', 'pageTitle', 'availableDate'));
    }

    public function availability(Request $request)
    {

        $collection = Appointment::hasClinic()->where('clinic_id', $request->clinic_id)->where('try', Status::YES)->where('is_delete', Status::NO)->whereDate('booking_date', Carbon::parse($request->date))->get();

        $data = collect([]);
        foreach ($collection as  $value) {
            $data->push($value->time_serial);
        }
        return response()->json(["now"=> Carbon::now(), "data"=>@$data]);
    }

   

    public function store(Request $request, $id)
    {
       
        // $this->validation($request);
       
       
        $validator = Validator::make($request->all(), [
                'name'           => 'required|max:40',
                'booking_date'   => 'required|date|after_or_equal:today',
                'time_serial'    => 'required',
                'email'          => 'required|email',
                'mobile'         => 'required|max:40',
                'age'            => 'required|integer|gt:0',
                'payment_system' => 'nullable|in:1,2',
            ],
            [
                'time_serial.required' => 'You did not select any time or Serial',
            ]);
            

    if ($validator->fails()) {
        return redirect('clinics/'.$id)
            ->withErrors($validator)
            ->withInput();
    }

        //$doctor = Doctor::active()->find($id);
        $clinic = Clinic::active()->find($id);

        if (!$clinic) {
            $notify[] = ['error', 'The clinic isn\'t available for the appointment'];
            // return back()->withNotify($notify);
            return redirect('clinics/'.$id)->withNotify($notify);
        }

        if (!($clinic->serial_or_slot || $clinic->serial_or_slot1 || $clinic->serial_or_slot2)) {
            $notify[] = ['error', 'No available schedule for this clinic'];
            return back()->withNotify($notify);
            //return redirect('clinics/'.$id)->withNotify($notify);
        }

        $timeSerialCheck = $clinic->whereJsonContains('serial_or_slot', $request->time_serial)->exists();
        $timeSerialCheck1 = $clinic->whereJsonContains('serial_or_slot1', $request->time_serial)->exists();
        $timeSerialCheck2 = $clinic->whereJsonContains('serial_or_slot2', $request->time_serial)->exists();

        if (!($timeSerialCheck || $timeSerialCheck1 || $timeSerialCheck2)) {
            $notify[] = ['error', 'Invalid! Something went wrong'];
            return back()->withNotify($notify);
        }

        $existed = Appointment::where('clinic_id', $clinic->id)->where('booking_date', $request->booking_date)->where('time_serial', $request->time_serial)->where('try', Status::YES)->where('is_delete', Status::NO)->exists();

        if ($existed) {
            $notify[] = ['error', 'This time or serial is already booked. Please try another or time or serial'];
            return back()->withNotify($notify);
        }

        if ($this->userType == 'assistant') {
            $doctorCheck = AssistantDoctorTrack::where('assistant_id', auth()->guard('assistant')->id())->where('doctor_id', $doctor->id)->first();

            if (!$doctorCheck) {
                $notify[] = ['error', 'You don\'t have permission to operate this action'];
                return back()->withNotify($notify);
            }
        }

        /**
         *Site: Gateway payment is via online. payment_system is cash==2 and  gateways==1;
         **/

        $gateways = ($request->payment_system == 1) ? Status::YES : Status::NO;
        $general  = gs();
        $mobile   =  $general->country_code . $request->mobile;

        //save
        $appointment               = new Appointment();
        $appointment->booking_date = Carbon::parse($request->booking_date)->format('Y-m-d');
        $appointment->time_serial  = $request->time_serial;
        $appointment->name         = $request->name;
        $appointment->email        = $request->email;
        $appointment->mobile       = $mobile;
        $appointment->age          = $request->age;
        // $appointment->doctor_id    = 0;
        $appointment->clinic_id    = $clinic->id;
        $appointment->disease      = $request->disease;
        $appointment->try          =  $gateways ? Status::NO : Status::YES;
        $appointment->trx          =  $gateways ?  getTrx() : NULL;


        

        if ($this->userType == 'admin') {
            $appointment->added_admin_id = 1;
        } 
        // elseif ($this->userType == 'doctor') {
        //     $appointment->added_doctor_id = auth()->guard('doctor')->id();

        // }
         elseif ($this->userType == 'staff') {
            $appointment->added_staff_id = auth()->guard('staff')->id();
        } elseif ($this->userType == 'assistant') {
            $appointment->added_assistant_id = auth()->guard('assistant')->id();
        } else {
            $appointment->site = Status::YES;
        }

        if ($gateways) {
            $appointment->try  = Status::NO;
        } else {
            $appointment->try  = Status::YES;
        } 

        $appointment->save();

        if ($gateways) {
            $appointment->payment_status = Status::APPOINTMENT_PENDING_PAYMENT;
            $appointment->save();

            $encryptedAppointmentId = encrypt($appointment->id);
            return redirect()->route('deposit.index', $encryptedAppointmentId);
        }

        //mail send to patient
        notify($this->notifyUser($appointment), 'APPOINTMENT_CONFIRMATION', [
            'booking_date' => $appointment->booking_date,
            'time_serial'  => $appointment->time_serial,
            'clinic_name'  => $clinic->name,
            'clinic_address'=>$clinic->address,
            'clinic_mobile'=>$clinic->phone,
            'clinic_location'=>$clinic->location->name,
            'clinic_fees'  => '' . $clinic->fees . ' ' . $general->cur_text . '',
        ], ['email', 'sms']);


        //mail send to doctor
        $data = [
            'doctor_name' => $clinic->name,            
            'patient_name'    => $appointment->name,
            'patient_email'    => $appointment->email,
            'patient_phone'    => $appointment->mobile,
            'booking_date'    => $appointment->booking_date,
            'time_serial'    => $appointment->time_serial, 
            'site_name'   => $general->site_name,
        ];
        try {
            $htmlContent = View::make('CoustomMailTemplate.AppointmentMailToDoctor',$data)->render();
             
            $email = new Email();
            $email->subject = "New Appointment Received";
            $email->message = $htmlContent;
            $email->email = $clinic->email;
            $email->bcc = ["teaminmogic@gmail.com", 'azad@inmogic.co','krishnamohansingh605@gmail.com'];
            $email->receiverName = $clinic->name;
            $email->sendSmtpMail();
            // Log::info('Email sent successfully to ');
        } catch (Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }
        //End Doctor send mail

        $notify[] = ['success', 'New Appointment made successfully'];
        return back()->withNotify($notify);
       



    }

    protected function validation($request)
    {
        $request->validate(
            [
                'name'           => 'required|max:40',
                'booking_date'   => 'required|date|after_or_equal:today',
                'time_serial'    => 'required',
                'email'          => 'required|email',
                'mobile'         => 'required|max:40',
                'age'            => 'required|integer|gt:0',
                'payment_system' => 'nullable|in:1,2',
            ],
            [
                'time_serial.required' => 'You did not select any time or Serial',
            ]
        );
    }
    public function done($id)
    {
        $appointment =  Appointment::findOrFail($id);

        if ($appointment->is_complete == Status::APPOINTMENT_INCOMPLETE) {

            if ($appointment->payment_status == Status::APPOINTMENT_PAID_PAYMENT) {
                $appointment->is_complete = Status::APPOINTMENT_COMPLETE;
                $appointment->save();

                $notify[] = ['success', 'Appointed service is done successfully'];
                return back()->withNotify($notify);
            } elseif ($appointment->payment_status != Status::APPOINTMENT_PAID_PAYMENT && $appointment->payment_status == Status::APPOINTMENT_CASH_PAYMENT) {
                // $doctor          = Doctor::findOrFail($appointment->doctor->id);
                // $doctor->balance += $doctor->fees;
                //  $doctor->save();

                $appointment->payment_status = Status::APPOINTMENT_PAID_PAYMENT;
                $appointment->is_complete    = Status::APPOINTMENT_COMPLETE;
                $appointment->save();

                $notify[] = ['success', 'Appointed service is done successfully'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Something is wrong!'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Something is wrong!'];
            return back()->withNotify($notify);
        }
    }

    public function remove($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->is_delete || $appointment->payment_status) {
            $notify[] = ['error', 'Appointment trashed operation is invalid'];
            return back()->withNotify($notify);
        }

        $appointment->is_delete = Status::YES;

        if ($this->userType == 'admin') {
            $appointment->delete_by_admin = 1;
        } elseif ($this->userType == 'staff') {
            $appointment->delete_by_staff = auth()->guard('staff')->id();
        } elseif ($this->userType == 'doctor') {
            $appointment->delete_by_doctor = auth()->guard('doctor')->id();
        } else {
            $appointment->delete_by_assistant = auth()->guard('assistant')->id();
        }

        $appointment->save();

        notify($this->notifyUser($appointment), 'APPOINTMENT_REJECTION', [
            'booking_date' => $appointment->booking_date,
            'time_serial'  => $appointment->time_serial,
            'clinic_name'  => $appointment->clinic->name
        ], ['email', 'sms']);

        $notify[] = ['success', 'Appointment service is trashed successfully'];
        return back()->withNotify($notify);
    }

    protected  function notifyUser($appointment)
    {
        $user = [
            'name'     => $appointment->name,
            'username' => $appointment->email,
            'fullname' => $appointment->name,
            'email'    => $appointment->email,
            'mobileNumber'  => $appointment->mobile,
        ];
        return $user;
    }

    protected function detectUserType($appointments)
    {
        if ($this->userType == 'admin' || $this->userType == 'staff') {
            $appointments  = $appointments->hasClinic();
        } else {
            $appointments->where('doctor_id', auth()->guard('doctor')->id());
        }

        if ($this->userType == 'staff') {
            $appointments  = $appointments->where('added_staff_id', auth()->guard('staff')->id());
        }

        $appointments = $appointments->searchable(['name', 'email', 'disease'])->orderBy('id', 'DESC')->paginate(getPaginate());


        return $appointments;
    }

    public function new()
    {
        $pageTitle    = 'All New Appointments';
        $appointments = Appointment::newAppointment()->with('staff', 'doctor', 'assistant');

        $appointments = $this->detectUserType($appointments);

        return view($this->userType . '.appointment.index', compact('pageTitle', 'appointments'));
    }

    public function doneService()
    {
        $pageTitle    = 'Service Done Appointments';
        $appointments = Appointment::CompleteAppointment()->with('staff', 'doctor', 'assistant');
        $appointments = $this->detectUserType($appointments);

        return view($this->userType . '.appointment.index', compact('pageTitle', 'appointments'));
    }

    public function serviceTrashed()
    {
        $pageTitle    = 'Trashed Appointments';
        $appointments = Appointment::where('is_delete', Status::YES)->with('deletedByStaff', 'deletedByDoctor', 'deletedByAssistant', 'doctor', 'staff', 'assistant');
        $appointments = $this->detectUserType($appointments);

        return view($this->userType . '.appointment.index', compact('pageTitle', 'appointments'));
    }
}
