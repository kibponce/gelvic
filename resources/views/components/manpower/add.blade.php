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
            <a type="button" class="btn btn-info btn-sm" href="{{ action('ManpowerController@index') }}">
                <i class="fa fa-mail-reply  "></i> Back to Manpower Lists
            </a>
            <br/>
            <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manpower Form
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                     {!! Form::open(array('action' => 'ManpowerController@post')) !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <input class="form-control" type="hidden" name="id" value="@if(old('id')) {{old('id')}}@elseif($manpower){{$manpower->id}}@endif">
                                <div class="form-group @if ($errors->has('employee_id')) has-error  @endif">
                                    <label>Employee ID</label>
                                    <input class="form-control" placeholder="Enter ID" name="employee_id" autofocus value="@if(old('employee_id')) {{old('employee_id')}}@elseif($manpower){{$manpower->employee_id}}@endif">
                                    @if ($errors->has('employee_id'))
                                        <p class="help-block">{{ $errors->first('employee_id') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('first_name')) has-error  @endif">
                                    <label>First Name</label>
                                    <input class="form-control" placeholder="Enter First Name" name="first_name" value="@if(old('first_name')){{old('first_name')}}@elseif($manpower){{$manpower->first_name}}@endif">
                                    @if ($errors->has('first_name'))
                                        <p class="help-block">{{ $errors->first('first_name') }} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('last_name')) has-error  @endif">
                                    <label>Last Name</label>
                                    <input class="form-control" placeholder="Enter Last Name" name="last_name" value="@if(old('last_name')) {{old('last_name')}}@elseif($manpower){{$manpower->last_name}}@endif">
                                    @if ($errors->has('last_name'))
                                        <p class="help-block">{{ $errors->first('last_name') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('birthdate')) has-error  @endif">
                                    <label>Birthdate</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="birthdate" placeholder="Enter Date" value="@if(old('birthdate')) {{old('birthdate')}}@elseif($manpower){{$manpower->birthdate}}@endif"/>
                                        <span class="input-group-addon">
                                           <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    @if ($errors->has('birthdate'))
                                        <p class="help-block">{{ $errors->first('birthdate') }} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('address')) has-error  @endif">
                                    <label>Address</label>
                                    <input class="form-control" placeholder="Enter Address" name="address" value="@if(old('address')) {{old('address')}}@elseif($manpower){{$manpower->address}}@endif">
                                    @if ($errors->has('address'))
                                        <p class="help-block">{{ $errors->first('address') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('position')) has-error  @endif">
                                    <label>Position</label>

                                    <select class="form-control" name="position">
                                        @foreach ($positions as $k=>$v)
                                            <option value="{{$k}}"
                                                    @if($manpower) 
                                                        @if($k == $manpower->position)
                                                            selected
                                                        @endif
                                                    @endif
                                                    > {{$k}} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('position'))
                                        <p class="help-block">{{ $errors->first('position') }} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group @if ($errors->has('rate')) has-error  @endif">
                                    <label>Rate</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">PHP
                                        </span>
                                        <input type="text" class="form-control" id="hour_rate" placeholder="0.00" name="rate" value="@if(old('rate')) {{old('rate')}}@elseif($manpower){{$manpower->rate}}@endif">
                                        <span class="input-group-addon">
                                            /Hour
                                        </span>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">PHP
                                        </span>
                                        <input type="text" class="form-control" id="reg_rate" placeholder="0.00" name="" value="">
                                        <span class="input-group-addon">
                                        Regular Rate
                                        </span>
                                    </div>
                                    
                                    @if ($errors->has('rate'))
                                        <p class="help-block">{{ $errors->first('rate') }} </p>
                                    @endif
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
            var hourRate = $('#hour_rate'),
                regRate = $('#reg_rate'),
                totalHourRate,
                totalRegRate;

            $('#datetimepicker1').datetimepicker({
                format : "YYYY-MM-DD"
            });

            function getHourRate(){
                return regRate.val() > 0 || regRate.val() != "" ? parseFloat(regRate.val()) / 8 : 0;
            }

            function getRegRate(){
                return hourRate.val() > 0 || hourRate.val() != "" ? parseFloat(hourRate.val()) * 8 : 0;
            }

            hourRate.on('keyup', function (){
                regRate.val(parseFloat(getRegRate()).toFixed(2));
            });

            regRate.on('keyup', function (){
                hourRate.val(parseFloat(getHourRate()).toFixed(2));  
            });

            regRate.val(parseFloat(getRegRate()).toFixed(2));
            hourRate.val(parseFloat(getHourRate()).toFixed(2)); 
        });
    </script>
@stop