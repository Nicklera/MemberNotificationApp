@extends('layouts.master')
@section('title')
    {{trans_choice('general.member',2)}}
@endsection
@section('page-header-scripts')
<style>
                /*****************CUSTOM SLIDER STYLE***********************************/
                .slider-selection {
                    background: #f77500 !important;
                }
                .slider-success .slider-selection {
                    background-color: #5cb85c !important;
                }
                .slider-primary .slider-selection {
                    background-color: #428bca !important;
                }

                .slider.slider-horizontal {
                    width: 100% !important;
                    height: 20px;
                }
                .slider-handle {
                    background-color: #fff !important;
                    background-image: none !important;
                    -webkit-box-shadow: 1px 1px 24px -2px rgba(0,0,0,0.75) !important;
                    -moz-box-shadow: 1px 1px 24px -2px rgba(0,0,0,0.75) !important;
                    box-shadow: 1px 1px 24px -2px rgba(0,0,0,0.75) !important;
                }

                .slider-strips .slider-selection {
                    background-image: repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,252,252,0.08) 5px, rgba(252,252,252,0.08) 10px) !important;
                    background-image: -ms-repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,252,252,0.08) 5px, rgba(252,252,252,0.08) 10px) !important;
                    background-image: -o-repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,252,252,0.08) 5px, rgba(252,252,252,0.08) 10px) !important;
                    background-image: -webkit-repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,252,252,0.08) 5px, rgba(252,252,252,0.08) 10px) !important; 
                }
                .tooltip {
                    z-index: 0;
                }
                .tooltip-inner {
                    max-width: 200px;
                    padding: 3px 8px;
                    color: #30404a;
                    font-size: 1.2em;
                    text-align: center;
                    background-color: transparent !important;
                    border-radius: 4px;
                }
                .tooltip.top .tooltip-arrow {
                    display: none !important;
                }
                .slider .tooltip.top {
                    margin-top: -25px ;
                }
                .well {
                    background: transparent !important;
                    border: none !important;
                    box-shadow: none !important;
                    width: 100% !important;
                    padding: 0;
                }

                .slider-primary.slider-ghost .slider-handle {
                    border-color: #428bca;
                }
            </style>
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans_choice('general.member',2)}}</h3>

            <div class="box-tools pull-right">
                @if(Sentinel::hasAccess('members.create'))
                    <a href="{{ url('member/create') }}"
                       class="btn btn-success btn-sm">{{trans_choice('general.add',1)}} {{trans_choice('general.member',1)}}</a>
                @endif
                <a href="#"
                   class="btn btn-info btn-sm" data-toggle="modal" data-target="#smsMember"><i
                            class="fa fa-mobile"></i> {{trans_choice('general.sms',1)}} {{trans_choice('general.member',2)}}
                </a>
                <a href="#"
                   class="btn btn-info btn-sm" data-toggle="modal" data-target="#emailMember"><i
                            class="fa fa-envelope"></i> {{trans_choice('general.email',1)}} {{trans_choice('general.member',2)}}
                </a>
            </div>

        </div>
        
        <div class="box-body ">
        <div class="panel-body">
            
            <div  id="search-form" class="form-inline" >
            <div class="row">        
            <div class="age-filter" style="margin-bottom: 25px; display:none;">
                <div class="slider-wrapper slider-primary slider-strips">
                    <label for="age" class="col-sm-6 control-label">Age Range filter</label>
                    <input  id="age" class="input-range" type="text" data-slider-step="1" data-slider-value="[18, 45]" data-slider-min="0" data-slider-max="100" data-slider-range="true" data-slider-tooltip_split="true" />
                </div>
            </div>
            </div>
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Trade</th>
                            <th>Merital Status</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!-- /.box -->
     <!-- /.box-body -->
        <div class="modal fade" id="emailMember">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">*</span></button>
                        <h4 class="modal-title">{{trans_choice('general.email',1)}} {{trans_choice('general.member',2)}}</h4>
                    </div>
                    {!! Form::open(array('url' => url('tag/email_members'),'method'=>'post','id'=>'')) !!}
                    <div class="modal-body">
                        <input type="hidden" value="{{ isset($tag->id) ? $tag->id : null}}" name="tag_id">
                        <input class='members_ids' type='hidden' value="" name="members_ids">
                        <p>In your email you can use any of the following tags:
                            {firstName}, {lastName}, {address}, {mobilePhone},
                            {homePhone}</p>
                        <div class="form-group">
                            {!! Form::label('subject',trans_choice('general.subject',1),array('class'=>'')) !!}
                            {!! Form::text('subject',null, array('class' => 'form-control', 'required'=>"")) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('message',trans_choice('general.message',1),array('class'=>'')) !!}

                            {!! Form::textarea('message',null, array('class' => 'form-control tinymce', ''=>"",'rows'=>'3')) !!}

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">{{trans_choice('general.save',2)}}</button>
                        <button type="button" class="btn default"
                                data-dismiss="modal">{{trans_choice('general.close',2)}}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="modal fade" id="smsMember">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">*</span></button>
                        <h4 class="modal-title">{{trans_choice('general.sms',2)}} {{trans_choice('general.member',2)}}</h4>
                    </div>
                    {!! Form::open(array('url' => url('tag/sms_members'),'method'=>'post','id'=>'')) !!}
                    <div class="modal-body">
                        <input type="hidden" value="{{ isset($tag->id) ? $tag->id : null}}" name="tag_id">
                        <input class='members_ids' type='hidden' value="" name="members_ids">
                        <p>In your sms you can use any of the following tags:
                            {firstName}, {lastName}, {address}, {mobilePhone},
                            {homePhone}</p>
                        <p><b>N.B. SMS cannot exceed 420 characters. 1 sms is 160 characters. Please keep your message in
                                that length</b></p>

                        <div class="form-group">
                            {!! Form::label('message',trans_choice('general.message',1),array('class'=>'')) !!}

                            {!! Form::textarea('message',null, array('class' => 'form-control', 'required'=>"required",'rows'=>'3')) !!}

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">{{trans_choice('general.save',2)}}</button>
                        <button type="button" class="btn default"
                                data-dismiss="modal">{{trans_choice('general.close',2)}}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>
