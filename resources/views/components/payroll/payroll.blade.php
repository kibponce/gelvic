@extends('partials.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3">
        	<div id="reportrange" class="form-control pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                <span>January 1, 2017 - January 30, 2017</span> <b class="caret"></b>
            </div>
        </div>
    </div>
    <br />
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Payroll
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="payroll-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total Regular Hours</th>
                                <th>Regular</th>
                                <th>Total Overtime Hours</th>
                                <th>Overtime</th>
                                <th>Total NP Hours</th>
                                <th>NP</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($manpower as $k=>$v)
                        	    <tr class="odd">
                        	        <td>{{strtoupper($v->last_name)}}, {{strtoupper($v->first_name)}}</td>
                        	        <td class="text-right">{{number_format($v->payrollTotal->total_no_of_hours,2)}}</td>
                        	        <td class="text-right" style="background-color: #caefca;"><strong>{{number_format($v->payrollTotal->total_reg_day,2)}}<strong></td>
                        	        <td class="text-right" >{{number_format($v->payrollTotal->total_ot_no_hours,2)}}</td>
                        	        <td class="text-right" style="background-color: #caefca;"><strong>{{number_format($v->payrollTotal->total_ot,2)}}<strong></td>
                        	        <td class="text-right">{{number_format($v->payrollTotal->total_np_no_hours,2)}}</td>
                        	        <td class="text-right" style="background-color: #caefca;"><strong>{{number_format($v->payrollTotal->total_np,2)}}<strong></td>
                        	        <td class="text-right" style="background-color: #e8e8e8;"><strong style="color:#5cb85c;">{{number_format($v->payrollTotal->total,2)}}</strong></td>
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

	<script type="text/javascript">
	$(function() {

	    var start = '{{$start}}' ? moment('{{$start}}') : moment().startOf('month');
	    var end = '{{$end}}' ? moment('{{$end}}') : moment().endOf('month');
	    var payrollTable = $('#payroll-table').dataTable({
	    	"pageLength": -1,
	    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
	    });

	    function cb(start, end) {

	        $('#reportrange span').html(moment('{{$start}}').format('MMMM D, YYYY') + ' - ' + moment('{{$end}}').format('MMMM D, YYYY'));
	        if(start && end) {
	        	window.location.href = "{{ action('PayrollController@index') }}/" + start.format('YYYY-MM-DD') + "/" + end.format('YYYY-MM-DD'); 
	    	}
	    }

	    $('#reportrange').daterangepicker({
	    	alwaysShowCalendars: true,
	        startDate: start,
	        endDate: end,
	        ranges: {
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           '1st Payroll of the Month': [moment().startOf('month'), moment().startOf('month').add(14, 'days')],
	           '2nd Payroll of the Month': [moment().startOf('month').add(14, 'days'), moment().endOf('month')]
	        }
	    }, cb);

	    if('{{$start}}') {
	    	cb();
	    }

	     

	});
	</script>
@stop