@extends('partials.main')

@section('content')
	<div class="row">
	    <div class="col-lg-12 col-md-12">
	        <a type="button" class="btn btn-primary btn-sm" href="{{ action('EquipmentController@add') }}">
	            <i class="fa fa-plus"></i> Add Equipment
	        </a>
	    </div>
	</div>
	<br />
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Equipment List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-dataTable" id="equipment-table">
                    	<thead>
                    		<tr>
                    			<th>ID</th>
                    			<th>Name</th>
                    			<th>Rate</th>
                    			<th class="no-sort text-right" width="30">Action</td>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		@foreach ($equipment as $k=>$v)
                    		    <tr class="odd">
                    		        <td>{{$v->equipment_id}}</td>
                    		        <td>{{$v->name}}</td>
                    		        <td>{{$v->rate}}</td>
                    		        <td class="text-center" width="30">
                    		            <a type="button" class="btn btn-success btn-xs" href="{{ action('EquipmentController@add', $v->id) }}">
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
            $('#equipment-table').DataTable({
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