@extends('layouts.master')
@section('title')
    {{ trans('general.dashboard') }}
@endsection

@section('content')
    <div class="row">
        @if(Sentinel::hasAccess('dashboard.members_statistics'))
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                <span class="info-box-text">{{ trans_choice('general.registered',1) }}
                    <br>{{ trans_choice('general.member',2) }}</span>
                        <span class="info-box-number">{{ \App\Models\Member::count() }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(Sentinel::hasAccess('dashboard.tags_statistics'))
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-tags"></i></span>

                    <div class="info-box-content">
                <span class="info-box-text">{{ trans_choice('general.total',1) }}
                    <br>{{ trans_choice('general.tag',2) }}</span>
                        <span class="info-box-number">{{ \App\Models\Tag::count() }}</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="clearfix visible-sm-block"></div>
    </div>

    @if(Sentinel::hasAccess('dashboard.calendar'))
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><span style="">{{trans_choice('general.event',2)}} {{trans_choice('general.calendar',1)}}</span></b>
                        </h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="calendar" class="chart" style="">
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->
            </div>
        </div>
    @endif
@endsection
@section('footer-scripts')
    <script>
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: '{{trans_choice('general.today',1)}}',
                month: '{{trans_choice('general.month',1)}}',
                week: '{{trans_choice('general.week',1)}}',
                day: '{{trans_choice('general.day',1)}}'
            },
            //Random default events
            events: {!! $events !!},
            selectable: false,

        });
    </script>

@endsection
