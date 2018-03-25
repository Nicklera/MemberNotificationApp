@extends('layouts.master')
@section('title')
    {{trans_choice('general.edit',1)}} {{trans_choice('general.member',1)}}
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans_choice('general.edit',1)}} {{trans_choice('general.member',1)}}</h3>

            <div class="box-tools pull-right">

            </div>
        </div>
        {!! Form::open(array('url' => url('member/'.$member->id.'/update'), 'method' => 'post', 'id' => 'add_member_form',"enctype"=>"multipart/form-data")) !!}
        <div class="box-body">
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('first_name',trans_choice('general.first_name',1),array('class'=>'')) !!}
                {!! Form::text('first_name',$member->first_name, array('class' => 'form-control', 'placeholder'=>trans_choice('general.first_name',1),'required'=>'required')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('middle_name',trans_choice('general.middle_name',1),array('class'=>'')) !!}
                {!! Form::text('middle_name',$member->middle_name, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('last_name',trans_choice('general.last_name',1),array('class'=>'')) !!}
                {!! Form::text('last_name',$member->last_name, array('class' => 'form-control', 'placeholder'=>trans_choice('general.last_name',1),'required'=>'required')) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                {!! Form::label('dob',trans_choice('general.dob',1),array('class'=>'')) !!}
                {!! Form::text('dob',$member->dob, array('class' => 'form-control date-picker', 'placeholder'=>"yyyy-mm-dd")) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('gender',trans_choice('general.gender',1),array('class'=>'')) !!}
                {!! Form::select('gender', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.gender.options')),
                    $member->gender, array('class' => 'form-control',''=>'')) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('marital_status',trans_choice('general.marital_status',1),array('class'=>'')) !!}
                {!! Form::select('marital_status', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.marital_status.options')),
                    $member->marital_status, array('class' => 'form-control',''=>'')) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('status',trans_choice('general.member_status',1),array('class'=>'')) !!}
                {!! Form::select('status', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.status.options')),
                    $member->status, array('class' => 'form-control',''=>'')) !!}
            </div>
           
        </div>
       
        <div class="form-row">
            <div class="form-group col-md-3">
                {!! Form::label('nationality',trans_choice('general.nationality',1),array('class'=>'')) !!}
                {!! Form::select('nationality', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.nationality.options')),
                    $member->nationality, array('class' => 'form-control',''=>'')) !!}
            </div>   
            <div class="form-group col-md-3">
                {!! Form::label('preferred_language',trans_choice('general.preferred_language',1),array('class'=>'')) !!}
                {!! Form::select('preferred_language', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.preferred_language.options')),
                    $member->preferred_language, array('class' => 'form-control',''=>'')) !!}
            </div> 
            <div class="form-group col-md-6">
                {!! Form::label('place_of_birth',trans_choice('general.place_of_birth',1),array('class'=>'')) !!}
                {!! Form::text('place_of_birth',$member->place_of_birth, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('mobile_phone',trans_choice('general.mobile_phone',1),array('class'=>'')) !!}
                {!! Form::text('mobile_phone',$member->mobile_phone, array('class' => 'form-control', 'placeholder'=>trans_choice('general.numbers_only',1))) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('email',trans_choice('general.email',1),array('class'=>'')) !!}
                {!! Form::text('email',$member->email, array('class' => 'form-control', 'placeholder'=>trans_choice('general.email',1))) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('preferred_contact',trans_choice('general.preferred_contact',1),array('class'=>'')) !!}
                {!! Form::select('preferred_contact', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.preferred_contact.options')),
                    $member->preferred_contact, array('class' => 'form-control',''=>'')) !!}
            </div>
        </div>
           
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('department',trans_choice('general.department',1),array('class'=>'')) !!}
                {!! Form::select('department', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.department.options')),
                    $member->department, array('class' => 'form-control',''=>'')) !!}
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('education',trans_choice('general.education',1),array('class'=>'')) !!}
                {!! Form::select('education', App\Helpers\GeneralHelper::memberKeysToKeyValue(config('member.education.options')),
                    $member->education, array('class' => 'form-control',''=>'')) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('trade',trans_choice('general.trade',1),array('class'=>'')) !!}
                {!! Form::text('trade',$member->trade, array('class' => 'form-control', 'placeholder'=>'')) !!}
            </div>
        </div>
           
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('address',trans_choice('general.address',1),array('class'=>'')) !!}
                {!! Form::textarea('address',$member->address, array('class' => 'form-control', 'rows'=>"3")) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('notes',trans_choice('general.description',1),array('class'=>'')) !!}
                {!! Form::textarea('notes',$member->notes, array('class' => 'form-control', 'placeholder'=>"")) !!}
            </div>
           
        </div>
            <div class="form-group col-md-6">
                {!! Form::label('photo',trans_choice('general.photo',1),array('class'=>'')) !!}
                {!! Form::file('photo', array('class' => 'form-control', 'placeholder'=>"")) !!}
            </div>
            <div class="form-group col-md-6">

                {!! Form::label('files',trans_choice('general.member',1).' '.trans_choice('general.file',2).'('.trans_choice('general.borrower_file_types',2).')',array('class'=>'')) !!}

                {!! Form::file('files[]', array('class' => 'form-control', 'multiple'=>"multiple")) !!}
                {{trans_choice('general.select_thirty_files',2)}}<br>
                @if(isset($member->files))
                    @foreach(unserialize($member->files) as $key=>$value)
                        <span id="file_{{$key}}_span"><a href="{!!asset('uploads/'.$value)!!}"
                                                        target="_blank">{!!  $value!!}</a> <button value="{{$key}}"
                                                                                                    id="{{$key}}"
                                                                                                    onclick="delete_file(this)"
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i></button> </span><br>
                    @endforeach
                @endif
            </div>
          
            <div class="form-group"> 
                {!! Form::label('tags',trans_choice('general.assign',2). ' '.trans_choice('general.tag',2),array('class'=>'')) !!}
                <div id="jstree_div">
                    <ul>
                        <li data-jstree='{ "opened" : true }'
                            id="1">{{trans_choice('general.all',2)}} {{trans_choice('general.tag',2)}}
                            ({{ \App\Models\MemberTag::count()}} {{trans_choice('general.people',2)}})
                            {!! \App\Helpers\GeneralHelper::createTreeView(1,$menus,$selected_tags) !!}
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="tags" id="tags" value=""/>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"
                    id="add_member">{{trans_choice('general.save',1)}}</button>
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
        function delete_file(e) {
            var id = e.id;
            swal({
                title: 'Are you sure?',
                text: '',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel'
            }).then(function () {
                $.ajax({
                    type: 'GET',
                    url: "{!!  url('member/'.$member->id) !!}/delete_file?id=" + id,
                    success: function (data) {
                        $("#file_" + id + "_span").remove();
                        swal({
                            title: 'Deleted',
                            text: 'File successfully deleted',
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            timer: 2000
                        })
                    }
                });
            })

        }
    </script>
@endsection

