<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Helpers\GeneralHelper;
use App\Helpers\Infobip;
use App\Helpers\RouteSms;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\Email;
use App\Models\Event;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\LoanSchedule;
use App\Models\Payroll;
use App\Models\PayrollMeta;
use App\Models\PayrollTemplateMeta;
use App\Models\Pledge;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingTransaction;
use App\Models\Setting;
use App\Models\Sms;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Clickatell\Api\ClickatellHttp;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use PDF;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Requests;

class CronController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Setting::where('setting_key', 'enable_cron')->first()->setting_value == 0) {
            //someone attempted to run con job but it is disabled
            Mail::raw('Someone attempted to run con job but it is disabled, please enable it in settings',
                function ($message) {
                    $message->from(Setting::where('setting_key', 'company_email')->first()->setting_value,
                        Setting::where('setting_key', 'company_name')->first()->setting_value);
                    $message->to(Setting::where('setting_key', 'company_email')->first()->setting_value);
                    $headers = $message->getHeaders();
                    $message->setContentType('text/html');
                    $message->setSubject('Cron Job Failed');

                });
            return 'cron job disabled';
        } else {
          
            Setting::where('setting_key',
                'cron_last_run')->update(['setting_value' => date("Y-m-d H:i:s")]);
        }
    }

}
