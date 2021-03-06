@extends('partials.main')

@section('content') 
    <div class="row">
        <div class="row content-header">
            <div class="col-lg-4 col-md-4">
                <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@index') }}">
                    <i class="fa fa-mail-reply"></i>
                </a>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="btn-group pull-right" role="group" aria-label="...">
                      <a type="button" class="btn btn-info btn-sm" target="_blank" href="{{ action('ProjectOrderController@printSummary', ['po_id' => $projectOrder->id, 'isBilling' => false]) }}">
                          <i class="fa fa-print"></i> Costing
                      </a>
                      <a type="button" class="btn btn-info btn-sm" target="_blank" href="{{ action('ProjectOrderController@printSummary', ['po_id' => $projectOrder->id, 'isBilling' => true]) }}">
                          <i class="fa fa-print"></i> Billing
                      </a>
                </div>
                
            </div>
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
            <small class="stats-label">PO Number</small>
            <h4><strong>{{$projectOrder->po_number}}</strong></h4>
        </div>
		<div class="col-xs-4 col-md-4">
            <small class="stats-label">PO Type</small>
            <h4><strong>{{$projectOrder->type}}</strong></h4>
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
            <h4><a href="{{ action('ProjectOrderController@changeStatus', $projectOrder->id) }}"
                class="btn @if($projectOrder->is_done == 0) btn-info @else btn-success @endif">@if($projectOrder->is_done == 0) IN PROGRESS @else DONE @endif</a></h4>
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
                            <div class="huge text-primary">{{ number_format($projectOrder->amount,2) }}</div>
                            <div>Amount (Php)</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#billingsModal">
                    <div class="panel-footer">
                        <span class="pull-left">Set Billings</span>
                        <span class="pull-right"><i class="fa fa-search"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
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
                            <div class="huge text-danger">{{ number_format($projectTotalExpenses,2) }}</div>

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
                            <div class="huge text-success">{{ number_format($projectRemainingBalance,2) }}</div>
                            @if($projectEquipmentTotaProfit > 0)
                                <div class="profit text-success huge" style="font-size: 20px;">+{{number_format($projectEquipmentTotaProfit,2)}}</div>
                            @endif
                            <div>Profit (Php)</div>
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
                    <i class="fa fa-building fa-fw"></i> Project Daily
                    <!-- Button trigger modal -->
                    <div class="pull-right">
                        <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Equipment</th>
                                <th class="text-center">Manpower</th>
                                <th class="text-center" width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectDaily as $k=>$v)
                                <tr>
                                    <td>
                                        <div>
                                            <i class="fa fa-calendar fa-fw"></i> {{$v->date}}
                                            @if($v->isHoliday)
                                                <span class="label label-info">Holiday</span>
                                            @endif
                                            @if($v->isRegular)
                                                <span class="label label-primary">Regular</span>
                                            @endif
                                            @if($v->isSunday)
                                                <span class="label label-warning">Sunday</span>
                                            @endif
											@if($v->isSpecial)
                                                <span class="label label-success">Special</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="text-right">
                                        {{number_format($v->totalEquipment, 2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($v->totalCost, 2)}}
                                    </td>
                                    <td class="text-center" width=30>
                                        <a type="button" class="btn btn-primary btn-xs" href="{{ action('ProjectOrderController@showProjectDaily', $v->id) }}">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach 
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-right"><strong>{{number_format($projectEquipmentTotalRental,2)}}</strong></td>
                                <td class="text-right"><strong>{{number_format($projectManpowerTotalExpense,2)}}</strong></td>
                                <td></td>
                            </tr>                      
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	        <i class="fa fa-building fa-fw"></i> Materials
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="modal" data-target="#materialsModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
        	    </div>
        	    <!-- /.panel-heading -->
        	    <div class="panel-body">
        	        <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Description</th>
								<th class="text-center">OR</th>
								<th class="text-center">Date</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">Unit</th>
                                <th class="text-right">Unit Cost</th>
                                <th class="text-center">Duration</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectOrderMaterials as $k=>$v)
                                <tr>
                                    <td class="text-center">{{$v->description}}</td>
									<th class="text-center">{{$v->or_number}}</th>
									<td class="text-center">{{$v->or_date}}</td>
                                    <td class="text-center">{{$v->quantity}}</td>
                                    <td class="text-center">{{$v->unit}}</td>
                                    <td class="text-right">{{number_format($v->unit_cost, 2)}}</td>
                                    <td class="text-center">{{$v->duration}}</td>
                                    <td class="text-right">{{number_format($v->total_amount,2)}}</td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-danger btn-xs" href="{{action('MaterialsController@delete', array('id' => $v->id, 'po_id' => $projectOrder->id))}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if(count($projectOrderMaterials) == 0)
                                <tr>
                                    <td colspan="9" class="text-center">No Items Added</td>
                                </tr>
                            @else
                                <tr style="background-color: #95ec90;">
                                    <td colspan="7" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right"><strong>{{number_format($totalMaterialsExpense, 2)}}</strong></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        	    </div>
        	    <!-- /.panel-body -->
            </div>

            <!-- <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-building fa-fw"></i> Equipment
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="modal" data-target="#equipmentsModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-right">Rate</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Duration</th>
                                <th class="text-right">Expense</th>
                                <th class="text-right">Profit</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projectEquipment as $k=>$v)
                                <tr>
                                    <td class="text-left">{{$v->equipment->name}}</td>
                                    <td class="text-right">{{number_format($v->rate,2)}}</td>
                                    <td class="text-center">{{$v->description}}</td>
                                    <td class="text-center">{{$v->duration}}</td>
                                    <td class="text-right">{{number_format($v->expense,2)}}</td>
                                    <td class="text-right">{{number_format($v->profit,2)}}</td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-danger btn-xs" href="{{action('EquipmentController@projectDelete', array('id' => $v->id, 'po_id' => $projectOrder->id))}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($projectEquipment) == 0)
                                <tr>
                                    <td colspan="7" class="text-center">No Items Added</td>
                                </tr>
                            @else
                                <tr style="background-color: #95ec90;">
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right"><strong>{{number_format($projectEquipmentTotalExpense,2)}}</strong></td>
                                    <td  class="text-right"><strong>{{number_format($projectEquipmentTotaProfit,2)}}</strong></td>
                                    <td>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
    </div>
