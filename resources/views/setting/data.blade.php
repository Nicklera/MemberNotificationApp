@extends('layouts.master')
@section('title')
    {{ trans_choice('general.setting',2) }}
@endsection
@section('content')
    <div class="box box-primary">
        {!! Form::open(array('url' => url('setting/update'), 'method' => 'post', 'name' => 'form','class'=>"form-horizontal","enctype"=>"multipart/form-data")) !!}
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans_choice('general.setting',2) }}</h3>

            <div class="box-tools pull-right">
                <button type="submit" class="btn btn-info">{{ trans('general.save') }}</button>
            </div>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="#general" data-toggle="tab">{{ trans('general.general') }}</a></li>
                    <li><a href="#sms" data-toggle="tab">{{ trans('general.sms') }}</a></li>
                    <li><a href="#email_templates"
                           data-toggle="tab">{{ trans_choice('general.email',1) }} {{ trans_choice('general.template',2) }}</a>
                    </li>
                    <li><a href="#sms_templates"
                           data-toggle="tab">{{ trans_choice('general.sms',1) }} {{ trans_choice('general.template',2) }}</a>
                    </li>
                    <li class="active"><a href="#system" data-toggle="tab">{{ trans_choice('general.system',1) }}</a>
                    </li>                  
                </ul>
                <div class="tab-content">
                    @include('setting.partials.general_tab')
                    @include('setting.partials.sms_tab')
                    @include('setting.partials.email_templates_tab')
                    @include('setting.partials.sms_templates_tab')
                    @include('setting.partials.system_tab')
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">{{ trans('general.save') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection
