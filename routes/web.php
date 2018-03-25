<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//route for installation
Route::get('install', 'InstallController@index');
Route::group(['prefix' => 'install'], function () {
    Route::get('start', 'InstallController@index');
    Route::get('requirements', 'InstallController@requirements');
    Route::get('permissions', 'InstallController@permissions');
    Route::any('database', 'InstallController@database');
    Route::any('installation', 'InstallController@installation');
    Route::get('complete', 'InstallController@complete');

});
//cron route
Route::get('cron', 'CronController@index');
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return redirect('/');

});
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return redirect('/');
});
Route::get('/', 'HomeController@index');
Route::get('login', 'HomeController@login');
Route::get('client', 'HomeController@clientLogin');
Route::post('client', 'HomeController@processClientLogin');
// Members signup form
Route::get('member/signup', 'HomeController@memberSignup');
Route::post('member/signup', 'HomeController@processMemberSignup');

Route::get('client_logout', 'HomeController@clientLogout');
Route::get('admin', 'HomeController@adminLogin');

Route::get('logout', 'HomeController@logout');
Route::post('login', 'HomeController@processLogin');
Route::post('register', 'HomeController@register');
Route::post('reset', 'HomeController@passwordReset');
Route::get('reset/{id}/{code}', 'HomeController@confirmReset');
Route::post('reset/{id}/{code}', 'HomeController@completeReset');
Route::get('check/{id}', 'HomeController@checkStatus');
Route::get('dashboard', [
    'middleware' => 'sentinel',
    function () {
        $events = [];
        foreach (\App\Models\Event::all() as $event) {
            //determine color
            if (!empty($event->calendar)) {
                $color = $event->calendar->color;
            } else {
                $color = "#283593";
            }
            if ($event->all_day == 1) {
                array_push($events, array(
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'color' => $color,
                    'type' => 'event',
                    'url' => url('event/' . $event->id . '/show')
                ));
            } else {
                array_push($events, array(
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start_date . 'T' . $event->start_time,
                    'end' => $event->end_date . 'T' . $event->end_time,
                    'color' => $color,
                    'type' => 'event',
                    'url' => url('event/' . $event->id . '/show')
                ));
            }

        }
        $events = json_encode($events);
        return view('dashboard', compact('events'));
    }
]);

//route for members
Route::group(['prefix' => 'member'], function () {

    Route::get('data', 'MemberController@index')->name('member.data');
    Route::get('pending', 'MemberController@pending');
    Route::get('create', 'MemberController@create');
    Route::post('store', 'MemberController@store');
    Route::get('{member}/show', 'MemberController@show')->name('member.show');
    Route::get('{member}/edit', 'MemberController@edit')->name('member.edit');
    Route::post('{id}/update', 'MemberController@update');
    Route::get('{id}/delete', 'MemberController@delete')->name('member.delete');
    Route::get('{id}/approve', 'MemberController@approve');
    Route::get('{id}/decline', 'MemberController@decline');
    Route::get('{id}/delete_file', 'MemberController@deleteFile');
    Route::get('{id}/blacklist', 'MemberController@blacklist');
    Route::get('{id}/unblacklist', 'MemberController@unBlacklist');
    Route::get('{member}/family/create', 'MemberController@createFamily');
    Route::get('{id}/family/delete_family_member', 'MemberController@deleteFamilyMember');
    Route::post('{id}/family/store_family_member', 'MemberController@storeFamilyMember');
    Route::get('{family_member}/family/edit_family_member', 'MemberController@editFamilyMember');
    Route::post('{id}/family/update_family_member', 'MemberController@updateFamilyMember');
    Route::get('{member}/statement/pdf', 'MemberController@pdfStatement');
    Route::get('{member}/statement/print', 'MemberController@printStatement');
    Route::get('{member}/statement/email', 'MemberController@emailStatement');
});


