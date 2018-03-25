<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\AuditTrail;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

use Yajra\DataTables\Facades\DataTables;

class AuditTrailController extends Controller
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
    public function index(Request $request)
    {
        if($request->ajax()){
          
            $audits = AuditTrail::select(['user', 'notes', 'updated_at']);

            $data =  Datatables::of($audits)->make(true);

            return $data;
        }
      
        return view('audit_trail.data');
    }
}
