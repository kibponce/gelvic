@extends('partials.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@show', $projectDaily->po_id) }}">
                <i class="fa fa-mail-reply  "></i> Back to Project Order Details
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
            <small class="stats-label">Date</small>
            <h4>{{$projectDaily->date}}</h4>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0.00</div>
                            <div>Cost(Php)</div>
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
                    <i class="fa fa-users fa-fw"></i> Manpower
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- /.list-group -->
                    <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#manpowerModal">Get Manpower from Project</a>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Rate</th>
                                <th>Total Cost</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectOrderDailyManpower as $k=>$v)
                                <tr>
                                    <td>{{$v->manpower->first_name}} {{$v->manpower->last_name}}</td>
                                    <td>0:00 AM</td>
                                    <td>0:00 AM</td>
                                    <td></td>
                                    <td>{{$v->rate}}</td>
                                    <td>
                                        <a type="button" class="btn btn-danger btn-xs" 
                                        href="">
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
                                    <td>{{$v->manpower->employee_id}}</td>
                                    <td>{{$v->manpower->first_name}} {{$v->manpower->last_name}}</td>
                                    <td>{{$v->manpower->position}}</td>
                                    <td>{{$v->manpower->address}}</td>
                                    <td>{{$v->manpower->rate}}</td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-primary btn-xs" 
                                        href="{{ action('ProjectOrderController@assignManpowerToProjectDaily', array( 'po_daily_id' => $projectDaily->id, 'manpower_id' => $v->manpower->id)) }}">
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