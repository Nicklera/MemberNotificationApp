@extends('layouts.master')
@section('title')
    {{trans_choice('general.follow_up',2)}}
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans_choice('general.follow_up',2)}} </h3>

            <div class="box-tools pull-right">
                @if(Sentinel::hasAccess('follow_ups.create'))
                    <a href="{{ url('follow_up/create') }}"
                       class="btn btn-info btn-sm">{{trans_choice('general.add',1)}} {{trans_choice('general.follow_up',1)}} </a>
                @endif
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>{{trans_choice('general.id',1)}}</th>
                        <th>{{trans_choice('general.assigned_to',1)}}</th>
                        <th>{{trans_choice('general.member',1)}}</th>
                        <th>{{trans_choice('general.category',1)}}</th>
                        <th>{{trans_choice('general.status',1)}}</th>
                        <th>{{trans_choice('general.note',2)}}</th>
                        <th>{{trans_choice('general.created_at',2)}}</th>
                        <th>{{ trans_choice('general.action',1) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key)
                        <tr>
                            <td>{{ $key->id }}</td>
                            <td>
                                @if(!empty($key->assigned_to))
                                    <a href="{{url('user/'.$key->assigned_to->id.'/show')}}">{{$key->assigned_to->first_name}} {{$key->assigned_to->last_name}}</a>

                                @endif
                            </td>
                            <td>
                                @if(!empty($key->member))
                                    <a href="{{url('member/'.$key->member->id.'/show')}}">{{$key->member->first_name}} {{$key->member->middle_name}} {{$key->member->last_name}}</a>
                                @endif
                            </td>
                            <td>
                                @if(!empty($key->category))
                                   {{$key->category->name}}

                                @endif
                            </td>

                            <td>
                                @if($key->status==1)
                                    <span class="label label-success">{{ trans_choice('general.complete',1) }}</span>
                                @else
                                    <span class="label label-warning">{{ trans_choice('general.incomplete',1) }}</span>
                                @endif
                            </td>
                            <td>{{ $key->notes }}</td>
                            <td>{{ $key->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-flat dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                        {{ trans('general.choose') }} <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        @if(Sentinel::hasAccess('follow_ups.update'))
                                            @if($key->status==1)
                                                <li>
                                                    <a href="{{ url('follow_up/'.$key->id.'/incomplete') }}"><i
                                                                class="fa fa-minus-circle"></i>
                                                        {{ trans('general.mark_as') }} {{ trans_choice('general.incomplete',1) }}
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ url('follow_up/'.$key->id.'/complete') }}"><i
                                                                class="fa fa-check"></i>
                                                        {{ trans('general.mark_as') }} {{ trans_choice('general.complete',1) }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if(Sentinel::hasAccess('follow_ups.view'))
                                            <li><a href="{{ url('follow_up/'.$key->id.'/show') }}"><i
                                                            class="fa fa-search"></i>  {{ trans_choice('general.detail',2) }}
                                                </a>
                                            </li>
                                        @endif
                                        @if(Sentinel::hasAccess('follow_ups.update'))
                                            <li><a href="{{ url('follow_up/'.$key->id.'/edit') }}"><i
                                                            class="fa fa-edit"></i> {{ trans('general.edit') }} </a>
                                            </li>
                                        @endif
                                        @if(Sentinel::hasAccess('follow_ups.delete'))
                                            <li><a href="{{ url('follow_up/'.$key->id.'/delete') }}"
                                                   class="delete"><i
                                                            class="fa fa-trash"></i> {{ trans('general.delete') }} </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
@section('footer-scripts')
    <script>
        $('#data-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {extend: 'copy', 'text': '{{ trans('general.copy') }}'},
                {extend: 'excel', 'text': '{{ trans('general.excel') }}'},
                {extend: 'csv', 'text': '{{ trans('general.csv') }}'},
                {extend: 'colvis', 'text': '{{ trans('general.colvis') }}'}
            ],
            "paging": true,
            "lengthChange": true,
            "displayLength": 15,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[6, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": [7]}
            ],
            "language": {
                "lengthMenu": "{{ trans('general.lengthMenu') }}",
                "zeroRecords": "{{ trans('general.zeroRecords') }}",
                "info": "{{ trans('general.info') }}",
                "infoEmpty": "{{ trans('general.infoEmpty') }}",
                "search": "{{ trans('general.search') }}",
                "infoFiltered": "{{ trans('general.infoFiltered') }}",
                "paginate": {
                    "first": "{{ trans('general.first') }}",
                    "last": "{{ trans('general.last') }}",
                    "next": "{{ trans('general.next') }}",
                    "previous": "{{ trans('general.previous') }}"
                }
            },
            responsive: false
        });
    </script>
@endsection
