<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>
        @section('title')
            App name
        @show
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Bootstrap styles -->
    {!! HTML::style('assets/bower_components/bootstrap/dist/css/bootstrap.css'); !!}

    <!-- jQuery with jQuery Easing, and jQuery Transit JS -->
    {!! HTML::script('assets/bower_components/jquery/dist/jquery.min.js'); !!}

    <!-- Bootstrap JS -->
    {!! HTML::script('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); !!}

    <!-- Modernizer -->
    {!! HTML::script('assets/bower_components/modernizr/modernizr.js'); !!}

    <!-- Main JS -->
    {!! HTML::script('js/main.js'); !!}

</head>
<body>

<!-- Header Partial -->
@include('layouts.partials.header')

<!-- Page Content -->
@yield('main')

<!-- Header Partial -->
@include('layouts.partials.footer')


</body>
</html>