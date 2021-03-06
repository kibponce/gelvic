@extends('partials.main')

@section('content')
    <div class="row">
        <div class="row content-header">
            <div class="col-lg-4 col-md-4">
                <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@show', $projectDaily->po_id) }}">
                    <i class="fa fa-mail-reply  "></i>
                </a>
            </div>
            <div class="col-lg-8 col-md-8">
                <a type="button" class="btn btn-info btn-sm pull-right" target="_blank" href="{{ action('ProjectOrderController@printDaily', ['daily_id' => $projectDaily->id, 'isBilling' => true ]) }}">
                    <i class="fa fa-print"></i> Billing
                </a>
                <a type="button" class="btn btn-info btn-sm pull-right" target="_blank" href="{{ action('ProjectOrderController@printDaily', ['daily_id' => $projectDaily->id, 'isBilling' => false ]) }}">
                    <i class="fa fa-print"></i> Costing
                </a>
                <a type="button" class="btn btn-info btn-sm pull-right" target="_blank" href="{{ action('ProjectOrderController@printDailyEquipment', ['daily_id' => $projectDaily->id, 'isBilling' => false ]) }}">
                    <i class="fa fa-print"></i> Equipment
                </a>
            </div>
        </div>
    </div>
    <br />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
    @endif

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-7 col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>PO #</strong> : {{$projectOrder->po_number}} 
                    <div class="pull-right">
                        <a href="#" class="btn btn-success btn-xs edit-daily" data-toggle="modal" data-target="#activityModal" data-id="{{$projectDaily->id}}">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <a href="#" class="btn btn-danger btn-xs delete-daily" data-toggle="modal" data-target="#deleteDailyModal" data-id="{{$projectDaily->id}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <strong class="stats-label">Date</strong> 
                            <h4>{{$projectDaily->date}}</h4>
                        </div>
						<div class="col-xs-6 col-md-6">
                            <strong class="stats-label">Type</strong> 
                            <h4><strong>{{$projectOrder->type}}</strong></h4>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            @if($projectDaily->isHoliday)
                                <span class="label label-info">Holiday</span>
                            @endif
                            @if($projectDaily->isRegular)
                                <span class="label label-primary">Regular</span>
                            @endif
                            @if($projectDaily->isSunday)
                                <span class="label label-warning">Sunday</span>
                            @endif
							@if($projectDaily->isSpecial)
                                <span class="label label-success">Special</span>
                            @endif
                            <!-- <span class="label label-success">Certified</span> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <strong class="stats-label">Activity</strong>
                            <p>{{$projectDaily->activity}}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ number_format($total->total, 2)}}</div>
                            <div>Cost(Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users fa-fw"></i> Manpower

                    <div class="pull-right">
                        <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#manpowerModal">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Rate</th>
                                <th># of Hours</th>
                                <th>Reg. Day</th>
                                <th># of Hours</th>
                                <th>Reg. OT</th>
                                <th># of Hours</th>
                                <th>Reg. NP</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- TYPE A -->
                            @if(count($typeA) != 0)
                                <tr>
                                    <th colspan="13">Type A</th>
                                </tr>
                            @endif
                            @foreach ($typeA as $k=>$v)
                                <tr>
                                    <td>{{$k + 1}}</td>
										<td width="140">{{$v->manpower->last_name}}, {{$v->manpower->first_name}} 	
										@if($v->is_special)
											<span class="label label-success">Special</span>
										@endif 
									</td>
                                    <td width="80">{{$v->time_in}}</td>
                                    <td width="80">{{$v->time_out}}</td>
                                    <td class="text-right">{{number_format($v->rate,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
                                    <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
                                    <td width="80" class="text-center">
                                        <a type="button" class="btn btn-primary btn-xs dailyLog" data-id="{{$v->id}}" data-toggle="modal" data-target="#dailyLog" href="">
                                            <i class="fa fa-clock-o"></i>
                                        </a>

                                        <a type="button" class="btn btn-danger btn-xs" data-id="{{$v->id}}""  href="{{ action('ProjectOrderController@deleteDailyManpower', array('id' => $v->id, 'po_daily_id' => $projectDaily->id))}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($typeA) != 0)
                                <tr style="background-color: #bbd8f1;">
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right">{{ number_format( $totalA->total_no_of_hours, 2) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total_reg_day,2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total_ot_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total_ot, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total_np_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total_np, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalA->total, 2 ) }}</td>
                                    <td></td>
                                </tr>
                            @endif

                                
                            <!-- TYPE B -->
                            @if(count($typeB) != 0)
                                <tr>
                                    <th colspan="13">Type B</th>
                                </tr>
                            @endif
                            @foreach ($typeB as $k=>$v)
                                <tr>
                                    <td>{{$k + 1}}</td>
                                    <td width="140">{{$v->manpower->last_name}}, {{$v->manpower->first_name}} 
										@if($v->is_special)
											<span class="label label-success">Special</span>
										@endif 
									</td>
                                    <td width="80">{{$v->time_in}}</td>
                                    <td width="80">{{$v->time_out}}</td>
                                    <td class="text-right">{{number_format($v->rate,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
                                    <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
                                    <td width="80" class="text-center">
                                        <a type="button" class="btn btn-primary btn-xs dailyLog" data-id="{{$v->id}}"" data-toggle="modal" data-target="#dailyLog" href="">
                                            <i class="fa fa-clock-o"></i>
                                        </a>

                                        <a type="button" class="btn btn-danger btn-xs" data-id="{{$v->id}}""  href="{{ action('ProjectOrderController@deleteDailyManpower', array('id' => $v->id, 'po_daily_id' => $projectDaily->id))}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($typeB) != 0)
                                <tr style="background-color: #bbd8f1;">
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right">{{ number_format( $totalB->total_no_of_hours, 2) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total_reg_day,2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total_ot_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total_ot, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total_np_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total_np, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalB->total, 2 ) }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            <!-- TYPE C -->
                            @if(count($typeC) != 0)
                                <tr>
                                    <th colspan="13">Type C</th>
                                </tr>
                            @endif
                            @foreach ($typeC as $k=>$v)
                                <tr>
                                    <td>{{$k + 1}}</td>
                                    <td width="140">{{$v->manpower->last_name}}, {{$v->manpower->first_name}} 
										@if($v->is_special)
											<span class="label label-success">Special</span>
										@endif 
									</td>
                                    <td width="80">{{$v->time_in}}</td>
                                    <td width="80">{{$v->time_out}}</td>
                                    <td class="text-right">{{number_format($v->rate,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
                                    <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
                                    <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
                                    <td width="80" class="text-center">
                                        <a type="button" class="btn btn-primary btn-xs dailyLog" data-id="{{$v->id}}"" data-toggle="modal" data-target="#dailyLog" href="">
                                            <i class="fa fa-clock-o"></i>
                                        </a>

                                        <a type="button" class="btn btn-danger btn-xs" data-id="{{$v->id}}""  href="{{ action('ProjectOrderController@deleteDailyManpower', array('id' => $v->id, 'po_daily_id' => $projectDaily->id))}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @if(count($typeC) != 0)
                                <tr style="background-color: #bbd8f1;">
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right">{{ number_format( $totalC->total_no_of_hours, 2) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total_reg_day,2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total_ot_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total_ot, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total_np_no_hours, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total_np, 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $totalC->total, 2 ) }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            @if(count($projectOrderDailyManpower) != 0)
                                <tr style="background-color: #95ec90;">
                                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_no_of_hours, 2) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_reg_day,2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_ot_no_hours, 2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_ot, 2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_np_no_hours, 2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total_np, 2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $total->total, 2 ) }}</strong></td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="13" class="text-center">No Manpower Available</td>
                                </tr>
                            @endif
                            <!--  -->


                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-wrench fa-fw"></i> Equipment

                    <div class="pull-right">
                        <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#equipmentModal" id="addEquipment">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Rate</th>
                                <th>Duration</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectDailyEquipment as $k=>$v)
                                <tr>
                                    <td>{{$v->equipment->equipment_id}}</td>
                                    <td>{{$v->equipment->name}}</td>
                                    <td class="text-right">{{$v->rate}}</td>
                                    <td class="text-right">{{$v->duration}}</td>
                                    <td class="text-right">{{number_format( $v->total, 2 ) }}</td>
                                    <td class="text-center"  width=80>
                                        <a type="button" class="btn btn-success btn-xs editEquipment" data-equipment="{{$v->equipment->id}}" data-duration="{{$v->duration}}" data-id="{{$v->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a type="button" class="btn btn-danger btn-xs" data-id="{{$v->id}}""  href="{{ action('ProjectOrderController@deleteEquipmentOnProjectDaily', $v->id) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #95ec90;">
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td class="text-right"><strong>{{ number_format( $grandTotalEquipment, 2) }}</strong></td>
                                <td>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@stop

@section('modals')
    <!-- Manpower Modal -->
    <div class="modal fade" id="manpowerModal" tabindex="-2" role="dialog" aria-labelledby="manpowerModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 860px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Manpower Lists from Project</h4>
                </div>
                <div class="modal-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="manpower-table">
                        <thead>
                            <tr>
                                <th class="no-sort"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th class="no-sort">Address</th>
                                <th>Rate</th>
                                <th class="no-sort text-right" width="30">Action</th>
                                <th class="hide"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manpower as $k=>$v)
                                <tr class="odd" data-id="{{$v->id}}">   
                                    <td></td>
                                    <td>{{$v->employee_id}}</td>
                                    <td>{{$v->first_name}} {{$v->last_name}}</td>
                                    <td>{{$v->position}}</td>
                                    <td>{{$v->address}}</td>
                                    <td>{{$v->rate}}</td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-primary btn-xs" 
                                        href="{{ action('ProjectOrderController@assignManpowerToProjectDaily', array( 'po_daily_id' => $projectDaily->id, 'manpower_id' => $v->id)) }}">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                    </td>
                                    <td class="hide">{{$v->id}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->

    <!-- Manpower Modal -->
    <div class="modal fade" id="dailyLog" tabindex="-2" role="dialog" aria-labelledby="manpowerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('action' => 'ProjectOrderController@postManpowerDailyLog')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Daily Log</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="paid_break" id="paid_break" checked>Paid Break
                                </label>
                            </div>
							<div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="special" id="special">Special
                                </label>
                            </div>
							<div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="overtime" id="overtime">Overtime
                                </label>
                            </div>
                        </div>
                    </div>                     
                    <div class="row">
                        <div class="col-lg-12">
                            <input type='hidden' class="form-control" name="id" id="id" value=""/>
                            <div class="form-group">
                                <label>In</label>
                                <div id="time_in">
                                    <input type='hidden' id="date" name="in" placeholder="Enter Date" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Out</label>
                                <div id="time_out">
                                    <input type='hidden' id="date" name="out" placeholder="Enter Date" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->

    <!-- Activity Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('action' => 'ProjectOrderController@updateActivity')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Project Daily</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="holiday" id="holiday">Holiday
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="regular" id="regular">Regular
                                    </label>
                                </div>
								<div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="special" id="special">Special
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Activity</label>
                                <input type='hidden' class="form-control" name="daily_id" id="daily_id" value=""/>
                                <textarea style="height: 300px;" class="form-control" name="activity" placeholder="Enter Activity" value="">{{$projectDaily->activity}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <!-- Delete Activity Modal -->
    <div class="modal fade" id="deleteDailyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('action' => 'ProjectOrderController@deleteActivity')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Project Daily</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <input type='hidden' class="form-control" name="delete_daily_id" id="delete_daily_id" value=""/>
                                <p>Are you sure you want to delete this project daily?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <!-- Equipment Modal -->
    <div class="modal fade" id="equipmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('action' => 'ProjectOrderController@addEquipmentOnProjectDaily')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Equipment Form</h4>
                </div>
                <div class="modal-body"> 
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group @if ($errors->has('equipment')) has-error  @endif">
                                    <label>Equipment</label>
                                    <input class="form-control" 
                                            name="equipment_id"
                                            id="equipment_id"
                                            type="hidden"
                                            value="">
                                    <input class="form-control" 
                                            placeholder="Enter Description" 
                                            name="po_daily_id"
                                            type="hidden"
                                            value="{{$projectDaily->id}}">
                                    <select class="form-control" name="equipment" id="equipment">
                                        <option value="">All Equipments</option>
                                        @foreach($equipments as $k=>$v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('equipment'))
                                        <p class="help-block">{{ $errors->first('equipment') }} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group @if ($errors->has('duration')) has-error  @endif">
                                    <label>Duration</label>
                                    <input type="text" class="form-control" placeholder="Enter Duration" name="duration" id="duration" value="@if(old('duration')){{old('duration')}}@endif">
                                    @if ($errors->has('duration'))
                                        <p class="help-block">{{ $errors->first('duration') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            var isHoliday = "{{$projectDaily->isHoliday}}";
            var isRegular = "{{$projectDaily->isRegular}}";
            var isSpecial = "{{$projectDaily->isSpecial}}";

            var error = "{{$error}}";

            $('#time_in').datetimepicker({
                format : "YYYY-MM-DD hh:mm A",
                inline: true,
                sideBySide: true,
                minDate : moment("{{$projectDaily->date}}"),
                defaultDate : moment("{{$projectDaily->date}}").add(8, 'hour')
            });

            $('#time_out').datetimepicker({
                format : "YYYY-MM-DD hh:mm A",
                inline: true,
                sideBySide: true,
                minDate : moment("{{$projectDaily->date}}"),
                defaultDate : moment("{{$projectDaily->date}}").add(16, 'hour')
            });

            $('.dailyLog').click(function (el){
                $("#id").val($(this).attr("data-id"));
            });

            $('.edit-daily').click(function (el){
                $("#daily_id").val($(this).attr("data-id"));
            });

            $('.delete-daily').click(function (el){
                $("#delete_daily_id").val($(this).attr("data-id"));
            });

            if(isHoliday == 1) {
                $("#holiday").attr("checked", true);
            }else{
                $("#holiday").attr("checked", false);
            }

            if(isRegular == 1) {
                $("#regular").attr("checked", true);
            }else{
                $("#regular").attr("checked", false);
            }
			
			if(isSpecial == 1) {
                $("#special").attr("checked", true);
            }else{
                $("#special").attr("checked", false);
            }

            var manpowerTable = $('#manpower-table').DataTable({
                "responsive": true,
                "select": {
                    "style":    'multi',
                    "selector": 'td:first-child'
                },
                "columnDefs": [ {
                      "targets": 'no-sort',
                      "orderable": false,
                },{
                    "orderable": false,
                    "className": 'select-checkbox',
                    "targets":   0
                }  ],

                "dom" : "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "buttons": [
                        {
                            "extend": 'selected',
                            "text": 'Add All',
                            "className": 'btn btn-primary',
                            "action": function ( e, dt, button, config ) {
                                var selectedRows = dt.rows( { selected: true } ).data(),
                                    selectedIds = [];

                                $.each(selectedRows, function (item) {
                                    selectedIds.push(selectedRows[item][7]);
                                });

                                window.location.href = "{{ action('ProjectOrderController@assignMultipleManpowerToProjectDaily', $projectDaily->id) }}/" + selectedIds.join(","); 
                            }
                        }
                    ] 
            });

            if(error === "EQUIPMENT") {
                $('#equipmentModal').modal('show');
            }

            $("#addEquipment").click(function (e) {
                $("#equipment_id").val("");
                $("#equipment").val("").trigger("change");
                $("#duration").val("");
            });

            $(".editEquipment").click(function (e) {
                var id = $(this).attr("data-id"),
                    equipment = $(this).attr("data-equipment"),
                    duration = $(this).attr("data-duration");

                $("#equipment_id").val(id);
                $("#equipment").val(equipment).trigger("change");
                $("#duration").val(duration);

                $('#equipmentModal').modal('show');
            });
        });
    </script>
@stop