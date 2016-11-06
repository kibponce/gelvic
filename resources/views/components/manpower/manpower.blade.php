@extends('partials.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <a type="button" class="btn btn-primary btn-sm" href="{{ action('ManpowerController@add') }}">
                <i class="fa fa-plus"></i> Add Manpower
            </a>
        </div>
    </div>
    <br />
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manpower List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover table-dataTable" id="manpower-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th class="no-sort">Address</th>
                                <th>Rate</th>
                                <th class="no-sort text-right" width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manpower as $k=>$v)
                                <tr class="odd">
                                    <td>{{$v->employee_id}}</td>
                                    <td>{{$v->first_name}} {{$v->last_name}}</td>
                                    <td>{{$v->position}}</td>
                                    <td>{{$v->address}}</td>
                                    <td>{{$v->rate}}</td>
                                    <td class="text-center" width="30">
                                        <a type="button" class="btn btn-success btn-xs" href="{{ action('ManpowerController@add', $v->id) }}">
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