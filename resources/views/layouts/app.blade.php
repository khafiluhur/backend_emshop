<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>EMSHOP</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url('assets/imgs/icons/icon-app.png')}}" />
        <!-- Template CSS -->
        <link href="{{url('assets/css/main.css?v=1.1')}}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="screen-overlay"></div>
        @include('components.navbar')
        <main class="main-wrap">
            @include('components.header')
            @yield('content')
            @include('components.footer')
        </main>
        <script src="{{url('assets/js/vendors/jquery-3.6.0.min.js')}}"></script>
        <script src="{{url('assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('assets/js/vendors/select2.min.js')}}"></script>
        <script src="{{url('assets/js/vendors/perfect-scrollbar.js')}}"></script>
        <script src="{{url('assets/js/vendors/jquery.fullscreen.min.js')}}"></script>
        <!-- Main Script -->
        <script src="{{url('assets/js/main.js?v=1.1')}}" type="text/javascript"></script>
        @yield('js')
    </body>
</html>
