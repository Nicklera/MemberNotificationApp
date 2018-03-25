<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Helpers\GeneralHelper;


use App\Models\FollowUpCategory;
use App\Models\Member;
use App\Models\FollowUp;
use App\Models\Setting;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class FollowUpController extends Controller
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
    public function index()
    {
        if (!Sentinel::hasAccess('follow_ups')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $data = FollowUp::all();

        return view('follow_up.data', compact('data'));
    }
    public function my_follow_ups()
    {
        if (!Sentinel::hasAccess('follow_ups')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $data = FollowUp::where('assigned_to_id',Sentinel::getUser()->id)->get();

        return view('follow_up.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('follow_ups.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $categories = array();
        foreach (FollowUpCategory::all() as $key) {
            $categories[$key->id] = $key->name;
        }
        $members = array();
        foreach (Member::all() as $key) {
            $members[$key->id] = $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . '(' . $key->id . ')';
        }
        $users = array();
        foreach (User::all() as $key) {
            $users[$key->id] = $key->first_name . ' '  . $key->last_name . '(' . $key->id . ')';
        }
  
        return view('follow_up.create', compact('categories', 'members','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Sentinel::hasAccess('follow_ups.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        $follow_up = new FollowUp();
        $follow_up->user_id = Sentinel::getUser()->id;
        $follow_up->member_id = $request->member_id;
        $follow_up->assigned_to_id = $request->assigned_to_id;
        $follow_up->follow_up_category_id = $request->follow_up_category_id;
        $follow_up->notes = $request->notes;
        $follow_up->due_date = date_format(date_add(date_create(date("Y-m-d")),
            date_interval_create_from_date_string(FollowUpCategory::find($request->follow_up_category_id)->days . ' days')),
            'Y-m-d');
        $follow_up->save();
        //notify assigned user
        $member = Member::find($request->member_id);
        $body = Setting::where('setting_key',
            'follow_up_email_template')->first()->setting_value;
        $body = str_replace('{followUpCategory}', FollowUpCategory::find($request->follow_up_category_id)->name, $body);
        $body = str_replace('{followUpName}', $member->first_name . ' ' . $member->last_name, $body);
        $body = str_replace('{followUpID}', $follow_up->id, $body);
        $body = str_replace('{firstName}', Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name,
            $body);
        $body = str_replace('{followUpDueDate}', $follow_up->due_date, $body);
        $body = str_replace('{followUpNotes}', $follow_up->notes, $body);
        $body = str_replace('{followUpLink}', url('follow_up/' . $follow_up->id . '/show'), $body);
        $subject = Setting::where('setting_key',
            'follow_up_email_subject')->first()->setting_value;
        $subject = str_replace('{followUpName}', $member->first_name . ' ' . $member->last_name, $subject);
        Mail::raw($body, function ($message) use ($subject) {
            $message->from(Setting::where('setting_key', 'company_email')->first()->setting_value,
                Setting::where('setting_key', 'company_name')->first()->setting_value);
            $message->to(Sentinel::getUser()->email);
            $headers = $message->getHeaders();
            $message->setContentType('text/html');
            $message->setSubject($subject);

        });

        GeneralHelper::audit_trail("Added follow_up with id:" . $follow_up->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('follow_up/data');
    }


    public function show(FollowUp $follow_up)
    {
        if (!Sentinel::hasAccess('follow_ups.view')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        return view('follow_up.show', compact('follow_up'));
    }


    public function edit(FollowUp $follow_up)
    {
        if (!Sentinel::hasAccess('follow_ups.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $categories = array();
        foreach (FollowUpCategory::all() as $key) {
            $categories[$key->id] = $key->name;
        }
        $members = array();
        foreach (Member::all() as $key) {
            $members[$key->id] = $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . '(' . $key->id . ')';
        }
        $users = array();
        foreach (User::all() as $key) {
            $users[$key->id] = $key->first_name . ' '  . $key->last_name . '(' . $key->id . ')';
        }
      
        return view('follow_up.edit', compact('follow_up', 'categories', 'members','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Sentinel::hasAccess('follow_ups.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $follow_up = FollowUp::find($id);
        $follow_up->member_id = $request->member_id;
        $follow_up->assigned_to_id = $request->assigned_to_id;
        $follow_up->follow_up_category_id = $request->follow_up_category_id;
        $follow_up->notes = $request->notes;
        $follow_up->due_date = $request->due_date;
        $follow_up->save();
        GeneralHelper::audit_trail("Updated follow_up with id:" . $follow_up->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('follow_up/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (!Sentinel::hasAccess('follow_ups.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        FollowUp::destroy($id);
        GeneralHelper::audit_trail("Deleted follow_up with id:" . $id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('follow_up/data');
    }

    public function complete($id)
    {
        if (!Sentinel::hasAccess('follow_ups.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $follow_up = FollowUp::find($id);
        $follow_up->status = 1;
        $follow_up->save();
        GeneralHelper::audit_trail("Marked as complete follow_up with id:" . $id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect()->back();
    }

    public function incomplete($id)
    {
        if (!Sentinel::hasAccess('follow_ups.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $follow_up = FollowUp::find($id);
        $follow_up->status = 0;
        $follow_up->save();
        GeneralHelper::audit_trail("Marked as incomplete follow_up with id:" . $id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect()->back();
    }
}
