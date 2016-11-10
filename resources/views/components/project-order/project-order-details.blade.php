@extends('partials.main')

@section('content') 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@index') }}">
                <i class="fa fa-mail-reply  "></i> Back to Project Order Lists
            </a>
        </div>
    </div>
    <br />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
    @endif
    <div class="row">
        <div class="col-xs-2 col-md-2">
            <small class="stats-label">PO Number</small>
            <h4>{{$projectOrder->po_number}}</h4>
        </div>
        <div class="col-xs-2 col-md-2">
            <small class="stats-label">Start Date</small>
            <h4>{{$projectOrder->start_date}}</h4>
        </div>
        <div class="col-xs-2 col-md-2">
            <small class="stats-label">End Date</small>
            <h4>{{$projectOrder->end_date}}</h4>
        </div>
        <div class="col-xs-2 col-md-2">
            <small class="stats-label">Status</small>
            <h4><label class="label label-info">@if($projectOrder->is_done == 0) IN PROGRESS @else @done @endif</label></h4>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge text-primary">{{ number_format($projectOrder->amount,2) }}</div>
                            <div>Amount (Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge text-danger">{{ number_format($projectTotalExpenses,2) }}</div>
                            <div>Expenses (Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bar-chart-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge text-success">{{ number_format($projectRemainingBalance,2) }}</div>
                            <div>Remaining Balance (Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        
        <div class="col-lg-8 col-md-8">
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	        <i class="fa fa-building fa-fw"></i> Manpower
        	    </div>
        	    <!-- /.panel-heading -->
        	    <div class="panel-body">
        	        <!-- /.list-group -->
        	        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#manpowerModal">Add Manpower</a>
        	        <br/>
        	        <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th style="width: 350px;">Name</th>
                                <th style="width: 350px;">Position</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($projectOrderManpower as $k=>$v)
                                    <tr>
                                        <td>{{$v->manpower->employee_id}}</td>
                                        <td style="width: 450px;">{{$v->manpower->first_name}} {{$v->manpower->last_name}}</td>
                                        <td>{{$v->manpower->position}}</td>
                                        <td>
                                            <a type="button" class="btn btn-danger btn-xs" 
                                            href="{{ action('ProjectOrderController@deleteManpowerFromProject', $v->id) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
        	    </div>
        	    <!-- /.panel-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-building fa-fw"></i> Project Daily
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- /.list-group -->
                    <!-- Button trigger modal -->
                    <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Generate Project Daily</a>
                    <br/>
                    <div class="list-group">
                        @foreach ($projectDaily as $k=>$v)
                            <a href="{{ action('ProjectOrderController@showProjectDaily', $v->id) }}" class="list-group-item">
                                <i class="fa fa-calendar fa-fw"></i> {{$v->date}}
                                <span class="pull-right text-muted small badge"><em>{{number_format($v->totalCost, 2)}}</em>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
@stop

@section('modals')
    <!-- Project Daily Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            	{!! Form::open(array('action' => 'ProjectOrderController@generateDaily')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Generate Project Daily</h4>
                </div>
                <div class="modal-body">
                	
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <input type='hidden' id="po_id" name="po_id" placeholder="Enter Date" value="{{$projectOrder->id}}"/>
                                <div id="datepicker">
                                	<input type='hidden' id="date" name="date" placeholder="Enter Date" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->


    <!-- Manpower Modal -->
    <div class="modal fade" id="manpowerModal" tabindex="-2" role="dialog" aria-labelledby="manpowerModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 860px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Project Manpower Lists</h4>
                </div>
                <div class="modal-body">
                    <table width="100%" class="table table-striped table-bordered table-hover table-dataTable" id="manpower-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th class="no-sort">Address</th>
                                <th>Rate</th>
                                <th class="no-sort text-right" width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manpower as $k=>$v)
                                <tr class="odd">
                                    <td>{{$v->employee_id}}</td>
                                    <td>{{$v->first_name}} {{$v->last_name}}</td>
                                    <td>{{$v->position}}</td>
                                    <td>{{$v->address}}</td>
                                    <td>{{$v->rate}}</td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-primary btn-xs" 
                                        href="{{ action('ProjectOrderController@assignManpowerToProject', array( 'po_id' => $projectOrder->id, 'manpower_id' => $v->id)) }}">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                    </td>
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
@stop

@section('scripts')
	<script type="text/javascript">
        $(function () {
            $('#datepicker').datetimepicker({
            	format : "YYYY-MM-DD",
                inline: true,
                sideBySide: true,
                minDate : "{{$projectOrder->start_date}}"
            });
        });
    </script>
@stop