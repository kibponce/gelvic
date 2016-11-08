@extends('partials.main')

@section('content')
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
            @endif
            <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@index') }}">
                <i class="fa fa-mail-reply  "></i> Back to Project Order Lists
            </a>
            </br>
            </br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Project Order Form
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {!! Form::open(array('action' => 'ProjectOrderController@post')) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('po_number')) has-error  @endif">
                                <input class="form-control" type="hidden" name="id" value="@if(old('id')) {{old('id')}}@elseif($projectOrder){{$projectOrder->id}}@endif">
                                <label>Project Order Number</label>
                                <input class="form-control" 
                                        placeholder="Enter Po Number" 
                                        name="po_number" 
                                        autofocus
                                        value="@if(old('po_number')) {{old('po_number')}}@elseif($projectOrder){{$projectOrder->po_number}}@endif">
                                @if ($errors->has('po_number'))
                                    <p class="help-block">{{ $errors->first('po_number') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('type')) has-error  @endif">
                                <label>Project Order Type</label>
                                <input class="form-control" 
                                        placeholder="Enter Po Type" 
                                        name="type" 
                                        value="@if(old('type')) {{old('type')}}@elseif($projectOrder){{$projectOrder->type}}@endif">
                                @if ($errors->has('type'))
                                    <p class="help-block">{{ $errors->first('type') }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('amount')) has-error  @endif">
                                <label>Amount</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">PHP
                                    </span>
                                    <input type="text" class="form-control" placeholder="0.00" name="amount" value="@if(old('amount')) {{old('amount')}}@elseif($projectOrder){{$projectOrder->amount}}@endif">
                                </div>
                                @if ($errors->has('amount'))
                                    <p class="help-block">{{ $errors->first('amount') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('start_date')) has-error  @endif">
                                <label>Start Date</label>
                                <div class='input-group date' id='start_date'>
                                    <input type='text' 
                                            class="form-control" 
                                            name="start_date" 
                                            placeholder="Enter Start Date" 
                                            value="@if(old('start_date')) {{old('start_date')}}@elseif($projectOrder){{$projectOrder->start_date}}@endif"/>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                @if ($errors->has('start_date'))
                                    <p class="help-block">{{ $errors->first('start_date') }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('area')) has-error  @endif">
                                <label>Area</label>
                                <input class="form-control" 
                                        placeholder="Enter Area" 
                                        name="area" 
                                        autofocus
                                        value="@if(old('area')) {{old('area')}}@elseif($projectOrder){{$projectOrder->area}}@endif">
                                @if ($errors->has('area'))
                                    <p class="help-block">{{ $errors->first('area') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('end_date')) has-error  @endif">
                                <label>End Date</label>
                                <div class='input-group date' id='end_date'>
                                    <input type='text' 
                                            class="form-control" 
                                            name="end_date" 
                                            placeholder="Enter End Date" 
                                            value="@if(old('end_date')) {{old('end_date')}}@elseif($projectOrder){{$projectOrder->end_date}}@endif"/>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                @if ($errors->has('end_date'))
                                    <p class="help-block">{{ $errors->first('end_date') }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"> @if(old('description')) {{old('description')}}@elseif($projectOrder){{$projectOrder->description}}@endif </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
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
        $(function () {
            var $start_date = $('#start_date'),
                $end_date = $('#end_date');

            $start_date.datetimepicker({
                format : "YYYY-MM-DD"
            });

            $end_date.datetimepicker({
                format : "YYYY-MM-DD",
                useCurrent: false //Important! See issue #1075
            });

            $start_date.on("dp.change", function (e) {
               $end_date.data("DateTimePicker").minDate(e.date);
            });
            $end_date.on("dp.change", function (e) {
               $start_date .data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
@stop