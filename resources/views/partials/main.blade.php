<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gelvic</title>
    @include('partials.assets.css')

<head>
<body>
    <div id="wrapper">
        <div>
            @include('partials.sidebar')
        </div>
        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
    </div>
    @include('partials.assets.js')

    @yield('scripts')
</body>
</head>