Route::group(['prefix' => 'update'], function () {
    Route::get('download', 'UpdateController@download');
    Route::get('install', 'UpdateController@install');
    Route::get('clean', 'UpdateController@clean');
    Route::get('finish', 'UpdateController@finish');
});
Route::get('fix', 'UpdateController@fix');
//route for setting
Route::group(['prefix' => 'setting'], function () {
    Route::get('data', 'SettingController@index');
    Route::post('update', 'SettingController@update');
    Route::get('update_system', 'SettingController@updateSystem');
});
//route for user
Route::group(['prefix' => 'user'], function () {
    Route::get('data', 'UserController@index');
    Route::get('create', 'UserController@create');
    Route::post('store', 'UserController@store');
    Route::get('{user}/edit', 'UserController@edit');
    Route::get('{user}/show', 'UserController@show');
    Route::post('{id}/update', 'UserController@update');
    Route::get('{id}/delete', 'UserController@delete');
    Route::get('{id}/profile', 'UserController@profile');
    Route::post('{id}/profile', 'UserController@profileUpdate');
    //manage permissions
    Route::get('permission/data', 'UserController@indexPermission');
    Route::get('permission/create', 'UserController@createPermission');
    Route::post('permission/store', 'UserController@storePermission');
    Route::get('permission/{permission}/edit', 'UserController@editPermission');
    Route::post('permission/{id}/update', 'UserController@updatePermission');
    Route::get('permission/{id}/delete', 'UserController@deletePermission');
    //manage roles
    Route::get('role/data', 'UserController@indexRole');
    Route::get('role/create', 'UserController@createRole');
    Route::post('role/store', 'UserController@storeRole');
    Route::get('role/{id}/edit', 'UserController@editRole');
    Route::post('role/{id}/update', 'UserController@updateRole');
    Route::get('role/{id}/delete', 'UserController@deleteRole');
});

//route for communication
Route::group(['prefix' => 'communication'], function () {
    Route::get('email', 'CommunicationController@indexEmail');
    Route::get('sms', 'CommunicationController@indexSms');
    Route::get('email/create', 'CommunicationController@createEmail');
    Route::post('email/store', 'CommunicationController@storeEmail');
    Route::get('email/{id}/delete', 'CommunicationController@deleteEmail');
    Route::get('sms/create', 'CommunicationController@createSms');
    Route::post('sms/store', 'CommunicationController@storeSms');
    Route::get('sms/{id}/delete', 'CommunicationController@deleteSms');

});


