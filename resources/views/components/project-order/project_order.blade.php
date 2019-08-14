@extends('partials.main')

@section('content')

	<!-- /.row -->
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
	                {{$title}} LIST
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <table width="100%" class="table table-striped table-bordered table-hover table-dataTable project-order-table" id="dataTables-example">
	                    <thead>
	                        <tr>
	                            <th>PO NUMBER</th>
								<th>TYPE</th>
								<th>CATEGORY</th>
	                            <th>START DATE</th>
	                            <th>END DATE</th>
	                            <th>AMOUNT</th>
	                            <th>STATUS</th>
	                            <th class="no-sort text-right" width="30"></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach ($po as $k=>$v)
                                <tr class="odd">
                                    <td>{{$v->po_number}}</td>
									<td>{{$v->type}}</td>
									<td>{{strtoupper($v->category)}}</td>
                                    <td>{{$v->start_date}}</td>
                                    <td>{{$v->end_date}}</td>
                                    <td>{{number_format($v->amount, 2)}}</td>
                                    <td>
                                    	@if($v->is_done)
                                    		<label class="label label-success">DONE</label>
                                    	@else
                                    		<label class="label label-info">IN PROGRESS</label>
                                    	@endif
                                    </td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-info btn-xs" href="{{ action('ProjectOrderController@show', $v->id) }}">
                                            <i class="fa fa-gear"></i>
                                        </a>
                                        <a type="button" class="btn btn-success btn-xs" href="{{ action('ProjectOrderController@add', $v->id) }}">
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

@section('scripts')
	<script>
        $(document).ready(function() {
            $('.project-order-table').DataTable({
                "responsive": true,
                "columnDefs": [ {
                      "targets": 'no-sort',
                      "orderable": true,
                } ],
                "order": [3, "desc"] // order by start date
            });
        });
    </script>
@stop