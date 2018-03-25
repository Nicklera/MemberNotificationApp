@extends('layouts.auth')
@section('title')
    {{ trans('login.login') }}
@endsection
@section('customCss')
<style>
* {
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
}
body {
    background: #dde3e8;
}
.wrapper, 
.container {
    height: 525px;
    width: 337px;
}
.wrapper {
    margin: auto;
    position: absolute;
    top: -10px; right: 0; bottom: 0; left: 0;
}
.container {
    position: relative;
}
.container .stencil {
    border: 5px solid #77dff9;
    height: 440px;
    width: 235px;
    transform: matrix(0.85,0.8,-0.08,0.7,19,43);   
    position: absolute;
    z-index: 1;
}
.container .stencil .line {
    border: 3px solid #77dff9 ;
    height: 94.6%;
    margin: 11px 0;
    border-right: none;
    border-left: none;
}
.container .border-triangle  {
    position: absolute;
    z-index: 10;
    border-top: 257px solid transparent;
    border-left: 337px solid rgba(255,255,255,0.5);
    border-bottom: 268px solid transparent;  
}
.container .content-triangle {
    position: absolute;
    left: 12px;
    top: 22px;
    border-top: 235px solid transparent;
    border-left: 307px solid #fff;
    border-bottom: 245px solid transparent;
    z-index: 15;
}
.container .content-triangle:before,
.container .content-triangle:after,
.container form .title:after {
    content: '';
    position: absolute;
    width: 10px;
    height: 15px;
    border: 1px solid #71d2ec;
    
}
.container .content-triangle:before {
    border-bottom: none;
    border-right: none;
    transform: matrix(0.85,0.64,-0,0.7,-295,-203);
}
.container .content-triangle:after {
    border-top: none;
    border-right: none;
    transform: matrix(0.85,-0.7,-0,0.7,-295,197);
}
.container .enter-triangle-one {
    position: absolute;
    border-top: 90px solid transparent;
    border-left: 135px solid #192042;
    border-bottom: 76px solid transparent;
    transform: rotate(51.5deg);
    bottom: 5px;
    left: 153px;
    z-index: 5;
}
.container .enter-triangle-one:before {
    content: '';
    position: absolute;
    border-top: 120px solid transparent;
    border-left: 188px solid #192042;
    border-bottom: 141px solid transparent;
    transform: rotate(4deg);
    bottom: -129px;
    left: -207px;
    -webkit-filter: blur(20px);
    filter: blur(20px);
    z-index: 5;
}
.container .enter-triangle-two {
    position: absolute;
    border-top: 111px solid transparent;
    border-left: 108px solid rgba(40, 65, 143, 0.2);
    border-bottom: 47px solid transparent;
    transform: rotate(51deg);
    bottom: 13px;
    left: 148px;
    z-index: 6;
}
.container form {
    position: absolute;
    z-index: 20;
    top: 166px;
    left: 30px;
}
.container form:before,
.container form:after,
.container form .input-inform:before,
.container form .title:before {
    content: '';
    position: absolute;
    background: rgba(204,204,204,0.13);
    height: 1px;
}
.container form:before {
    width: 315px;
    transform: rotate(37.2deg);
    left: -28px;
    top: -11px;
}
.container form:after {
    width: 320px;
    left: -31px;
    bottom: 35px;
    transform: rotate(-39deg);
}
.container form .title {
    border-bottom: 1px solid #67e2fb;
    padding-bottom: 2px;
    margin: 0 0 13px 9px;
    width: 140px;
}

