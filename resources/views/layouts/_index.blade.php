<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SPN</title>

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-datatables/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/chartjs/Chart.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="shortcut icon"
        href="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Insignia_of_the_Indonesian_National_Police.svg/640px-Insignia_of_the_Indonesian_National_Police.svg.png"
        type="image/x-icon">

    <link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />

</head>

<body>
    <div id="app">
        <!-- sidebar -->
        @include('layouts._sidebar')
        <div id="main">
            <!-- navbar -->
            @include('layouts._navbar')
            <!-- main -->
            <div class="main-content container-fluid">
                @yield('content')
            </div>

            <!-- footer -->
            @include('layouts._footer')
        </div>
    </div>
    <script src="{{asset('assets/js/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{asset('assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script src="{{asset('assets/vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/js/vendors.js')}}"></script>

    <script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>

</body>

</html>