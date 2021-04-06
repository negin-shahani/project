<?php
 // input your data (vaghti 100 behesh midi toolesh be 110 mirese vali)
$dataPoints = array();
    $i=1;
    foreach ($logs as $log) {
         array_push ( $dataPoints ,array("y" => $log->score, "label" => $i) ) ;
         $i++;
    }
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

        <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: ""
    },
    axisY: {
        title: "SCORE"
    },
    data: [{
        type: "line",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
</script>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor.dashboard') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor.editprofile') }}">
                       <i class="ni ni-single-02 text-blue"></i> {{ __('User profile') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor.report') }}">
                       <i class="ni ni-chat-round text-blue"></i> {{ __('Report') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('icons') }}">
                        <i class="ni ni-planet text-blue"></i> {{ __('Icons') }}
                    </a>
                </li>   
            </ul>
        </div>
    </div>
</nav>

        @endauth
        
        <div class="main-content">
            @include('layouts.navbars.navbar')
@section('content')
    @include('users.partials.header', [
        'title' => '',
    ])

<div class="container-fluid mt--7">
        <div class="row">     
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{$user->name}} {{$user->familyname}}</h3>
                        </div>
                    </div>
        <div class="row">
            <div class="col-xl-12 mb-12 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">User log</h2>
                            </div>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
        <div class="row mt-5">
            <div class="col-xl-12 mb-12 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Last 20 games</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Levels</th>
                                    <th scope="col">Score</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td>
                                        {{$log->created_at}}
                                    </td>
                                    <td>
                                        {{$log->levels}}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2">{{$log->score}}%</span>
                                            <div>
                                                <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="{{$log->score}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$log->score}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
























    </div>




































































                    <div class="card-body">
                        <form method="POST" action="{{route('doctor.updatelevels',$user->id)}}" autocomplete="off">
                            @csrf                 
                            @if (session('successMsg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('successMsg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="pl-lg-4">


                                <div class="form-group{{ $errors->has('levels') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-levels">{{ __('Start and ending levels') }}</label><br>
                                    <input type="checkbox" name="l1" class="form-control-alternative" value="1" style="margin-right:0.1em"><label style="margin-right:0.5em"> 1</label>
                                    <input type="checkbox" name="l2" class="form-control-alternative" value="2" style="margin-right:0.1em"><label style="margin-right:0.5em"> 2</label>
                                    <input type="checkbox" name="l3" class="form-control-alternative" value="3" style="margin-right:0.1em"><label style="margin-right:0.5em"> 3</label>
                                    <input type="checkbox" name="l4" class="form-control-alternative" value="4" style="margin-right:0.1em"><label style="margin-right:0.5em"> 4</label>
                                    <input type="checkbox" name="l5" class="form-control-alternative" value="5" style="margin-right:0.1em"><label > 5</label>
                                    @if (session('errorMsg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('errorMsg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                     @endif
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        <br><br>
                        <form method="POST" action="{{route('doctor.updatenotification',$user->id)}}" autocomplete="off">
                            @csrf       
                            @if (session('successMsg2'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('successMsg2') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif          
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('text') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-text">{{ __('Leave a message') }}</label>
                                    <textarea name="text" id="input-text" class="form-control form-control-alternative{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Text') }}" required ></textarea>

                                    @if ($errors->has('text'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('text') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>


        
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    </body>
</html>
