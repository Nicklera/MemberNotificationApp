                    <div class="tab-pane" id="general">
                        <div class="form-group">
                            {!! Form::label('company_name',trans('general.company_name'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('company_name',\App\Models\Setting::where('setting_key','company_name')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('company_email',trans('general.company_email'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::email('company_email',\App\Models\Setting::where('setting_key','company_email')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('company_website',trans('general.company_website'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('company_website',\App\Models\Setting::where('setting_key','company_website')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('company_address',trans('general.company_address'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('company_address',\App\Models\Setting::where('setting_key','company_address')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('company_country',trans('general.country'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('company_country',\App\Models\Setting::where('setting_key','company_country')->first()->setting_value,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('portal_address',trans('general.portal_address'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::text('portal_address',\App\Models\Setting::where('setting_key','portal_address')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>

                         <div class="form-group">
                            {!! Form::label('allow_client_login','Allow Members Login',array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::select('allow_client_login',array('1'=>trans('general.yes'),'0'=>trans('general.no')),\App\Models\Setting::where('setting_key','allow_client_login')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}                            
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('allow_self_registration','Allow Members Self-Register',array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::select('allow_self_registration',array('1'=>trans('general.yes'),'0'=>trans('general.no')),\App\Models\Setting::where('setting_key','allow_self_registration')->first()->setting_value,array('class'=>'form-control','required'=>'required')) !!}                            
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('company_logo',trans('general.company_logo'),array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-md-10">
                                @if(!empty(\App\Models\Setting::where('setting_key','company_logo')->first()->setting_value))
                                    <img src="{{ url(asset('uploads/'.\App\Models\Setting::where('setting_key','company_logo')->first()->setting_value)) }}"
                                         class="col-md-2 img-responsive"/>

                                @endif
                                {!! Form::file('company_logo',array('class'=>'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info">{{ trans('general.save') }}</button>
                            </div>
                        </div>
                    </div>