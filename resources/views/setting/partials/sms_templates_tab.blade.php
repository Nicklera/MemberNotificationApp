<div class="tab-pane" id="sms_templates">
    <p>Universal tags to use: <span class="label label-info">{firstName}</span> <span
                class="label label-info">{lastName}</span> <span
                class="label label-info">{address}</span>
        <span class="label label-info">{mobilePhone}</span> <span class="label label-info">{homePhone}</span>
        <span class="label label-info">{paymentAmount}</span>
        <span class="label label-info">{paymentDate}</span>
    </p>

    <div class="form-group">
        {!! Form::label('follow_up_sms_template',trans('general.follow_up_sms_template'),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
            {!! Form::textarea('follow_up_sms_template',\App\Models\Setting::where('setting_key','follow_up_sms_template')->first()->setting_value,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>