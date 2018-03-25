<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Models\Branch;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\Setting;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class BranchController extends Controller
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
        $data = Branch::all();
        return view('branch.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //get custom fields
        return view('branch.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->notes = $request->notes;
        $assigned_users = array();
        if (!empty($request->assigned_users)) {
            $assigned_users = serialize($request->assigned_users);
        }
        $branch->assigned_users = $assigned_users;
        $branch->save();
        Flash::success(trans('general.successfully_saved'));
        return redirect('branch/data');
    }


    public function show($branch)
    {

        return view('branch.show', compact('branch'));
    }


    public function edit($branch)
    {
        return view('branch.edit', compact('branch'));
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
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->notes = $request->notes;
        $assigned_users = array();
        if (!empty($request->assigned_users)) {
            $assigned_users = serialize($request->assigned_users);
        }
        $branch->assigned_users = $assigned_users;
        $branch->save();
        Flash::success(trans('general.successfully_saved'));
        return redirect('branch/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Branch::destroy($id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('branch/data');
    }

}