@endsection
@section('footer-scripts')
    <script>
   
        (function($){
            'use strict';
            
            var SlavicCC = window.SlavicCC || {};
        
            var members_ids = [];
        
            SlavicCC.set = function(members_ids){  
                if(!members_ids) return;

                this.members_ids = members_ids;
            };
        
            SlavicCC.get = function(){ 
                if(!this.members_ids) return [];
                
                return this.members_ids;
                          
            };

            SlavicCC.push = function(id){
                if(!id) return;

                this.members_ids.push(id);

                return SlavicCC.get();
            }

            window.SlavicCC = SlavicCC;
        })(jQuery);


        $(document).ready(function(){
            $("#age").bootstrapSlider({
                tooltip: 'always'
            })
            .on('slideStop', function(e){
                setTimeout(function(){
                    table.draw();
                    e.preventDefault();
                },400);
                    
            });

            var table = $('#data-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "displayLength": 25,
                "searching": true,
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "ajax": {
                    "url": '{!! route('member.data') !!}',
                    "data": function (d) {
                        d.age_range = $('input[id="age"]').bootstrapSlider('getValue');
                    }
                },
                "drawCallback": function( settings ) {
                    $('.age-filter').show();
                    SlavicCC.set(settings.json.filtered_ids);
                    $(".members_ids").val(SlavicCC.get());
                },       
                "info": true,
                "autoWidth": true,           
                "columns": [
                    { data: 'id', name: 'id'},
                    { data: 'first_name', name: 'first_name'},
                    { data: 'last_name', name: 'last_name'},
                    { data: 'trade', name: 'trade'},
                    { data: 'marital_status', name: 'marital_status'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'action'}         
                ],                 
                responsive: false
                });
            $('#search-form').on('keyup', function(e) {
                table.draw();
                e.preventDefault();
            });           
        });    
    </script>
@endsection
