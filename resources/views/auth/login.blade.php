<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/notifications/noty.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/extra_noty.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/lines.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/areas.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/bars.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/pies.js') }}"></script>
    <script src="{{ asset('template/assets/demo/data/dashboard/bullets.json') }}"></script>
    <!-- /theme JS files -->

</head>

<body>
    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-static py-2">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a href="index.html" class="d-inline-flex align-items-center">
                    <img src="../../../assets/images/logo_icon.svg" alt="">
                    <img src="../../../assets/images/logo_text_light.svg" class="d-none d-sm-inline-block h-16px ms-3"
                        alt="">
                </a>
            </div>
        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">
                    <!-- Menampilkan pesan error dari API -->
                    @if (session('error_message'))
                        <div class="alert alert-danger text-center mb-3">
                            {{ session('error_message') }}
                        </div>
                    @endif
                    @if (session('login_success'))
                        <div class="alert alert-success">{{ session('login_success') }}</div>
                    @endif
                    <form class="login-form" action="{{ route('auth.login') }}" method="POST">
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="{{ asset('template/assets/images/logo_icon.svg') }}" class="h-48px"
                                        alt="">
                                    <h5 class="mb-0">Login to your account</h5>
                                    <span class="d-block text-muted">Enter your credentials below</span>
                                </div>

                                <!-- Tampilkan pesan error -->
                                @if ($errors->has('login_error'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                @endif


                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Masukan email.." required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="•••••••••••" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>



                    <!-- /login form -->

                </div>
                <!-- /content area -->

                <!-- Footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
</body>

</html>
