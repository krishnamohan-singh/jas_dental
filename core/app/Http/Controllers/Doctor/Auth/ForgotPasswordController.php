<?php

namespace App\Http\Controllers\Doctor\Auth;

use App\Models\Doctor;
use App\Models\DoctorPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

  

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $pageTitle = 'Account Recovery';
        return view('doctor.auth.passwords.email', compact('pageTitle'));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('doctors');
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate( [
            'email' => 'required|email',
        ]);

        $doctor = Doctor::where('email', $request->email)->first();
        if (!$doctor) {
            return back()->withErrors(['Email Not Available']);
        }

        $code = verificationCode(6);
        $staffPasswordReset = new DoctorPasswordReset();
        $staffPasswordReset->email = $doctor->email;
        $staffPasswordReset->token = $code;
        $staffPasswordReset->status = 0;
        $staffPasswordReset->created_at = date("Y-m-d h:i:s");
        $staffPasswordReset->save();

        $staffIpInfo = getIpInfo();
        $staffBrowser = osBrowser();
        notify($doctor, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => $staffBrowser['os_platform'],
            'browser' => $staffBrowser['browser'],
            'ip' => $staffIpInfo['ip'],
            'time' => $staffIpInfo['time']
        ],['email'],false);

        $email = $doctor->email;
        session()->put('pass_res_mail',$email);

        return redirect()->route('doctor.password.code.verify');
    }

    public function codeVerify(){
        $pageTitle = 'Verify Code';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return redirect()->route('doctor.password.reset')->withNotify($notify);
        }
        return view('doctor.auth.passwords.code_verify', compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        $notify[] = ['success', 'You can change your password.'];
        $code = str_replace(' ', '', $request->code);
        return to_route('doctor.password.reset.form', $code)->withNotify($notify);
    }
}