.container form .title:after {
    border-top: none;
    border-left: none;
    width: 8px;
    height: 9px;
    transform: matrix(0.85,-0.7,0.8,0.6,241,37);
}
.container form label {
    display: block;
    color: #6b707d;
    font-size: 20px;
    font-weight: 300;
    line-height: 24px;
}
.container form .input-inform:before {
    width: 1px;
    height: 396px;
    left: -5px;
    top: -102px;
}
.container form input:focus {
    outline: none;
}
.container form label:last-child {
    font-weight: bold;
    letter-spacing: 1px;
}
.container form input[type="text"],
.container form input[type="password"] {
    border: none;
    border-bottom: 1px solid #f2f2f2;
    display: block;
    width: 160px;
    color: #71d2ec;
}
.container form input[type="text"] {
    padding: 0 0 7px 9px;
}
.container form input[type="password"] {
    padding: 0 0 7px 9px;
}
.container form #forgot-pas,
.container form .enter,
.container form .enter label,
.container form #enter {
    cursor: pointer;
    position: relative;
}
.container form #forgot-pas {
    color: #192141;
    background: #fff;
    border: 1px solid #f2f2f2;
    font-size: 9px;
    height: 18px;
    width: 113px;
    top: 7px;
    left: -1px;
}
.container form .enter {
    width: 50px;
    height: 50px;
    top: 35px;
    left: 148px;
}
.container form .enter label:before {
    content: '\1F512';
    color: rgba(197, 197, 197,0.6);
    left: 10px;
    top: 7px;
    position: relative;
}
.container form .enter label:hover:before {
    content: '\1F513';
}
.container form #enter {
    color: #fff;
    border: none;
    font-size: 10px;
    background: transparent;
}</style>
@endsection
@section('content')
@if(Session::has('flash_notification.message'))
    <script>toastr.{{ Session::get('flash_notification.level') }}('{{ Session::get("flash_notification.message") }}', 'Response Status')</script>
@endif
@if (isset($msg))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ $msg }}
    </div>
@endif
@if (isset($error))
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ $error }}
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="stencil">
        <div class="line">
            <div class="line"></div>
        </div>
    </div>
    <div class="border-triangle"></div>
    <div class="content-triangle"></div>
    <div class="enter-triangle-one"></div>
    <div class="enter-triangle-two"></div>
    {!! Form::open(array('url' => url('login'), 'id' => 'form', 'method' => 'post', 'name' => 'form','class'=>'login-form')) !!}

        <div class="title">
            <label>LOG INTO</label>
            <label>{{ \App\Models\Setting::where('setting_key','company_name')->first()->setting_value }}</label>
        </div>
        <div class="input-inform">
            <input type="text" name="email" id="name" placeholder="EMAIL..." />
            <input type="password" name="password" id="password" placeholder="PASSWORD..." />
            <a id="forgot-pas" href="javascript:;">FORGOT PASSWORD?</a>

        </div>
        <div class="enter">
            <label for="enter"></label>
            <input type="submit" name="submit" value="ENTER" id="enter"/>
        </div>
    {!! Form::close() !!}
    {!! Form::open(array('url' => url('reset'), 'method' => 'post', 'name' => 'form','class'=>'forget-form', 'style' => 'display:none;')) !!}
         <div class="title">
            <label>Enter your email to reset.</label>
        </div>
        <div class="input-inform">
            <input type="text" name="email" id="name" placeholder="EMAIL..." />
         
            <button type="submit" class="btn btn-sm btn-block btn-flat">{{ trans('login.reset_btn') }}</button>
        </div>
      
               <input type="button" class="btn btn-link btn-sm" id="back-btn" value="GO BACK" />
                            
        {!! Form::close() !!}    
</div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
         
            jQuery('#forgot-pas').click(function () {
                jQuery('.login-form').hide();
                jQuery('.forget-form').show();
            });
            jQuery('#register-btn').click(function () {
                jQuery('.login-form').hide();
                jQuery('.register-form').show();
            });

            jQuery('#back-btn').click(function () {
                jQuery('.login-form').show();
                jQuery('.forget-form').hide();
            });
            jQuery('#register-back-btn').click(function () {
                jQuery('.login-form').show();
                jQuery('.register-form').hide();
            });
            $('#check_btn').click(function (e) {
                e.preventDefault();
                var repair = $('#repair_number').val();
                if (repair == '') {
                    toastr.warning('Repair Number can not be empty', 'Response Status')
                } else {
                    $.ajax( {
                        url:'{!! url('check') !!}/'+repair,
                        success: function(data) {
                            toastr.success('Loading information', 'Response Status')
                            $('#status').find('.modal-body').html($(data));
                            $('#status').modal();
                        },
                        error: function() {
                            toastr.warning('There was an error processing the request', 'Response Status')
                        },
                        type:'GET'
                    });
                }
            })
        });
    </script>
@endsection
