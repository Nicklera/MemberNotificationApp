@extends('layouts.master')
@section('title')
    {{trans_choice('general.add',1)}} {{trans_choice('general.member',1)}}
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans_choice('general.add',1)}} {{trans_choice('general.member',1)}}</h3>

            <div class="box-tools pull-right">

            </div>
        </div>
        {!! Form::open(array('url' => url('member/store'), 'method' => 'post', 'id' => 'add_member_form',"enctype"=>"multipart/form-data")) !!}
        <div class="box-body">

                <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('first_name',trans_choice('general.first_name',1),array('class'=>'')) !!}
                {!! Form::text('first_name',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.first_name',1),'required'=>'required')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('middle_name',trans_choice('general.middle_name',1),array('class'=>'')) !!}
                {!! Form::text('middle_name',null, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('last_name',trans_choice('general.last_name',1),array('class'=>'')) !!}
                {!! Form::text('last_name',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.last_name',1),'required'=>'required')) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                {!! Form::label('dob',trans_choice('general.dob',1),array('class'=>'')) !!}
                {!! Form::text('dob',null, array('class' => 'form-control date-picker', 'placeholder'=>"yyyy-mm-dd")) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('gender',trans_choice('general.gender',1),array('class'=>'')) !!}
                {!! Form::select('gender',array('male'=>trans_choice('general.male',1),'female'=>trans_choice('general.female',1)),'', array('class' => 'form-control','require'=>'true')) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('marital_status',trans_choice('general.marital_status',1),array('class'=>'')) !!}
                {!! Form::select('marital_status',array('single'=>trans_choice('general.single',1),'engaged'=>trans_choice('general.engaged',1),'married'=>trans_choice('general.married',1),'divorced'=>trans_choice('general.divorced',1),'widowed'=>trans_choice('general.widowed',1),'separated'=>trans_choice('general.separated',1),'unknown'=>trans_choice('general.unknown',1)),'unknown', array('class' => 'form-control',''=>'')) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('status',trans_choice('general.member_status',1),array('class'=>'')) !!}
                {!! Form::select('status',array(
                    'inactive'=>trans_choice('general.inactive',1),
                    'active'=>trans_choice('general.active',1)),
                    'active', array('class' => 'form-control',''=>'')) !!}
            </div>
           
        </div>
       
        <div class="form-row">
            <div class="form-group col-md-3">
                {!! Form::label('nationality',trans_choice('general.nationality',1),array('class'=>'')) !!}
                {!! Form::select('nationality',array(
                        'american'=>trans_choice('general.american',1),
                        'russian'=>trans_choice('general.russian',1),
                        'ukrainian'=>trans_choice('general.ukrainian',1),
                        'moldovian'=>trans_choice('general.moldovian',1),
                        'belorussian'=>trans_choice('general.belorussian',1),
                        'other'=>trans_choice('general.other',1)
                        ),'american', array('class' => 'form-control',''=>'')) !!}
            </div>   
            <div class="form-group col-md-3">
                {!! Form::label('preferred_language',trans_choice('general.preferred_language',1),array('class'=>'')) !!}
                {!! Form::select('preferred_language',array(
                        'english'=>trans_choice('general.english',1),
                        'russian'=>trans_choice('general.russian',1),
                        'ukrainian'=>trans_choice('general.ukrainian',1),
                        'moldovian'=>trans_choice('general.moldovian',1)                        
                        ),'english', array('class' => 'form-control',''=>'')) !!}
            </div> 
            <div class="form-group col-md-6">
                {!! Form::label('place_of_birth',trans_choice('general.place_of_birth',1),array('class'=>'')) !!}
                {!! Form::text('place_of_birth',null, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('mobile_phone',trans_choice('general.mobile_phone',1),array('class'=>'')) !!}
                {!! Form::text('mobile_phone',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.numbers_only',1))) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('email',trans_choice('general.email',1),array('class'=>'')) !!}
                {!! Form::text('email',null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.email',1))) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('preferred_contact',trans_choice('general.preferred_contact',1),array('class'=>'')) !!}
                {!! Form::select('preferred_contact',array(
                    'email'=>trans_choice('general.email',1),
                    'sms'=>trans_choice('general.sms',1)),
                    'sms', array('class' => 'form-control',''=>'')) !!}
            </div>
        </div>
           
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('department',trans_choice('general.department',1),array('class'=>'')) !!}
                {!! Form::select('department',array(
                        'college'=>trans_choice('general.college',1),
                        'youth'=>trans_choice('general.youth',1),
                        'prayer'=>trans_choice('general.prayer',1),
                        'other'=>trans_choice('general.other',1)                        
                        ),'other', array('class' => 'form-control',''=>'')) !!}
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('education',trans_choice('general.education',1),array('class'=>'')) !!}
                {!! Form::select('education',array(
                        'none'=>trans_choice('general.none',1),
                        'diploma'=>trans_choice('general.diploma',1),
                        'technical'=>trans_choice('general.technical',1),
                        'associate'=>trans_choice('general.associate',1),
                        'bachelor'=>trans_choice('general.bachelor',1),
                        'masters'=>trans_choice('general.masters',1),
                        'professional'=>trans_choice('general.professional',1),
                        'doctoral'=>trans_choice('general.doctoral',1)                           
                        ),'none', array('class' => 'form-control',''=>'')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('trade',trans_choice('general.trade',1),array('class'=>'')) !!}
                {!! Form::text('trade',null, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
        </div>
           
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('address',trans_choice('general.address',1),array('class'=>'')) !!}
                {!! Form::textarea('address',null, array('class' => 'form-control', 'rows'=>"3")) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('notes',trans_choice('general.description',1),array('class'=>'')) !!}
                {!! Form::textarea('notes',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
            </div>
           
        </div>
            <div class="form-group col-md-6">
                {!! Form::label('photo',trans_choice('general.photo',1),array('class'=>'')) !!}
                {!! Form::file('photo', array('class' => 'form-control', 'placeholder'=>"")) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('files',trans_choice('general.file',2). ' '.trans_choice('general.borrower_file_types',2),array('class'=>'')) !!}
                {!! Form::file('files[]', array('class' => 'form-control', 'multiple'=>"")) !!}

                {{trans_choice('general.select_thirty_files',2)}}

            </div>
            <div class="form-group">
                {!! Form::label('tags',trans_choice('general.assign',2). ' '.trans_choice('general.tag',2),array('class'=>'')) !!}

                <div id="jstree_div">
                    <ul>

                        <li data-jstree='{ "opened" : true }'
                            id="1">{{trans_choice('general.all',2)}} {{trans_choice('general.tag',2)}}
                            ({{\App\Models\MemberTag::count()}} {{trans_choice('general.people',2)}})
                            {!! \App\Helpers\GeneralHelper::createTreeView(1,$menus) !!}
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="tags" id="tags" value=""/>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right" id="add_member">{{trans_choice('general.save',1)}}</button>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection
@section('footer-scripts')
    <script>
        $('#jstree_div').jstree({
            "core": {
                "themes": {
                    "responsive": true
                },
                // so that create works
                "check_callback": true,
            },
            "plugins": ["checkbox", 'wholerow'],
        });
        $('#add_member').click(function (e) {
            e.preventDefault();
            $('#tags').val($('#jstree_div').jstree("get_selected"))
            $('#add_member_form').submit();
        })
    </script>
@endsection

