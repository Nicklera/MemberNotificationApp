<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Helpers\GeneralHelper;

use App\Models\Email;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Member;
use App\Models\MemberTag;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Laracasts\Flash\Flash;

use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    protected $filtered_ids = [];

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
        if (!Sentinel::hasAccess('members')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        if($request->ajax()){
            // Date of Birth filters
            $start = Carbon::now()->subYears(Input::get('age_range')[1]);
            $end =   Carbon::now()->subYears(Input::get('age_range')[0]);
            
            // Get filtered recoreds
            $members = Member::between($start, $end);
            
           
            // Make datatables response
            $data =  Datatables::of($members)
                ->filter(function($query) {
                $this->filtered_ids = $query->pluck("id"); 
                }, true)
                ->editColumn('id', function(Member $member){
                     return "<a href='". route('member.show', $member->id) . "'>" . $member->id ."</a>";
                })
                ->addColumn('action', function (Member $member) {
                    return view('member.partials.opt', ['resource' => "member", 'id' => $member->id]);                
                })
                ->addColumn('age', function(Member $member){
                    return $member->dob ? Carbon::parse($member->dob)->age : '';
                })
                ->rawColumns(['id','tags', 'action'])
                ->make(true);

            // Set additional property on response
            $res = $data->getData();
            $res->filtered_ids = $this->filtered_ids;
            $data = $data->setData($res);

            return $data;
        }

        $members_ids = $this->filtered_ids;
        return view('member.data', compact('members_ids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('members.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        $menus = array(
            'items' => array(),
            'parents' => array()
        );
        // Builds the array lists with data from the SQL result
        foreach (Tag::all() as $items) {
            // Create current menus item id into array
            $menus['items'][$items['id']] = $items;
            // Creates list of all items with children
            $menus['parents'][$items['parent_id']][] = $items['id'];
        }
     
        return view('member.create', compact('menus','custom_props'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Sentinel::hasAccess('members.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = new Member();
        $member->first_name = $request->first_name;
        $member->middle_name = $request->middle_name;
        $member->last_name = $request->last_name;
        $member->user_id = Sentinel::getUser()->id;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->preferred_language = $request->preferred_language;
        $member->place_of_birth = $request->place_of_birth;
        $member->preferred_contact = $request->preferred_contact;
        $member->education = $request->education;
        $member->trade = $request->trade;
        $member->nationality = $request->nationality;
        $member->department = $request->department;

        $member->home_phone = $request->home_phone;
        $member->mobile_phone = $request->mobile_phone;
        $member->work_phone = $request->work_phone;
        if (!empty($request->dob)) {
            $member->dob = $request->dob;
        }

        $member->address = $request->address;
        $member->notes = $request->notes;
        $member->email = $request->email;
        if ($request->hasFile('photo')) {
            $file = array('photo' => Input::file('photo'));
            $rules = array('photo' => 'required|mimes:jpeg,jpg,bmp,png');
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                Flash::warning(trans('general.validation_error'));
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $member->photo = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->move(public_path() . '/uploads',
                    $request->file('photo')->getClientOriginalName());
            }

        }
        $files = array();
        if ($request->hasFile('files[]')) {
            if (!empty(array_filter($request->file('files')))) {
                $count = 0;
                foreach ($request->file('files') as $key) {
                    $file = array('files' => $key);
                    $rules = array('files' => 'required|mimes:jpeg,jpg,bmp,png,pdf,docx,xlsx');
                    $validator = Validator::make($file, $rules);
                    if ($validator->fails()) {
                        Flash::warning(trans('general.validation_error'));
                        return redirect()->back()->withInput()->withErrors($validator);
                    } else {
                        $files[$count] = $key->getClientOriginalName();
                        $key->move(public_path() . '/uploads',
                            $key->getClientOriginalName());
                    }
                    $count++;
                }
            }

            $member->files = serialize($files);
        }
        $member->save();
        //check for tags

        $all_memebers_tag = Tag::all()->first();

        // Add All members tag to all members
        $tag = new MemberTag();
        $tag->member_id = $member->id;
        $tag->tag_id = $all_memebers_tag->id;
        $tag->user_id = Sentinel::getUser()->id;
        $tag->save();
        // If there are additional tags add them as well
        if (!empty($request->tags)) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $k) {
                $tag = new MemberTag();
                $tag->member_id = $member->id;
                $tag->tag_id = $k;
                $tag->user_id = Sentinel::getUser()->id;
                $tag->save();

            }
        }

        GeneralHelper::audit_trail("Added member  with id:" . $member->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('member/data');
    }


    public function show($member)
    {
        if (!Sentinel::hasAccess('members.view')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        $member = Member::find($member);

        $members = array();
        foreach (Member::all() as $key) {
            $members[$key->id] = $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . '(#' . $key->id . ')';
        }
       
        return view('member.show', compact('member', 'members'));
    }


    public function edit($member)
    {
        if (!Sentinel::hasAccess('members.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        $member = Member::find($member);

        $menus = array(
            'items' => array(),
            'parents' => array()
        );
        // Builds the array lists with data from the SQL result
        foreach (Tag::all() as $items) {
            // Create current menus item id into array
            $menus['items'][$items['id']] = $items;
            // Creates list of all items with children
            $menus['parents'][$items['parent_id']][] = $items['id'];
        }

        $selected_tags = array();
        foreach (MemberTag::where('member_id', $member->id)->get() as $key) {
            array_push($selected_tags, $key->tag_id);
        }
       // dd($menus);
        return view('member.edit', compact('member', 'selected_tags', 'menus'));
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
        if (!Sentinel::hasAccess('members.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $member->first_name = $request->first_name;
        $member->middle_name = $request->middle_name;
        $member->last_name = $request->last_name;
        $member->user_id = Sentinel::getUser()->id;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->status = $request->status;
        $member->preferred_language = $request->preferred_language;
        $member->place_of_birth = $request->place_of_birth;
        $member->preferred_contact = $request->preferred_contact;
        $member->education = $request->education;
        $member->trade = $request->trade;
        $member->nationality = $request->nationality;
        $member->department = $request->department;
         
        $member->home_phone = $request->home_phone;
        $member->mobile_phone = $request->mobile_phone;
        $member->work_phone = $request->work_phone;
        if (!empty($request->dob)) {
            $member->dob = $request->dob;
        }

        $member->address = $request->address;
        $member->notes = $request->notes;
        $member->email = $request->email;
        
        if ($request->hasFile('photo')) {
            $file = array('photo' => Input::file('photo'));
            $rules = array('photo' => 'required|mimes:jpeg,jpg,bmp,png');
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                Flash::warning(trans('general.validation_error'));
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $member->photo = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->move(public_path() . '/uploads',
                    $request->file('photo')->getClientOriginalName());
            }

        }
        if(isset($member->files)){
            $files = unserialize($member->files);
            $count = count($files);
            
            if (!empty($request->file('files'))) {
                foreach ($request->file('files') as $key) {
                    $count++;
                    $file = array('files' => $key);
                    $rules = array('files' => 'required|mimes:jpeg,jpg,bmp,png,pdf,docx,xlsx');
                    $validator = Validator::make($file, $rules);
                    if ($validator->fails()) {
                        Flash::warning(trans('general.validation_error'));
                        return redirect()->back()->withInput()->withErrors($validator);
                    } else {
                        $files[$count] = $key->getClientOriginalName();
                        $key->move(public_path() . '/uploads',
                            $key->getClientOriginalName());
                    }

                }
            }
            $member->files = serialize($files);
        }
        $member->save();
        //check for tags
        MemberTag::where('member_id', $member->id)->delete();
        if (!empty($request->tags)) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $k) {
                $tag = new MemberTag();
                $tag->member_id = $member->id;
                $tag->tag_id = $k;
                $tag->user_id = Sentinel::getUser()->id;
                $tag->save();

            }
        }
     
        GeneralHelper::audit_trail("Updated member  with id:" . $member->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('member/data');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (!Sentinel::hasAccess('members.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        Member::destroy($id);
        MemberTag::where('member_id', $id)->delete();
        GeneralHelper::audit_trail("Deleted member  with id:" . $id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('member/data');
    }

    public function deleteFile(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $files = unserialize($member->files);
        @unlink(public_path() . '/uploads/' . $files[$request->id]);
        $files = array_except($files, [$request->id]);
        $member->files = serialize($files);
        $member->save();


    }

    public function approve(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.approve')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $member->active = 1;
        $member->save();
        GeneralHelper::audit_trail("Approved borrower  with id:" . $member->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function decline(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.approve')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $member->active = 0;
        $member->save();
        GeneralHelper::audit_trail("Declined borrower  with id:" . $member->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function blacklist(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.blacklist')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $member->blacklisted = 1;
        $member->save();
        GeneralHelper::audit_trail("Blacklisted borrower  with id:" . $id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function unBlacklist(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.blacklist')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($id);
        $member->blacklisted = 0;
        $member->save();
        GeneralHelper::audit_trail("Undo Blacklist for borrower  with id:" . $id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function createFamily( $member)
    {
        if (!Sentinel::hasAccess('members.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($member);

        if (!empty($member->family)) {
            Flash::warning("Family already exist");
            return redirect()->back();
        }
        $family = new Family();
        $family->user_id = Sentinel::getUser()->id;
        $family->member_id = $member->id;
        $family->name = $member->last_name;
        $family->save();
        //add family member with role of head
        $family_member = new FamilyMember();
        $family_member->user_id = Sentinel::getUser()->id;
        $family_member->member_id = $member->id;
        $family_member->family_id = $family->id;
        $family_member->family_role = "head";
        $family_member->save();
        GeneralHelper::audit_trail("Created family for member  with id:" . $member->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function deleteFamilyMember($id)
    {
        if (!Sentinel::hasAccess('members.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        FamilyMember::destroy($id);
        GeneralHelper::audit_trail("Deleted family Member  with id:" . $id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function storeFamilyMember(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        if (FamilyMember::where('family_id', $id)->where('member_id', $request->member_id)->count() > 0) {
            Flash::warning("Member already in family");
            return redirect()->back();
        }

        //add family member with role of head
        $family_member = new FamilyMember();
        $family_member->user_id = Sentinel::getUser()->id;
        $family_member->member_id = $request->member_id;
        $family_member->family_id = $id;
        $family_member->family_role = $request->family_role;
        $family_member->save();
        GeneralHelper::audit_trail("Added family for member  with id:" . $request->member_id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function updateFamilyMember(Request $request, $id)
    {
        if (!Sentinel::hasAccess('members.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        //add family member with role of head
        $family_member = FamilyMember::find($id);
        $family_member->family_role = $request->family_role;
        $family_member->save();
        GeneralHelper::audit_trail("Added family for member  with id:" . $family_member->member_id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function editFamilyMember( $family_member)
    {
        if (!Sentinel::hasAccess('members.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $family_member = FamilyMember::find($family_member);

        return View::make('member.edit_family_member', compact('family_member'))->render();
    }

    public function pdfStatement( $member)
    {
        if (!Sentinel::hasAccess('members.view')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($member);

        PDF::AddPage();
        PDF::writeHTML(View::make('member.pdf_member_statement', compact('member'))->render());
        PDF::SetAuthor('Tererai Mugova');
        PDF::Output( $member->first_name . ' ' . $member->last_name . " - Statement.pdf",
            'D');
    }

    public function printStatement( $member)
    {
        if (!Sentinel::hasAccess('members.view')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($member);

        return View::make('member.print_member_statement', compact('member'))->render();
    }

    public function emailStatement( $member)
    {
        if (!Sentinel::hasAccess('members.view')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $member = Member::find($member);

        if (!empty($member->email)) {
            $body = Setting::where('setting_key',
                'member_statement_email_template')->first()->setting_value;
            $body = str_replace('{firstName}', $member->first_name, $body);
            $body = str_replace('{middleName}', $member->middle_name, $body);
            $body = str_replace('{lastName}', $member->last_name, $body);
            $body = str_replace('{address}', $member->address, $body);
            $body = str_replace('{homePhone}', $member->home_phone, $body);
            $body = str_replace('{mobilePhone}', $member->mobile_phone_phone, $body);
            $body = str_replace('{email}', $member->email, $body);
            $body = str_replace('{totalContributions}', GeneralHelper::member_total_contributions($member->id), $body);
            $body = str_replace('{totalPledges}',
                round(GeneralHelper::member_total_pledges($member->id), 2), $body);
            $body = str_replace('{total}',
                round((GeneralHelper::member_total_contributions($member->id) + GeneralHelper::member_total_pledges($member->id)),
                    2), $body);
            PDF::AddPage();
            PDF::writeHTML(View::make('member.pdf_member_statement', compact('member'))->render());
            PDF::SetAuthor('Tererai Mugova');
            PDF::Output(public_path() . '/uploads/temporary/member_statement' . $member->id . ".pdf", 'F');
            $file_name =  $member->first_name . ' ' . $member->last_name . " - Member Statement.pdf";
            Mail::raw($body, function ($message) use ($member, $file_name) {
                $message->from(Setting::where('setting_key', 'company_email')->first()->setting_value,
                    Setting::where('setting_key', 'company_name')->first()->setting_value);
                $message->to($member->email);
                $headers = $message->getHeaders();
                $message->attach(public_path() . '/uploads/temporary/member_statement' . $member->id . ".pdf",
                    ["as" => $file_name]);
                $message->setContentType('text/html');
                $message->setSubject(Setting::where('setting_key',
                    'member_statement_email_subject')->first()->setting_value);

            });
            unlink(public_path() . '/uploads/temporary/member_statement' . $member->id . ".pdf");
            $mail = new Email();
            $mail->user_id = Sentinel::getUser()->id;
            $mail->message = $body;
            $mail->subject = Setting::where('setting_key',
                'member_statement_email_subject')->first()->setting_value;
            $mail->recipients = 1;
            $mail->send_to = $member->first_name . ' ' . $member->last_name . '(' . $member->id . ')';
            $mail->save();
            Flash::success("Statment successfully sent");
            return redirect('member/' . $member->id . '/show');
        } else {
            Flash::warning("Member has no email set");
            return redirect('member/' . $member->id . '/show');
        }
    }
}
