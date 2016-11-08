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
                            <div class="huge">{{ number_format($projectOrder->amount,2) }}</div>
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
                            <div class="huge">0.00</div>
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
                            <div class="huge">0.00</div>
                            <div>Remaining Balance (Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-building fa-fw"></i> Project Details
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
                                <span class="pull-right text-muted small badge"><em>0.00</em>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	        <i class="fa fa-building fa-fw"></i> Manpower
        	    </div>
        	    <!-- /.panel-heading -->
        	    <div class="panel-body">
        	        <!-- /.list-group -->
        	        <a href="#" class="btn btn-primary btn-block">Add Manpower</a>
        	        <br/>
        	        <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3326</td>
                                <td>10/21/2013</td>
                                <td>3:29 PM</td>
                                <td>$321.33</td>
                            </tr>
                        </tbody>
                    </table>
        	    </div>
        	    <!-- /.panel-body -->
        </div>
    </div>
@stop

@section('modals')
	<!-- Modal -->
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