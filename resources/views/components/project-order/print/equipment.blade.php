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
            vertical-align: middle;
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
    <div style="text-align: center;">
        <div><strong style="font-size: 20px; color: #5cb85c;"> GELVIC CONSTRUCTION AND ENGINEERING SERVICES </strong></div>
        <div><span style="font-size: 15px;"> #0006 Abragan Compound Sto. Rosario, Iligan City </span> </div>
        <div><strong style="font-size: 15px;"> CONTRACTOR'S DAILY EQUIPMENT RENTAL LIST </strong> </div>
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
                <th width="70">NAME</th>
                <th class="text-right" width="70">RATE</th>
                <th class="text-right" width="70">DURATION</th>
                <th class="text-right" width="70">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projectDailyEquipment as $k=>$v)
                <tr>
                    <td>{{$v->equipment->name}}</td>
                    <td class="text-right">{{number_format($v->rate, 2)}}</td>
                    <td class="text-right">{{number_format($v->duration,2)}}</td>
                    <td class="text-right">{{number_format($v->total,2)}}</td>
                </tr>
            @endforeach
          
                <tr style="background-color: #95ec90;">
                    <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                    <td class="text-right"><strong>{{ number_format( $grandTotalEquipment,2 ) }}</strong></td>
                </tr>
            <!--  -->


        </tbody>
    </table>
</body>
</html>