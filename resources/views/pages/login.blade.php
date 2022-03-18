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
        <link rel="shortcut icon" type="image/x-icon" href="{{url('assets/imgs/icons/icon_app.png')}}" />
        <!-- Template CSS -->
        <link href="{{url('assets/css/main.css?v=1.1')}}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="content-main mt-80 mb-80">
                <div class="card mx-auto card-login">
                    <img class="content-main w-50" style="background-color: transparent" src="https://emshop.id/media/logo/stores/7/Logo_emshop_2022_tanpa_tagline.png" class="logo" alt="Nest Dashboard" />
                    <div class="card-body">
                        <h4 class="card-title mb-4">Sign in</h4>
                        <form action="{{ url('/') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" placeholder="Email" name="email" type="text" />
                            </div>
                            <!-- form-group// -->
                            <div class="mb-3">
                                <input class="form-control" placeholder="Password" name="password" type="password" />
                            </div>
                            <!-- form-group// -->
                            <div class="mb-3">
                                <a href="#" class="float-end font-sm text-muted">Forgot password?</a>
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" checked="" />
                                    <span class="form-check-label">Remember</span>
                                </label>
                            </div>
                            <!-- form-group form-check .// -->
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                            <!-- form-group// -->
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{url('assets/js/vendors/jquery-3.6.0.min.js')}}"></script>
        <script src="{{url('assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('assets/js/vendors/jquery.fullscreen.min.js')}}"></script>
        <!-- Main Script -->
        <script src="{{url('assets/js/main.js?v=1.1')}}" type="text/javascript"></script>
    </body>
</html>
