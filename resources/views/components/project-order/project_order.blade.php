@extends('partials.main')

@section('content')
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
	                        <div class="huge">1,000,000</div>
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
                            <div class="huge">100, 000</div>
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
                            <div class="huge">1,000,000</div>
                            <div>Remaining Balance (Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12">
			<a type="button" class="btn btn-primary btn-sm" href="{{ action('ProjectOrderController@add') }}">
				<i class="fa fa-plus"></i> Add Project Order
			</a>
		</div>
	</div>
	<br />
	<!-- /.row -->
	<div class="row">
	    <div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                DataTables Advanced Tables
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <table width="100%" class="table table-striped table-bordered table-hover table-dataTable" id="dataTables-example">
	                    <thead>
	                        <tr>
	                            <th>PO Number</th>
	                            <th>type</th>
	                            <th>Start Date</th>
	                            <th>End Date</th>
	                            <th>Amount</th>
	                            <th class="no-sort text-right" width="30">Action</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach ($po as $k=>$v)
                                <tr class="odd">
                                    <td>{{$v->po_number}}</td>
                                    <td>{{$v->type}}</td>
                                    <td>{{$v->start_date}}</td>
                                    <td>{{$v->end_date}}</td>
                                    <td>{{$v->amount}}</td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-success btn-xs" href="">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
	                    </tbody>
	                </table>
	            </div>
	            <!-- /.panel-body -->
	        </div>
	        <!-- /.panel -->
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
@stop