@stop

@section('modals')
    <!-- Project Daily Modal -->
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
    </div>
    <!-- /.modal-dialog -->


    <!-- Materials Modal -->
    <div class="modal fade" id="materialsModal" tabindex="-2" role="dialog" aria-labelledby="materialsModal" aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(array('action' => 'MaterialsController@post')) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Materials Form</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
						<div class="col-lg-12">
                            <div class="form-group @if ($errors->has('duration')) has-error  @endif">
                                <label>OR Number</label>
                                <input type="text" class="form-control" placeholder="Enter OR Number" name="or_number" value="@if(old('endif')) {{old('endif')}} @endif">
                                @if ($errors->has('or_number'))
                                    <p class="help-block">{{ $errors->first('or_number') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('description')) has-error  @endif">
                                <label>Description</label>
                                <input class="form-control" 
                                        placeholder="Enter Description" 
                                        name="po_id"
                                        type="hidden"
                                        value="{{$projectOrder->id}}">
                                <input class="form-control" 
                                        placeholder="Enter Description" 
                                        name="description" 
                                        value="@if(old('description')) {{old('description')}} @endif">
                                @if ($errors->has('description'))
                                    <p class="help-block">{{ $errors->first('description') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('quantity')) has-error  @endif">
                                <label>Quantity</label>
                                <input type="text" class="form-control" placeholder="Enter Quantity" name="quantity" value="@if(old('quantity')) {{old('quantity')}} @endif">
                                @if ($errors->has('quantity'))
                                    <p class="help-block">{{ $errors->first('quantity') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('unit')) has-error  @endif">
                                <label>Unit</label>
                                <input type="text" class="form-control" placeholder="Enter Unit" name="unit" value="@if(old('unit')){{old('unit')}}@endif">
                                @if ($errors->has('unit'))
                                    <p class="help-block">{{ $errors->first('unit') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('unit_cost')) has-error  @endif">
                                <label>Unit Cost</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">PHP</span>
                                    <input type="text" class="form-control" placeholder="Enter Cost" name="unit_cost" value="@if(old('unit_cost')){{old('unit_cost')}}@endif">
                                </div>
                                @if ($errors->has('unit_cost'))
                                    <p class="help-block">{{ $errors->first('unit_cost') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('duration')) has-error  @endif">
                                <label>Duration</label>
                                <input type="text" class="form-control" placeholder="Enter Duration" name="duration" value="@if(old('endif')) {{old('endif')}} @endif">
                                @if ($errors->has('duration'))
                                    <p class="help-block">{{ $errors->first('duration') }} </p>
                                @endif
                            </div>
                        </div>
						
						<div class="col-lg-12">
                            <div class="form-group @if ($errors->has('duration')) has-error  @endif">
                                <label>Date</label>
                                <div class='input-group date' id='materialDate'>
                                        <input type='text' class="form-control" name="date" placeholder="Enter Date" value=""/>
                                        <span class="input-group-addon">
                                           <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->

    <!-- Materials Modal -->
    <div class="modal fade" id="equipmentsModal" tabindex="-2" role="dialog" aria-labelledby="equipmentsModal" aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(array('action' => 'EquipmentController@projectPost')) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Equipments Form</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('equipment')) has-error  @endif">
                                <label>Equipment</label>
                                <input class="form-control" 
                                        placeholder="Enter Description" 
                                        name="po_id"
                                        type="hidden"
                                        value="{{$projectOrder->id}}">
                                <select class="form-control" name="equipment">
                                    <option value="">All Equipments</option>
                                    @foreach($equipments as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('equipment'))
                                    <p class="help-block">{{ $errors->first('equipment') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('duration')) has-error  @endif">
                                <label>Duration</label>
                                <input type="text" class="form-control" placeholder="Enter Unit" name="duration" value="@if(old('duration')){{old('duration')}}@endif">
                                @if ($errors->has('duration'))
                                    <p class="help-block">{{ $errors->first('duration') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('expense')) has-error  @endif">
                                <label>Expense</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">PHP</span>
                                    <input type="text" class="form-control" placeholder="Enter Cost" name="expense" value="@if(old('expense')){{old('expense')}}@endif">
                                </div>
                                @if ($errors->has('expense'))
                                    <p class="help-block">{{ $errors->first('expense') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group @if ($errors->has('expense')) has-error  @endif">
                                <label>Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Description" value=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->

    <!-- Materials Modal -->
    <div class="modal fade" id="billingsModal" tabindex="-2" role="dialog" aria-labelledby="billingsModal" aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(array('action' => 'ProjectOrderController@setBillings')) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Billings</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Type A</label>
                                <input class="form-control" 
                                        placeholder="Enter Description" 
                                        name="po_id"
                                        type="hidden"
                                        value="{{$projectOrder->id}}">
                                <div class="form-group input-group">
                                    <input type="text" class="form-control" placeholder="Enter Cost" name="type_a" value="{{number_format($projectOrder->type_a * 8,2, '.', '')}}">
                                    <span class="input-group-addon">Rate</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Type B</label>
                                <div class="form-group input-group">
                                    <input type="text" class="form-control" placeholder="Enter Cost" name="type_b" value="{{number_format($projectOrder->type_b * 8,2, '.', '')}}">
                                    <span class="input-group-addon">Rate</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Type C</label>
                                <div class="form-group input-group">
                                    <input type="text" class="form-control" placeholder="Enter Cost" name="type_c" value="{{number_format($projectOrder->type_c * 8,2, '.', '')}}">
                                    <span class="input-group-addon">Rate</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Materials & Consumables</label>
                                <input type="text" class="form-control" placeholder="Enter Cost" name="materials" value="{{number_format($projectOrder->materials,2, '.', '')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
@stop

@section('scripts')
	<script type="text/javascript">
        var error = "{{$error}}";
        $(function () {
			$('#materialDate').datetimepicker({
                format : "YYYY-MM-DD"
            });
			
            $('#datepicker').datetimepicker({
            	format : "YYYY-MM-DD",
                inline: true,
                sideBySide: true,
                minDate : "{{$projectOrder->start_date}}"
            });

            if(error === "MATERIALS") {
                $('#materialsModal').modal('show');
            }

            if(error === "EQUIPMENT") {
                $('#equipmentsModal').modal('show');
            }
        });
    </script>
@stop