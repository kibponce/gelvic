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
            <a type="button" class="btn btn-info btn-sm" href="{{ action('EquipmentController@index') }}">
                <i class="fa fa-mail-reply  "></i> Back to Equipment Lists
            </a>
            </br>
            </br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Equipment Form
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                     {!! Form::open(array('action' => 'EquipmentController@post')) !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <input class="form-control" 
                                        type="hidden" 
                                        name="id"
                                        value="@if(old('id')) {{old('id')}}@elseif($equipment){{$equipment->id}}@endif">
                                <div class="form-group @if ($errors->has('equipment_id')) has-error  @endif">
                                    <label>Equipment ID</label>
                                    <input class="form-control" 
                                            placeholder="Enter ID" 
                                            name="equipment_id" 
                                            autofocus
                                            value="@if(old('equipment_id')) {{old('equipment_id')}}@elseif($equipment){{$equipment->equipment_id}}@endif">
                                    @if ($errors->has('equipment_id'))
                                        <p class="help-block">{{ $errors->first('equipment_id') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group @if ($errors->has('name')) has-error  @endif">
                                    <label>Name</label>
                                    <input class="form-control" 
                                            placeholder="Enter Name" 
                                            name="name" 
                                            value="@if(old('name')) {{old('name')}}@elseif($equipment){{$equipment->name}}@endif">
                                    @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group @if ($errors->has('rate')) has-error  @endif">
                                    <label>Rate</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">PHP
                                        </span>
                                        <input type="text" 
                                                class="form-control" 
                                                placeholder="0.00" 
                                                name="rate" 
                                                value="@if(old('rate')) {{old('rate')}}@elseif($equipment){{$equipment->rate}}@endif">
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