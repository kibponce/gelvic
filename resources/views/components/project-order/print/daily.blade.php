<!DOCTYPE html>
<html lang="en">
    <title>Gelvic</title>
    <style>
    	body {
    		font-size : 12px;
    		font-family: 'Open Sans';
    	}
    	table {
    	    background-color: transparent;
    	    border-spacing: 0;
    	    border-collapse: collapse;
    	}
    	.table {
    	    width: 100%;
    	    max-width: 100%;
    	    margin-bottom: 20px;
    	}
    	.table-bordered {
    	    border: 1px solid #ddd;
    	}
    	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    	    border: 1px solid #ddd;
    	}
    	.table>thead {
    		background: #eaeaea;
    	}
    	.table>thead>tr>th {
    	    vertical-align: bottom;
    	    border-bottom: 2px solid #ddd;
    	}
    	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    	    padding: 2px;
    	    line-height: 1.42857143;
    	    vertical-align: top;
    	    border-top: 1px solid #ddd;
    	}
    	th {
    	    text-align: left;
    	}
    	.text-right {
    	    text-align: right;
    	}
    	.text-left {
    	    text-align: left;
    	}
    	.text-left {
    	    text-align: center;
    	}

    </style>
<head>
<body>
	<div style="text-align: center;">
		<div><strong style="font-size: 20px; color: #5cb85c;"> GELVIC CONSTRUCTION AND ENGINEERING SERVICES </strong></div>
		<div><span style="font-size: 15px;"> #0006 Abragan Compound Sto. Rosario, Iligan City </span> </div>
		<div><strong style="font-size: 15px;"> CONTRACTOR'S DAILY MANPOWER LIST </strong> </div>
		<div><strong style="font-size: 13px; color: #d9534f;"> @if($projectDaily->isHoliday) HOLIDAY @endif @if($projectDaily->isSunday) SUNDAY @endif</strong> </div>
	</div>
	<br/>
	<div>
		<p style="font-size: 13px;" class="text-right"><strong>Date : </strong> {{$projectDaily->date}}</p>
		<p style="font-size: 13px;">
			<strong>PO # : </strong> {{$projectOrder->po_number}} 
		</p>

		<p style="font-size: 13px;"><strong>Activity : </strong> {{$projectDaily->activity}}</p>
	</div>
	<table class="table table-bordered table-hover table-striped">
	    <thead>
	        <tr>
	            <th width="10">No.</th>
	            <th width="70">NAME</th>
	            <th width="25">RATE</th>
	            <th class="text-center"># OF HOURS</th>
	            <th class="text-center" width="45">REG. DAY</th>
	            <th class="text-center"># OF HOURS</th>
	            <th class="text-center" width="45">REG. OT</th>
	            <th class="text-center"># OF HOURS</th>
	            <th class="text-center" class="text-center" width="40">REG. NP</th>
	            <th class="text-center" width="35">TOTAL</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<!-- TYPE A -->
	    	@if(count($typeA) != 0)
	    	    <tr>
	    	        <th colspan="10">Type A</th>
	    	    </tr>
	    	@endif
	        @foreach ($typeA as $k=>$v)
	            <tr>
	                <td>{{$k + 1}}</td>
	                <td>{{strtoupper($v->manpower->last_name)}}, {{strtoupper($v->manpower->first_name[0])}} </td>
	                <td class="text-right">{{number_format($v->rate,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
	                <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
	            </tr>
	        @endforeach
	        @if(count($typeA) != 0)
	            <tr style="background-color: #bbd8f1;">
	                <td colspan="4" class="text-right">TOTAL</td>
	                <td class="text-right">{{ number_format( $totalA->total_reg_day,2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalA->total_ot_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalA->total_ot, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalA->total_np_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalA->total_np, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalA->total, 2 ) }}</td>
	            </tr>
	        @endif


	        <!-- TYPE B -->
	        @if(count($typeB) != 0)
	            <tr>
	                <th colspan="10">Type B</th>
	            </tr>
	        @endif 
	        @foreach ($typeB as $k=>$v)
	            <tr>
	                <td>{{$k + 1}}</td>
	                <td>{{strtoupper($v->manpower->last_name)}}, {{strtoupper($v->manpower->first_name[0])}} </td>
	                <td class="text-right">{{number_format($v->rate,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
	                <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
	            </tr>
	        @endforeach
	        @if(count($typeB) != 0)
	            <tr style="background-color: #bbd8f1;">
	                <td colspan="4" class="text-right">Total</td>
	                <td class="text-right">{{ number_format( $totalB->total_reg_day,2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalB->total_ot_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalB->total_ot, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalB->total_np_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalB->total_np, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalB->total, 2 ) }}</td>
	            </tr>
	        @endif
	        
	        <!-- TYPE C -->
	        @if(count($typeC) != 0)
	            <tr>
	                <th colspan="10">Type C</th>
	            </tr>
	        @endif
	        @foreach ($typeC as $k=>$v)
	            <tr>
	                <td>{{$k + 1}}</td>
	                <td>{{strtoupper($v->manpower->last_name)}}, {{strtoupper($v->manpower->first_name[0])}} </td>
	                <td class="text-right">{{number_format($v->rate,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularTotalHour, 2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalOTHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regularHourOTPay,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regTotalNPHour,2)}}</td>
	                <td class="text-right">{{number_format($v->rateAndHours->regHourNPPay,2)}}</td>                          
	                <td class="text-right">{{number_format($v->rateAndHours->total,2)}}</td>
	            </tr>
	        @endforeach

	        @if(count($typeC) != 0)
	            <tr style="background-color: #bbd8f1;">
	                <td colspan="4" class="text-right">TOTAL</td>
	                <td class="text-right">{{ number_format( $totalC->total_reg_day,2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalC->total_ot_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalC->total_ot, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalC->total_np_no_hours, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalC->total_np, 2 ) }}</td>
	                <td class="text-right">{{ number_format( $totalC->total, 2 ) }}</td>
	            </tr>
	        @endif

	        @if(count($projectOrderDailyManpower) != 0)
	            <tr style="background-color: #95ec90;">
	                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total_reg_day,2 ) }}</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total_ot_no_hours, 2 ) }}</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total_ot, 2 ) }}</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total_np_no_hours, 2 ) }}</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total_np, 2 ) }}</strong></td>
	                <td class="text-right"><strong>{{ number_format( $total->total, 2 ) }}</strong></td>
	            </tr>
	        @endif
	        <!--  -->


	    </tbody>
	</table>
</body>
</html>