<div class="tab-pane active" id="system">
    <div class="form-group">
        {!! Form::label('enable_cron',trans('general.cron_enabled'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::select('enable_cron',array('1'=>trans('general.yes'),'0'=>trans('general.no')),\App\Models\Setting::where('setting_key','enable_cron')->first()->setting_value,array('class'=>'form-control')) !!}
            <small>Last
                Run:@if(!empty(\App\Models\Setting::where('setting_key','cron_last_run')->first()->setting_value)) {{\App\Models\Setting::where('setting_key','cron_last_run')->first()->setting_value}} @else
                    Never @endif</small>
            <br>
            <small>Cron Url: {{url('cron')}}</small>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('google_maps_key',trans('general.google_maps_key'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::text('google_maps_key',\App\Models\Setting::where('setting_key','google_maps_key')->first()->setting_value,array('class'=>'form-control','rows'=>'3')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('email_volunteer_assignment',trans('general.email_volunteer_assignment'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::select('email_volunteer_assignment',array('1'=>trans('general.yes'),'0'=>trans('general.no')),\App\Models\Setting::where('setting_key','email_volunteer_assignment')->first()->setting_value,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>