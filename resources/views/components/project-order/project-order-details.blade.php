@extends('partials.main')

@section('content')
    <div class="row full-bar">
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
            <h4><label class="label label-success">@if($projectOrder->is_done == 0) DONE @endif</label></h4>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
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
            <div class="panel panel-red">
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
            <div class="panel panel-primary">
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-building fa-fw"></i> Project Details
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- /.list-group -->
                    <a href="#" class="btn btn-info btn-block">Add Project Order Daily</a>
                    <br/>
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-calendar fa-fw"></i> 11/20/2016
                            <span class="pull-right text-muted small badge"><em>10,000</em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-calendar fa-fw"></i> 11/21/2016
                            <span class="pull-right text-muted small badge"><em>5,000</em>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
@stop