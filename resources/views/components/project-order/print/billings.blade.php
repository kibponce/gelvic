<!DOCTYPE html>
<html lang="en">
    <title>Gelvic</title>
    <style>
    	@font-face {
    	  font-family: 'Roboto';
    	  font-weight: 300;
    	  font-style: normal;
    	  src: url('../fonts/Roboto-300/Roboto-300.eot');
    	  src: url('../fonts/Roboto-300/Roboto-300.eot?#iefix') format('embedded-opentype'),
    	       local('Roboto Light'),
    	       local('Roboto-300'),
    	       url('../fonts/Roboto-300/Roboto-300.woff2') format('woff2'),
    	       url('../fonts/Roboto-300/Roboto-300.woff') format('woff'),
    	       url('../fonts/Roboto-300/Roboto-300.ttf') format('truetype'),
    	       url('../fonts/Roboto-300/Roboto-300.svg#Roboto') format('svg');
    	}
    	body {
    		font-size : 13px;
    		font-family: 'Roboto';
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
    	    border: 2px solid #c3c3c3;
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
    	.text-center {
    	    text-align: center;
    	}

    </style>
<head>
<body>
	<table class="table table-bordered table-hover table-striped">
	    <thead>
	        <tr>
	        	<th width="30" class="text-center"></th>
	        	<th width="30" class="text-center">TYPE</th>
	        	<th width="30" class="text-center">PAX</th>
	        	<th width="45" class="text-center">Daily</th>
	        	<th width="45" class="text-center">Reg OT (+25%)</th>
	        	<th width="45" class="text-center">Sunday (+30%)</th>
	        	<th width="45" class="text-center">Sunday + 8 OT (+69%)</th>
	        	<th width="45" class="text-center">Legal Hol. (+100%)</th>
	        	<th width="45" class="text-center">Legal Hol. + 8 OT (+160%)</th>
	        	<th width="45" class="text-center">Legal Hol. fall Sunday (+160%)</th>
	        	<th width="45" class="text-center">Legal Hol. + 8 OT fall Sunday (+2.38%)</th>
	        	<th width="45" class="text-center">NP Regular (10%)</th>
	        	<th width="45" class="text-center">NP Sunday (13%)</th>
	        	<th width="45" class="text-center">NP Legal (20%)</th>
	        	<th width="45" class="text-center">Total</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<tr>
	    		<td width="30" colspan="14">PO. No</td>
	    		<td class="text-right"><strong style="font-size: 15px;">{{number_format($projectOrder->amount,2)}}</strong></td>
	    	</tr>	
	    	@foreach ($projectDailies as $k=>$v)
	    		<!-- TYPE A -->
		    	<tr>
		    		<td width="30" class="text-right">{{$v->date}}</td>
		    		<td class="text-center"> A </td>
		    		<td class="text-center"> {{$v->dailyData['totalA']->total_pax}} </td>
		    		<!-- REGULAR -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- REGULAR OT-->
		    		<td class="text-right"> 
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_ot, 2) }}
		    			@endif
		    		</td>
		    		<!-- Sunday-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Sunday + 8 OT-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_ot, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_reg_day,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- NP Regular -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_np, 2) }}
		    			@endif
		    		</td>
		    		<!-- NP Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_np, 2) }} 
		    			@endif
		    		</td>
		    		<!-- NP Legal -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalA']->total_np,2) }} 
		    			@endif
		    		</td>
		    		<!-- Total -->
		    		<td class="text-right"><strong>{{ number_format($v->dailyData['totalA']->total, 2) }}</strong></td>
		    	</tr>
		    	<!-- END TYPE A -->

	    		<!-- TYPE B -->
		    	<tr>
		    		<td width="30" class="text-right"></td>
		    		<td class="text-center"> B </td>
		    		<td class="text-center"> {{$v->dailyData['totalB']->total_pax}} </td>
		    		<!-- REGULAR -->
		    		<td class="text-right"> 
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- REGULAR OT-->
		    		<td class="text-right"> 
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_ot, 2) }}
		    			@endif
		    		</td>
		    		<!-- Sunday-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Sunday + 8 OT-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_ot, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_reg_day,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- NP Regular -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_np, 2) }}
		    			@endif
		    		</td>
		    		<!-- NP Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_np, 2) }} 
		    			@endif
		    		</td>
		    		<!-- NP Legal -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalB']->total_np,2) }} 
		    			@endif
		    		</td>
		    		<!-- Total -->
		    		<td class="text-right"><strong>{{ number_format($v->dailyData['totalB']->total, 2) }}</strong></td>
		    	</tr>
		    	<!-- END OF TYPE B -->

	    		<!-- TYPE C -->
		    	<tr>
		    		<td width="30" class="text-right"></td>
		    		<td class="text-center"> C </td>
		    		<td class="text-center"> {{$v->dailyData['totalC']->total_pax}} </td>
		    		<!-- REGULAR -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- REGULAR OT-->
		    		<td class="text-right"> 
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_ot, 2) }}
		    			@endif
		    		</td>
		    		<!-- Sunday-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Sunday + 8 OT-->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_ot, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_reg_day, 2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_reg_day,2) }} 
		    			@endif
		    		</td>
		    		<!-- Legal Hol. + 8 OT fall Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_ot,2) }} 
		    			@endif
		    		</td>
		    		<!-- NP Regular -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_np, 2) }}
		    			@endif
		    		</td>
		    		<!-- NP Sunday -->
		    		<td class="text-right">
		    			@if($v->dailyData['projectDaily']->isSunday && !$v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_np, 2) }} 
		    			@endif
		    		</td >
		    		<!-- NP Legal -->
		    		<td class="text-right">
		    			@if(!$v->dailyData['projectDaily']->isSunday && $v->dailyData['projectDaily']->isHoliday)
		    				{{ number_format($v->dailyData['totalC']->total_np,2) }} 
		    			@endif
		    		</td>
		    		<!-- Total -->
		    		<td class="text-right"><strong>{{ number_format($v->dailyData['totalC']->total, 2) }}</strong></td>
		    	</tr>
		    	<!-- END OF TYPE C -->
	    	@endforeach
	    		<tr>
	    			<td colspan="14"> Materials & Consumables</td>
	    			<td class="text-right"><strong>{{number_format($totalMaterialsExpense,2)}}</strong></td>
	    		</tr>
	    		<tr style="background-color: #f3f3f3;">
	    			<td colspan="14" class="text-right" style="border-top: 2px solid #272626;"></td>
	    			<td class="text-right" style="border-top: 2px solid #272626;"><strong style="font-size: 15px;">{{number_format($total,2)}}<strong></td>
	    		</tr>
	    		<tr style="background-color: #f3f3f3;">
	    			<td colspan="14" class="text-right"></td>
	    			<td class="text-right" style="border-top: 2px double #444242;"><strong style="font-size: 15px;">{{number_format($remainingTotal,2)}}<strong></td>
	    		</tr>
	    </tbody>
	 </table>
</body>
</html>