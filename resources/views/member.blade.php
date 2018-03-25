@extends('layouts.auth')
@section('title')
    {{ trans('login.register') }}
@endsection

@section('content')

    <div class="container" >

        @if(Session::has('flash_notification.message'))
            <script>toastr.{{ Session::get('flash_notification.level') }}('{{ Session::get("flash_notification.message") }}', 'Response Status')</script>
        @endif
        @if (isset($msg))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $msg }}
                    </div>
                </div>
            </div>
        @endif
        @if (isset($error))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $error }}
                    </div>
                </div>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 8px; margin: 10px 0; padding: 15px; ">
                @if($allow)
                    <p class="login-box-msg">Please fill out this form.</p>

                    {!! Form::open(array('url' => url('member/signup'), 'method' => 'post', 'id' => 'add_member_form',"enctype"=>"multipart/form-data")) !!}
                    <div class="box-body">

                    
                        <div class="form-group">
                            {!! Form::label('first_name',trans_choice('general.first_name',1),array('class'=>'')) !!}
                            {!! Form::text('first_name',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.first_name',1),'required'=>'required')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('middle_name',trans_choice('general.middle_name',1),array('class'=>'')) !!}
                            {!! Form::text('middle_name',null, array('class' => 'form-control', 'placeholder'=>'')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name',trans_choice('general.last_name',1),array('class'=>'')) !!}
                            {!! Form::text('last_name',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.last_name',1),'required'=>'required')) !!}
                        </div>
                    

                        <div class="form-group">
                            {!! Form::label('dob',trans_choice('general.dob',1),array('class'=>'')) !!}
                            {!! Form::text('dob',null, array('class' => 'form-control date-picker', 'placeholder'=>"yyyy-mm-dd",'required'=>'required')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('gender',trans_choice('general.gender',1),array('class'=>'')) !!}
                            {!! Form::select('gender',
                                array(
                                    'male'=>trans_choice('general.male',1),
                                    'female'=>trans_choice('general.female',1)),
                                    '', 
                                    array('class' => 'form-control','required'=>'required')
                                ) 
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('marital_status',trans_choice('general.marital_status',1),array('class'=>'')) !!}
                            {!! Form::select('marital_status',array('single'=>trans_choice('general.single',1),'engaged'=>trans_choice('general.engaged',1),'married'=>trans_choice('general.married',1),'divorced'=>trans_choice('general.divorced',1),'widowed'=>trans_choice('general.widowed',1),'separated'=>trans_choice('general.separated',1),'unknown'=>trans_choice('general.unknown',1)),'unknown', array('class' => 'form-control',''=>'')) !!}
                        </div>
                        <div class="form-group hidden">
                            {!! Form::label('status',trans_choice('general.member_status',1),array('class'=>'')) !!}
                            {!! Form::select('status',
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.status.options')),
                                'member', array('class' => 'form-control',''=>'')) !!}
                        </div>
                    
                        <div class="form-group hidden">
                            {!! Form::label('nationality',trans_choice('general.nationality',1),array('class'=>'')) !!}
                            {!! Form::select('nationality', 
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.nationality.options')),
                                config('member.nationality.options'), 
                                array('class' => 'form-control',''=>'')) !!}
                        </div>   
                        <div class="form-group hidden">
                            {!! Form::label('preferred_language',trans_choice('general.preferred_language',1),array('class'=>'')) !!}
                            {!! Form::select('preferred_language', 
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.preferred_language.options')),
                                config('member.preferred_language.options'), 
                                array('class' => 'form-control',''=>'')) !!}
                        </div> 
                        <div class="form-group hidden">
                            {!! Form::label('place_of_birth',trans_choice('general.place_of_birth',1),array('class'=>'')) !!}
                            {!! Form::text('place_of_birth',null, array('class' => 'form-control', 'placeholder'=>'')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('mobile_phone',trans_choice('general.mobile_phone',1),array('class'=>'')) !!}
                            {!! Form::text('mobile_phone',null, array('class' => 'form-control','required'=>'required', 'placeholder'=>trans_choice('general.numbers_only',1))) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email',trans_choice('general.email',1),array('class'=>'')) !!}
                            {!! Form::text('email',null, array('class' => 'form-control','required'=>'required', 'placeholder'=>trans_choice('general.email',1))) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('preferred_contact',trans_choice('general.preferred_contact',1),array('class'=>'')) !!}
                            {!! Form::select('preferred_contact',  
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.preferred_contact.options')),
                                config('member.preferred_contact.options'), 
                                array('class' => 'form-control',''=>'')) !!}
                        </div>


                        <div class="form-group hidden">
                            {!! Form::label('department',trans_choice('general.department',1),array('class'=>'')) !!}
                            {!! Form::select('department',  
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.department.options')),
                                config('member.department.options'), 
                                array('class' => 'form-control',''=>'')) !!}
                        </div>

                        <div class="form-group hidden">
                            {!! Form::label('education',trans_choice('general.education',1),array('class'=>'')) !!}
                            {!! Form::select('education',
                                App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.education.options')),
                                config('member.education.options'), 
                                array('class' => 'form-control',''=>'')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('trade',trans_choice('general.trade',1),array('class'=>'')) !!}
                            {!! Form::text('trade',null, array('class' => 'form-control', 'placeholder'=>'What is you ocupation?')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('notes',trans_choice('general.description',1),array('class'=>'')) !!}
                            {!! Form::textarea('notes',null, array('class' => 'form-control', 'placeholder'=>"Please provide any other details or your interests that you would like to be involved in.")) !!}
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="add_member">{{trans_choice('general.submit',1)}}</button>
                    </div>
                    {!! Form::close() !!}
                    
                    @else
                        <p class="login-box-msg">Self register for members is offline.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
   
    <script>
        $(document).ready(function () {
                jQuery('.register-form').show();      
        });
    </script>
@endsection