//route for tags
Route::group(['prefix' => 'tag'], function () {
    Route::get('data', 'TagController@index');
    Route::get('create', 'TagController@create');
    Route::post('store', 'TagController@store');
    Route::post('add_members', 'TagController@add_members');
    Route::post('sms_members', 'TagController@sms_members');
    Route::post('email_members', 'TagController@email_members');
    Route::get('{tag}/edit', 'TagController@edit');
    Route::get('{tag}/tag_data', 'TagController@tag_data');
    Route::get('{tag}/show', 'TagController@show');
    Route::post('{id}/update', 'TagController@update');
    Route::get('{id}/delete', 'TagController@delete');
    Route::get('{id}/remove_member', 'TagController@remove_member');
});
//routes for events
Route::group(['prefix' => 'event'], function () {
    Route::get('data', 'EventController@index');
    Route::get('create', 'EventController@create');
    Route::post('store', 'EventController@store');
    Route::get('{event}/edit', 'EventController@edit');
    Route::get('{event}/show', 'EventController@show');
    Route::post('sms_members', 'EventController@sms_members');
    Route::post('email_members', 'EventController@email_members');
    Route::post('sms_volunteers', 'EventController@sms_volunteers');
    Route::post('email_volunteers', 'EventController@email_volunteers');
    Route::get('{event}/attender', 'EventController@attender');
    Route::get('{event}/report', 'EventController@report');
    Route::get('{event}/check_in', 'EventController@check_in');
    Route::get('{event}/volunteer', 'EventController@volunteer');
    Route::post('add_volunteer', 'EventController@add_volunteer');
    Route::post('add_checkin', 'EventController@add_checkin');
    Route::get('{id}/remove_checkin', 'EventController@remove_checkin');
    Route::get('{id}/remove_volunteer', 'EventController@remove_volunteer');
    Route::post('{id}/update_volunteer', 'EventController@update_volunteer');
    Route::get('{volunteer}/get_volunteer', 'EventController@get_volunteer');
    Route::get('{volunteer}/volunteer_detail', 'EventController@volunteer_detail');
    Route::post('{id}/update', 'EventController@update');
    Route::get('{id}/delete', 'EventController@delete');
    Route::get('{id}/delete_file', 'EventController@deleteFile');

    //location
    Route::get('location/data', 'EventLocationController@index');
    Route::get('location/create', 'EventLocationController@create');
    Route::post('location/store', 'EventLocationController@store');
    Route::get('location/{location}/edit', 'EventLocationController@edit');
    Route::get('location/{location}/show', 'EventLocationController@show');
    Route::post('location/{id}/update', 'EventLocationController@update');
    Route::get('location/{id}/delete', 'EventLocationController@delete');
    //calendar
    Route::get('calendar/data', 'EventCalendarController@index');
    Route::get('calendar/create', 'EventCalendarController@create');
    Route::post('calendar/store', 'EventCalendarController@store');
    Route::get('calendar/{calendar}/edit', 'EventCalendarController@edit');
    Route::get('calendar/{calendar}/show', 'EventCalendarController@show');
    Route::post('calendar/{id}/update', 'EventCalendarController@update');
    Route::get('calendar/{id}/delete', 'EventCalendarController@delete');
    //volunteer role
    Route::get('role/data', 'VolunteerRoleController@index');
    Route::get('role/create', 'VolunteerRoleController@create');
    Route::post('role/store', 'VolunteerRoleController@store');
    Route::get('role/{volunteer_role}/edit', 'VolunteerRoleController@edit');
    Route::get('role/{volunteer_role}/show', 'VolunteerRoleController@show');
    Route::post('role/{id}/update', 'VolunteerRoleController@update');
    Route::get('role/{id}/delete', 'VolunteerRoleController@delete');
});
Route::get('audit_trail/data', 'AuditTrailController@index')->name('audit.data');
//routes for contributions
Route::group(['prefix' => 'contribution'], function () {
    Route::get('data', 'ContributionController@index');
    Route::get('create', 'ContributionController@create');
    Route::post('store', 'ContributionController@store');
    Route::get('{contribution}/edit', 'ContributionController@edit');
    Route::get('{contribution}/show', 'ContributionController@show');
    Route::post('{id}/update', 'ContributionController@update');
    Route::get('{id}/delete', 'ContributionController@delete');
    Route::get('{id}/delete_file', 'ContributionController@deleteFile');

    //payment methods
    Route::get('payment_method/data', 'PaymentMethodController@index');
    Route::get('payment_method/create', 'PaymentMethodController@create');
    Route::post('payment_method/store', 'PaymentMethodController@store');
    Route::get('payment_method/{payment_method}/edit', 'PaymentMethodController@edit');
    Route::get('payment_method/{payment_method}/show', 'PaymentMethodController@show');
    Route::post('payment_method/{id}/update', 'PaymentMethodController@update');
    Route::get('payment_method/{id}/delete', 'PaymentMethodController@delete');
    //funds
    Route::get('fund/data', 'FundController@index');
    Route::get('fund/create', 'FundController@create');
    Route::post('fund/store', 'FundController@store');
    Route::get('fund/{fund}/edit', 'FundController@edit');
    Route::get('fund/{fund}/show', 'FundController@show');
    Route::post('fund/{id}/update', 'FundController@update');
    Route::get('fund/{id}/delete', 'FundController@delete');
    //batches
    Route::get('batch/data', 'ContributionBatchController@index');
    Route::get('batch/create', 'ContributionBatchController@create');
    Route::post('batch/store', 'ContributionBatchController@store');
    Route::get('batch/{contribution_batch}/edit', 'ContributionBatchController@edit');
    Route::get('batch/{contribution_batch}/show', 'ContributionBatchController@show');
    Route::post('batch/{id}/update', 'ContributionBatchController@update');
    Route::get('batch/{id}/delete', 'ContributionBatchController@delete');
    Route::get('batch/{id}/open', 'ContributionBatchController@open');
    Route::get('batch/{id}/close', 'ContributionBatchController@close');
});

//routes for follow ups
Route::group(['prefix' => 'follow_up'], function () {
    Route::get('data', 'FollowUpController@index');
    Route::get('my_follow_ups', 'FollowUpController@my_follow_ups');
    Route::get('create', 'FollowUpController@create');
    Route::post('store', 'FollowUpController@store');
    Route::get('{follow_up}/edit', 'FollowUpController@edit');
    Route::get('{follow_up}/show', 'FollowUpController@show');
    Route::post('{id}/update', 'FollowUpController@update');
    Route::get('{id}/delete', 'FollowUpController@delete');
    Route::get('{id}/complete', 'FollowUpController@complete');
    Route::get('{id}/incomplete', 'FollowUpController@incomplete');
    Route::get('{id}/delete_file', 'FollowUpController@deleteFile');
    //categories
    Route::get('category/data', 'FollowUpCategoryController@index');
    Route::get('category/create', 'FollowUpCategoryController@create');
    Route::post('category/store', 'FollowUpCategoryController@store');
    Route::get('category/{follow_up_category}/edit', 'FollowUpCategoryController@edit');
    Route::get('category/{follow_up_category}/show', 'FollowUpCategoryController@show');
    Route::post('category/{id}/update', 'FollowUpCategoryController@update');
    Route::get('category/{id}/delete', 'FollowUpCategoryController@delete');
    Route::get('category/{id}/open', 'FollowUpCategoryController@open');
    Route::get('category/{id}/close', 'FollowUpCategoryController@close');
});