 <div class="panel panel-default">
    <div class="panel-heading">  <h4>User Profile</h4></div>
    <div class="panel-body">
    <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
        @if(!empty($member->photo))
            <a href="{{asset('uploads/'.$member->photo)}}"> 
                <img  class="img-circle img-responsive" src="{{asset('uploads/'.$member->photo)}}" alt="user image"/>
            </a>
        @else
            <img class="img-circle img-responsive"
                    src="{{asset('https://ssl.gstatic.com/accounts/ui/avatar_2x.png')}}"
                    alt="user image"/>
        @endif
    </div>
    <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" >
        <div class="container" >
            <h2><a href="{{url('member/'.$member->id.'/edit')}}">{{ $member->full_name }}</a></h2>
              <div class="col-sm-5 col-xs-6 tital " >Registered: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($member->created_at))->diffForHumans() }} </div>
        </div>
        <hr>
        <ul class="container details" >
            <li><p><span class="glyphicon glyphicon-user" style="width:50px;"></span> Age: {{date_diff(date_create($member->dob), date_create(date("Y-m-d")))->format('%y')}} {{trans_choice('general.year',2)}}</p></li>
            <li><p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span><a
                                    onclick="javascript:window.open('mailto:{{$member->email}}', 'mail');event.preventDefault()"
                                    href="mailto:{{$member->email}}">{{$member->email}}</a>

                                    <div class="btn-group-horizontal"><a type="button" class="btn-xs bg-red"
                                                                 href="{{url('communication/email/create?member_id='.$member->id)}}">{{trans_choice('general.send',1)}}
                                    {{trans_choice('general.email',1)}}</a></div>
                </p>
            </li>
            <li><p><span class="glyphicon glyphicon-phone one" style="width:50px;"></span>{{$member->mobile_phone}}
                                    <div class="btn-group-horizontal"><a type="button" class="btn-xs bg-red"
                                                                 href="{{url('communication/sms/create?member_id='.$member->id)}}">{{trans_choice('general.send',1)}}
                                    {{trans_choice('general.sms',1)}}</a></div>
                </p>
            </li>
        </ul>
        <hr>
        <div class="col-sm-6">
            <ul class="list-unstyled">
                <li><p><b>{{trans_choice('general.gender',1)}}:</b> {{ ucfirst($member->gender) }}</p></li>
                <li><p><b>{{trans_choice('general.status',1)}}:</b> {{ ucfirst($member->status) }}</p></li>
                <li><p><b>{{trans_choice('general.marital_status',1) }}:</b> {{ ucfirst($member->marital_status) }}</p></li>
                <li><p><b>{{trans_choice('general.trade',1)}}:</b> {{ ucfirst($member->trade) }}</p></li>               
                <li><p><b>{{trans_choice('general.education',1)}}:</b> {{ ucfirst($member->education) }}</p></li>
                <li><p><b>{{trans_choice('general.department',1)}}:</b> {{ ucfirst($member->department) }}</p></li>
                <li><small>{{$member->notes}}</small></p></li>
            </ul>                     
        </div>
        <div class="col-sm-6">
            <ul class="list-unstyled">                       
                <li><p><b>{{trans_choice('general.nationality',1)}}:</b> {{ ucfirst($member->nationality) }}</p></li>
                <li><p><b>{{trans_choice('general.preferred_contact',1)}}:</b> {{ ucfirst($member->preferred_contact) }}</p></li>
                <li><p><b>{{trans_choice('general.preferred_language',1)}}:</b> {{ ucfirst($member->preferred_language) }}</p></li>
                <li><p><b>{{trans_choice('general.place_of_birth',1)}}:</b> {{ ucfirst($member->place_of_birth) }}</p></li>
            </ul>
        </div>
        <hr>
</div>





