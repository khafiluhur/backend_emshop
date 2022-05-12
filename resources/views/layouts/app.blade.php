<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }} | EMSHOP</title>
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
        <!-- Boostrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .table > :not(:last-child) > :last-child > * {
                border-bottom-color: darkgrey;
            }
        </style>
        @yield('css')
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
        <!-- Boostrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        @yield('js')
    </body>
</html>
