@extends('layouts.master')
@section('title')
    {{trans_choice('general.member',1)}} {{trans_choice('general.detail',2)}}
@endsection
@section('content')
    <div class="box box-widget">
        <div class="box-header with-border">

            @include('member.partials.details')

            <div class="row">

                <div class="col-sm-3">
                    <div class="pull-left">

                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tags" data-toggle="tab"
                                          aria-expanded="false"><i
                                    class="fa fa-tags"></i> {{trans_choice('general.tag',2)}}</a>
                    </li>
                    <li class=""><a href="#family" data-toggle="tab"
                                    aria-expanded="false"><i
                                    class="fa fa-group"></i> {{trans_choice('general.family',1)}}</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="tags">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>{{trans_choice('general.name',1)}}</th>
                                    <th>{{trans_choice('general.note',2)}}</th>
                                </tr>
                                </thead>
                                @if(isset($member->tags))
                                    @foreach($member->tags as $key)
                                        @if(!empty($key->tag))
                                            <tr>
                                                <td><a href="{{url('tag/'.$key->tag->id.'/show')}}">{{$key->tag->name}}</a>
                                                </td>
                                                <td>{!! $key->tag->notes!!}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane " id="family">
                        <div class="btn-group-horizontal">
                            @if(empty($member->family))
                                <a type="button" class="btn btn-success margin delete"
                                   href="{{url('member/'.$member->id.'/family/create')}}">{{trans_choice('general.create',1)}}
                                    {{trans_choice('general.family',1)}}</a>
                            @else
                                <a type="button" class="btn btn-info margin"
                                   href="#" data-toggle="modal"
                                   data-target="#addFamilyMember">{{trans_choice('general.add',1)}}
                                    {{trans_choice('general.family',1)}} {{trans_choice('general.member',1)}}</a>
                                <div class="modal fade" id="addFamilyMember">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">*</span></button>
                                                <h4 class="modal-title">{{trans_choice('general.add',1)}} {{trans_choice('general.member',1)}}</h4>
                                            </div>
                                            {!! Form::open(array('url' => url('member/'.$member->family->id.'/family/store_family_member'),'method'=>'post')) !!}
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        {!!  Form::label('member_id',trans_choice('general.member',1),array('class'=>' control-label')) !!}
                                                        {!! Form::select('member_id',$members,null,array('class'=>' select2','placeholder'=>'','required'=>'required')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        {!!  Form::label( 'family_role',trans_choice('general.role',1),array('class'=>' control-label')) !!}
                                                        {!! Form::select('family_role',['adult'=>trans_choice('general.adult',1),'spouse'=>trans_choice('general.spouse',1),'head'=>trans_choice('general.head',1),'child'=>trans_choice('general.child',1),'unassigned'=>trans_choice('general.unassigned',1)],null,array('class'=>'form-control','placeholder'=>'','required'=>'required')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                        class="btn btn-info">{{trans_choice('general.save',1)}}</button>
                                                <button type="button" class="btn default"
                                                        data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endif

                        </div>
                        @if(!empty($member->family))
                            <h3>{{trans_choice('general.the',1)}} {{$member->family->name}} {{trans_choice('general.family',1)}}</h3>
                            <div class="table-responsive">
                                <table class="table table-striped data-table">
                                    <thead>
                                    <tr>
                                        <th>{{trans_choice('general.name',1)}}</th>
                                        <th>{{trans_choice('general.role',1)}}</th>
                                        <th>{{trans_choice('general.action',1)}}</th>
                                    </tr>
                                    </thead>
                                    @foreach(\App\Models\FamilyMember::where('family_id',$member->family->id)->get() as $key)
                                        @if(!empty($key->member))
                                            <tr>
                                                <td>
                                                    <a href="{{url('member/'.$key->member->id.'/show')}}">{{$key->member->first_name}} {{$key->member->middle_name}} {{$key->member->last_name}}</a>
                                                </td>
                                                <td>
                                                    @if($key->family_role=="adult")
                                                        {{trans_choice('general.adult',1)}}
                                                    @endif
                                                    @if($key->family_role=="spouse")
                                                        {{trans_choice('general.spouse',1)}}
                                                    @endif
                                                    @if($key->family_role=="head")
                                                        {{trans_choice('general.head',1)}}
                                                    @endif
                                                    @if($key->family_role=="unassigned")
                                                        {{trans_choice('general.unassigned',1)}}
                                                    @endif
                                                    @if($key->family_role=="child")
                                                        {{trans_choice('general.child',1)}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-flat dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            {{ trans('general.choose') }} <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">

                                                            @if(Sentinel::hasAccess('members.update'))
                                                                <li>
                                                                    <a href="#"
                                                                       data-href="{{ url('member/'.$key->id.'/family/edit_family_member') }}"
                                                                       data-toggle="modal"
                                                                       data-target="#editFamilyMember"><i
                                                                                class="fa fa-edit"></i> {{ trans('general.edit') }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            @if(Sentinel::hasAccess('members.delete'))
                                                                @if($member->family->member_id!=$key->member_id)
                                                                    <li>
                                                                        <a href="{{ url('member/'.$key->id.'/family/delete_family_member') }}"
                                                                           class="delete"><i
                                                                                    class="fa fa-trash"></i> {{ trans('general.remove') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                                <div class="modal" id="editFamilyMember">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <script>
                                    $('#editFamilyMember').on('shown.bs.modal', function (e) {
                                        var url = $(e.relatedTarget).data('href');
                                        $.ajax({
                                            type: 'GET',
                                            url: url,
                                            success: function (data) {
                                                $(e.currentTarget).find(".modal-content").html(data);
                                            }
                                        });
                                    })
                                </script>
                            </div>
                        @endif
                        @foreach($member->families as $family)
                            @if(empty($member->family))
                                @if(!empty($family->family))
                                    <h3>{{trans_choice('general.the',1)}} {{$family->family->name}} {{trans_choice('general.family',1)}}</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped data-table">
                                            <thead>
                                            <tr>
                                                <th>{{trans_choice('general.name',1)}}</th>
                                                <th>{{trans_choice('general.role',1)}}</th>
                                                <th>{{trans_choice('general.action',1)}}</th>
                                            </tr>
                                            </thead>
                                            @foreach(\App\Models\FamilyMember::where('family_id',$family->family->id)->get() as $key)
                                                @if(!empty($key->member))
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('member/'.$key->member->id.'/show')}}">{{$key->member->first_name}} {{$key->member->middle_name}} {{$key->member->last_name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($key->family_role=="adult")
                                                                {{trans_choice('general.adult',1)}}
                                                            @endif
                                                            @if($key->family_role=="spouse")
                                                                {{trans_choice('general.spouse',1)}}
                                                            @endif
                                                            @if($key->family_role=="head")
                                                                {{trans_choice('general.head',1)}}
                                                            @endif
                                                            @if($key->family_role=="unassigned")
                                                                {{trans_choice('general.unassigned',1)}}
                                                            @endif
                                                            @if($key->family_role=="child")
                                                                {{trans_choice('general.child',1)}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                        class="btn btn-info btn-flat dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    {{ trans('general.choose') }} <span
                                                                            class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-right"
                                                                    role="menu">

                                                                    @if(Sentinel::hasAccess('members.update'))
                                                                        <li>
                                                                            <a href="#"
                                                                               data-href="{{ url('member/'.$key->id.'/family/edit_family_member') }}"
                                                                               data-toggle="modal"
                                                                               data-target="#editFamilyMember"><i
                                                                                        class="fa fa-edit"></i> {{ trans('general.edit') }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if(Sentinel::hasAccess('members.delete'))
                                                                        @if($family->family->member_id!=$key->member_id)
                                                                            <li>
                                                                                <a href="{{ url('member/'.$key->id.'/family/delete_family_member') }}"
                                                                                   class="delete"><i
                                                                                            class="fa fa-trash"></i> {{ trans('general.remove') }}
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                        <div class="modal" id="editFamilyMember">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <script>
                                            $('#editFamilyMember').on('shown.bs.modal', function (e) {
                                                var url = $(e.relatedTarget).data('href');
                                                $.ajax({
                                                    type: 'GET',
                                                    url: url,
                                                    success: function (data) {
                                                        $(e.currentTarget).find(".modal-content").html(data);
                                                    }
                                                });
                                            })
                                        </script>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script>
        $('.data-table').DataTable();               
    </script>
@endsection