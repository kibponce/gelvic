@extends('partials.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <a type="button" class="btn btn-info btn-sm" href="{{ action('ProjectOrderController@show', $projectDaily->po_id) }}">
                <i class="fa fa-mail-reply  "></i> Back to Project Order Details
            </a>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-xs-2 col-md-2">
            <small class="stats-label">Date</small>
            <h4>{{$projectDaily->date}}</h4>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0.00</div>
                            <div>Cost(Php)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop