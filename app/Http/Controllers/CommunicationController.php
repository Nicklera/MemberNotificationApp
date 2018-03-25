<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\RouteSms;
use App\Helpers\Infobip;
use App\Models\Member;
use App\Models\Email;
use App\Models\Setting;
use App\Models\Sms;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Clickatell\Rest;
use Illuminate\Http\Request;
use Aloha\Twilio\Twilio;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CommunicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('sentinel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmail()
    {
        if (!Sentinel::hasAccess('communication')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $data = Email::all();
        return view('communication.email', compact('data'));
    }

    public function indexSms()
    {
        if (!Sentinel::hasAccess('communication')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $data = Sms::all();
        return view('communication.sms', compact('data'));
    }


    public function createEmail(Request $request)
    {
        if (!Sentinel::hasAccess('communication.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $members = array();
        $members["0"] = trans_choice('general.all', 2) . ' ' . trans_choice('general.member', 2);
        foreach (Member::all() as $key) {
            $members[$key->id] = $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . '(' . $key->id . ')';
        }
        if (isset($request->member_id)) {
            $selected = $request->member_id;
        } else {
            $selected = '';
        }
        return view('communication.create_email', compact('members', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeEmail(Request $request)
    {
        if (!Sentinel::hasAccess('communication.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $body = $request->message;
        $recipients = 1;
        if ($request->send_to == 0) {
            foreach (Member::all() as $member) {
                $body = $request->message;
//lets build and replace available tags
                $body = str_replace('{firstName}', $member->first_name, $body);
                $body = str_replace('{middleName}', $member->middle_name, $body);
                $body = str_replace('{lastName}', $member->last_name, $body);
                $body = str_replace('{address}', $member->address, $body);
                $body = str_replace('{homePhone}', $member->home_phone, $body);
                $body = str_replace('{mobilePhone}', $member->mobile_phone, $body);
                $body = str_replace('{email}', $member->email, $body);
                $email = $member->email;
                if (!empty($email)) {
                    Mail::raw($body, function ($message) use ($request, $email) {
                        $message->from(Setting::where('setting_key', 'company_email')->first()->setting_value,
                            Setting::where('setting_key', 'company_name')->first()->setting_value);
                        $message->to($email);
                        $headers = $message->getHeaders();
                        $message->setContentType('text/html');
                        $message->setSubject($request->subject);

                    });

                }
                $recipients = $recipients + 1;
            }
            $mail = new Email();
            $mail->user_id = Sentinel::getUser()->id;
            $mail->message = $body;
            $mail->subject = $request->subject;
            $mail->recipients = $recipients;
            $mail->send_to = 'All Members';
            $mail->save();
            GeneralHelper::audit_trail("Send  email to all members");
            Flash::success("Email successfully sent");
            return redirect('communication/email');
        } else {
            $member = Member::find($request->send_to);
            //lets build and replace available tags
            $body = str_replace('{firstName}', $member->first_name, $body);
            $body = str_replace('{middleName}', $member->middle_name, $body);
            $body = str_replace('{lastName}', $member->last_name, $body);
            $body = str_replace('{address}', $member->address, $body);
            $body = str_replace('{homePhone}', $member->home_phone, $body);
            $body = str_replace('{mobilePhone}', $member->mobile_phone, $body);
            $body = str_replace('{email}', $member->email, $body);
            if (!empty($email)) {
                Mail::raw($body, function ($message) use ($request, $member, $email) {
                    $message->from(Setting::where('setting_key', 'company_email')->first()->setting_value,
                        Setting::where('setting_key', 'company_name')->first()->setting_value);
                    $message->to($email);
                    $headers = $message->getHeaders();
                    $message->setContentType('text/html');
                    $message->setSubject($request->subject);

                });
                $mail = new Email();
                $mail->user_id = Sentinel::getUser()->id;
                $mail->message = $body;
                $mail->subject = $request->subject;
                $mail->recipients = $recipients;
                $mail->send_to = $member->first_name . ' ' . $member->last_name;
                $mail->save();
                GeneralHelper::audit_trail("Sent email to member ");
                Flash::success("Email successfully sent");
                return redirect('communication/email');
            }

        }
        Flash::success("Email successfully sent");
        return redirect('communication/email');
    }


    public function deleteEmail($id)
    {
        if (!Sentinel::hasAccess('communication.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        Email::destroy($id);
        GeneralHelper::audit_trail("Deleted email record with id:" . $id);
        Flash::success("Email successfully deleted");
        return redirect('communication/email');
    }

    public function createSms(Request $request)
    {
        if (!Sentinel::hasAccess('communication.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $members = array();
        $members["0"] = trans_choice('general.all', 2) . ' ' . trans_choice('general.member', 2);
        foreach (Member::all() as $key) {
            $members[$key->id] = $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . '(' . $key->id . ')';
        }
        if (isset($request->member_id)) {
            $selected = $request->member_id;
        } else {
            $selected = '';
        }
        return view('communication.create_sms', compact('members', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeSms(Request $request)
    {
        if (!Sentinel::hasAccess('communication.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $body = $request->message;
        $recipients = 1;
        if (Setting::where('setting_key', 'sms_enabled')->first()->setting_value == 1) {
            if ($request->send_to == 0) {
                $active_sms = Setting::where('setting_key', 'active_sms')->first()->setting_value;
                foreach (Member::all() as $member) {
//lets build and replace available tags
                    $body = str_replace('{firstName}', $member->first_name, $body);
                    $body = str_replace('{middleName}', $member->middle_name, $body);
                    $body = str_replace('{lastName}', $member->last_name, $body);
                    $body = str_replace('{address}', $member->address, $body);
                    $body = str_replace('{homePhone}', $member->home_phone, $body);
                    $body = str_replace('{mobilePhone}', $member->mobile_phone, $body);
                    $body = str_replace('{email}', $member->email, $body);
                    $body = trim(strip_tags($body));
                    if (!empty($member->mobile_phone)) {
                        $active_sms = Setting::where('setting_key', 'active_sms')->first()->setting_value;
                        if ($active_sms == 'twilio') {
                            $twilio = new Twilio(Setting::where('setting_key', 'twilio_sid')->first()->setting_value,
                                Setting::where('setting_key', 'twilio_token')->first()->setting_value,
                                Setting::where('setting_key', 'twilio_phone_number')->first()->setting_value);
                            $twilio->message('+' . $member->mobile_phone, $body);
                        }
                        if ($active_sms == 'routesms') {
                            $host = Setting::where('setting_key', 'routesms_host')->first()->setting_value;
                            $port = Setting::where('setting_key', 'routesms_port')->first()->setting_value;
                            $username = Setting::where('setting_key', 'routesms_username')->first()->setting_value;
                            $password = Setting::where('setting_key', 'routesms_password')->first()->setting_value;
                            $sender = Setting::where('setting_key', 'sms_sender')->first()->setting_value;
                            $SMSText = $body;
                            $GSM = $member->mobile_phone;
                            $msgtype = 2;
                            $dlr = 1;
                            $routesms = new RouteSms($host, $port, $username, $password, $sender, $SMSText, $GSM,
                                $msgtype,
                                $dlr);
                            $routesms->Submit();
                        }
                        if ($active_sms == 'clickatell') {
                            $clickatell = new Rest(
                                Setting::where('setting_key', 'clickatell_api_id')->first()->setting_value);
                            $response = $clickatell->sendMessage(array($member->mobile_phone), $body);
                        }
                        if ($active_sms == 'infobip') {
                            $infobip = new Infobip(Setting::where('setting_key',
                                'sms_sender')->first()->setting_value, $body,
                                $member->mobile_phone);
                        }

                    }
                    $recipients = $recipients + 1;
                }
                $sms = new Sms();
                $sms->user_id = Sentinel::getUser()->id;
                $sms->message = $body;
                $sms->gateway = $active_sms;
                $sms->recipients = $recipients;
                $sms->send_to = 'All borrowers';
                $sms->save();
                GeneralHelper::audit_trail("Sent SMS   to all borrower");
                Flash::success("SMS successfully sent");
                return redirect('communication/sms');
            } else {
                $member = Member::find($request->send_to);
                //lets build and replace available tags
                $body = str_replace('{borrowerTitle}', $member->title, $body);
                $body = str_replace('{borrowerFirstName}', $member->first_name, $body);
                $body = str_replace('{borrowerLastName}', $member->last_name, $body);
                $body = str_replace('{borrowerAddress}', $member->address, $body);
                $body = str_replace('{borrowerMobile}', $member->mobile_phone, $body);
                $body = str_replace('{borrowerEmail}', $member->email, $body);
                $body = str_replace('{borrowerTotalLoansDue}',
                    round(GeneralHelper::borrower_loans_total_due($member->id), 2), $body);
                $body = str_replace('{borrowerTotalLoansBalance}',
                    round((GeneralHelper::borrower_loans_total_due($member->id) - GeneralHelper::borrower_loans_total_paid($member->id)),
                        2), $body);
                $body = str_replace('{borrowerTotalLoansPaid}', GeneralHelper::borrower_loans_total_paid($member->id),
                    $body);
                $body = trim(strip_tags($body));
                if (!empty($member->mobile_phone)) {
                    $active_sms = Setting::where('setting_key', 'active_sms')->first()->setting_value;
                    if ($active_sms == 'twilio') {
                        $twilio = new Twilio(Setting::where('setting_key', 'twilio_sid')->first()->setting_value,
                            Setting::where('setting_key', 'twilio_token')->first()->setting_value,
                            Setting::where('setting_key', 'twilio_phone_number')->first()->setting_value);
                        $twilio->message('+' . $member->mobile_phone, $body);
                    }
                    if ($active_sms == 'routesms') {
                        $host = Setting::where('setting_key', 'routesms_host')->first()->setting_value;
                        $port = Setting::where('setting_key', 'routesms_port')->first()->setting_value;
                        $username = Setting::where('setting_key', 'routesms_username')->first()->setting_value;
                        $password = Setting::where('setting_key', 'routesms_password')->first()->setting_value;
                        $sender = Setting::where('setting_key', 'sms_sender')->first()->setting_value;
                        $SMSText = $body;
                        $GSM = $member->mobile_phone;
                        $msgtype = 2;
                        $dlr = 1;
                        $routesms = new RouteSms($host, $port, $username, $password, $sender, $SMSText, $GSM, $msgtype,
                            $dlr);
                        $routesms->Submit();
                    }
                    if ($active_sms == 'clickatell') {
                        $clickatell = new Rest(
                            Setting::where('setting_key', 'clickatell_api_id')->first()->setting_value);
                        $response = $clickatell->sendMessage(array($member->mobile_phone), $body);
                    }
                    if ($active_sms == 'infobip') {
                        $infobip = new Infobip(Setting::where('setting_key',
                            'sms_sender')->first()->setting_value, $body,
                            $member->mobile_phone);

                    }
                    $sms = new Sms();
                    $sms->user_id = Sentinel::getUser()->id;
                    $sms->message = $body;
                    $sms->gateway = $active_sms;
                    $sms->recipients = $recipients;
                    $sms->send_to = $member->first_name . ' ' . $member->last_name;
                    $sms->save();
                    Flash::success("SMS successfully sent");
                    return redirect('communication/sms');
                }

            }
            GeneralHelper::audit_trail("Sent SMS   to member");
            Flash::success("Sms successfully sent");
            return redirect('communication/sms');
        } else {
            Flash::warning('SMS service is disabled, please go to settings and enable it');
            return redirect('setting/data')->with(array('error' => 'SMS is disabled, please enable it.'));
        }
    }


    public function deleteSms($id)
    {
        if (!Sentinel::hasAccess('communication.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        Sms::destroy($id);
        GeneralHelper::audit_trail("Deleted sms record with id:" . $id);
        Flash::success("SMS successfully deleted");
        return redirect('communication/sms');
    }

}
