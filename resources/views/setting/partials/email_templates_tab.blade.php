<div class="tab-pane" id="email_templates">

    <p>You can use any of the following tags: <span class="label label-info">{firstName}</span>
        <span
                class="label label-info">{lastName}</span> <span
                class="label label-info">{address}</span>
        <span class="label label-info">{mobilePhone}</span> <span class="label label-info">{homePhone}</span>
    </p>

    <div class="form-group">
        {!! Form::label('password_reset_subject',trans('general.password_reset_subject'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::text('password_reset_subject',\App\Models\Setting::where('setting_key','password_reset_subject')->first()->setting_value,array('class'=>'form-control')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('password_reset_template',trans('general.password_reset_template'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::textarea('password_reset_template',\App\Models\Setting::where('setting_key','password_reset_template')->first()->setting_value,array('class'=>'form-control tinymce')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('follow_up_email_subject',trans('general.follow_up_email_subject'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::text('follow_up_email_subject',\App\Models\Setting::where('setting_key','follow_up_email_subject')->first()->setting_value,array('class'=>'form-control')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('follow_up_email_template',trans('general.follow_up_email_template'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::textarea('follow_up_email_template',\App\Models\Setting::where('setting_key','follow_up_email_template')->first()->setting_value,array('class'=>'form-control tinymce')) !!}
        </div>
    </div>         
    <div class="form-group">
        {!! Form::label('volunteer_assignment_email_template',trans('general.volunteer_assignment_email_template'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::textarea('volunteer_assignment_email_template',\App\Models\Setting::where('setting_key','volunteer_assignment_email_template')->first()->setting_value,array('class'=>'form-control tinymce')) !!}
        </div>
    </div>             
</div>