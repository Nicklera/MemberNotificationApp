                    <div class="tab-pane" id="sms">
                        <div class="form-group">
                            {!! Form::label('sms_enabled',trans('general.sms_enabled'),array('class'=>'col-sm-2 control-label')) !!}

                            <div class="col-sm-10">
                                {!! Form::select('sms_enabled',array('1'=>trans('general.yes'),'0'=>trans('general.no')),\App\Models\Setting::where('setting_key','sms_enabled')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('active_sms',trans('general.active_sms'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::select('active_sms',array('routesms'=>'Route SMS','twilio'=>'Twilio','clickatell'=>'Clickatell','infobip'=>'Infobip'),\App\Models\Setting::where('setting_key','active_sms')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('sms_sender',trans('general.sms_sender'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('sms_sender',\App\Models\Setting::where('setting_key','sms_sender')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label(trans('general.twilio_sid'),null,array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('twilio_sid',\App\Models\Setting::where('setting_key','twilio_sid')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('twilio_token',trans('general.twilio_token'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('twilio_token',\App\Models\Setting::where('setting_key','twilio_token')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('twilio_phone_number',trans('general.twilio_phone_number'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('twilio_phone_number',\App\Models\Setting::where('setting_key','twilio_phone_number')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('routesms_host',trans('general.routesms_host'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('routesms_host',\App\Models\Setting::where('setting_key','routesms_host')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('routesms_port',trans('general.routesms_port'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('routesms_port',\App\Models\Setting::where('setting_key','routesms_port')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('routesms_username',trans('general.routesms_username'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('routesms_username',\App\Models\Setting::where('setting_key','routesms_username')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('routesms_password',trans('general.routesms_password'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('routesms_password',\App\Models\Setting::where('setting_key','routesms_password')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('clickatell_api_id',trans('general.clickatell_api_id'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('clickatell_api_id',\App\Models\Setting::where('setting_key','clickatell_api_id')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('infobip_username','Infobip Username',array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('infobip_username',\App\Models\Setting::where('setting_key','infobip_username')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('infobip_password','Infobip Password',array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('infobip_password',\App\Models\Setting::where('setting_key','infobip_password')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info">{{ trans('general.save') }}</button>
                            </div>
                        </div>
                    </div>