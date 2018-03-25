<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <i class="fa fa-user" style="font-size: 60px"></i>
            </div>
            <div class="pull-left info">
                <p>{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="@if(Request::is('dashboard')) active @endif">
                <a href="{{ url('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>{{trans_choice('general.dashboard',1)}}</span>
                </a>
            </li>
            @if(Sentinel::hasAccess('members'))
                <li class="treeview @if(Request::is('member/*')) active @endif">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>{{trans_choice('general.member',2)}}</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(Sentinel::hasAccess('members.view'))
                            <li><a href="{{ url('member/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.view',1)}} {{trans_choice('general.member',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('members.create'))
                            <li><a href="{{ url('member/create') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.add',1)}} {{trans_choice('general.member',1)}}
                                </a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(Sentinel::hasAccess('tags.view'))
                <li class=" @if(Request::is('tag/*')) active @endif"><a href="{{ url('tag/data') }}"><i
                                class="fa fa-tags"></i><span>{{trans_choice('general.tag',2)}}</span>
                    </a></li>
            @endif
            @if(Sentinel::hasAccess('events'))
                <li class="treeview @if(Request::is('event/*')) active @endif">
                    <a href="#">
                        <i class="fa fa-calendar"></i> <span>{{trans_choice('general.event',2)}}</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(Sentinel::hasAccess('events.view'))
                            <li><a href="{{ url('event/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.view',1)}} {{trans_choice('general.event',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('events.create'))
                            <li><a href="{{ url('event/location/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.manage',1)}} {{trans_choice('general.location',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('events.create'))
                            <li><a href="{{ url('event/calendar/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.manage',1)}} {{trans_choice('general.calendar',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('events.create'))
                            <li><a href="{{ url('event/role/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.manage',1)}} {{trans_choice('general.volunteer',1)}} {{trans_choice('general.role',2)}}
                                </a></li>
                        @endif
                    </ul>
                </li>
            @endif
           

            @if(Sentinel::hasAccess('follow_ups'))
                <li class="treeview @if(Request::is('follow_up/*')) active @endif">
                    <a href="#">
                        <i class="fa fa-comments"></i> <span>{{trans_choice('general.follow_up',2)}}</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(Sentinel::hasAccess('follow_ups.view'))
                            <li><a href="{{ url('follow_up/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.view',1)}} {{trans_choice('general.follow_up',2)}}
                                </a></li>
                        @endif
                            @if(Sentinel::hasAccess('follow_ups.view'))
                                <li><a href="{{ url('follow_up/my_follow_ups') }}"><i
                                                class="fa fa-circle-o"></i> {{trans_choice('general.my',1)}} {{trans_choice('general.follow_up',2)}}
                                    </a></li>
                            @endif
                        @if(Sentinel::hasAccess('follow_ups.create'))
                            <li><a href="{{ url('follow_up/create') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.add',1)}} {{trans_choice('general.follow_up',1)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('follow_ups.create'))
                            <li><a href="{{ url('follow_up/category/data') }}"><i
                                            class="fa fa-circle-o"></i> {{trans_choice('general.manage',1)}} {{trans_choice('general.follow_up',1)}} {{trans_choice('general.category',2)}}
                                </a></li>
                        @endif
                    </ul>
                </li>
            @endif
    
            @if(Sentinel::hasAccess('communication'))
                <li class="treeview @if(Request::is('communication/*')) active @endif">
                    <a href="#">
                        <i class="fa fa-envelope"></i> <span>{{trans_choice('general.communication',2)}}</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('communication/email') }}"><i
                                        class="fa fa-circle-o"></i> {{trans_choice('general.email',1)}}
                            </a></li>
                        <li><a href="{{ url('communication/sms') }}"><i
                                        class="fa fa-circle-o"></i> {{trans_choice('general.sms',2)}}
                            </a></li>
                    </ul>
                </li>
            @endif
           
            @if(Sentinel::hasAccess('users'))
                <li class="treeview @if(Request::is('user/*')) active @endif">
                    <a href="{{ url('user/data') }}">
                        <i class="fa fa-users"></i> <span>{{trans_choice('general.user',2)}}</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(Sentinel::hasAccess('users.view'))
                            <li><a href="{{ url('user/data') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>{{trans_choice('general.view',2)}} {{trans_choice('general.user',2)}}</span>
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('users.roles'))
                            <li><a href="{{ url('user/role/data') }}"><i
                                            class="fa fa-circle-o"></i>{{trans_choice('general.manage',2)}} {{trans_choice('general.role',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('users.roles'))
                            <li><a href="{{ url('user/permission/data') }}"><i
                                            class="fa fa-circle-o"></i>{{trans_choice('general.manage',2)}} {{trans_choice('general.permission',2)}}
                                </a></li>
                        @endif
                        @if(Sentinel::hasAccess('users.create'))
                            <li><a href="{{ url('user/create') }}"><i
                                            class="fa fa-circle-o"></i>{{trans_choice('general.add',2)}} {{trans_choice('general.user',2)}}
                                </a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(Sentinel::hasAccess('audit_trail'))
                <li class="@if(Request::is('audit_trail/*')) active @endif">
                    <a href="{{ url('audit_trail/data') }}">
                        <i class="fa fa-area-chart"></i> <span>{{trans_choice('general.audit_trail',2)}}</span>
                    </a>
                </li>
            @endif
            @if(Sentinel::hasAccess('settings'))
                <li class="@if(Request::is('setting/*')) active @endif">
                    <a href="{{ url('setting/data') }}">
                        <i class="fa fa-cog"></i> <span>{{trans_choice('general.setting',2)}}</span>
                    </a>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
