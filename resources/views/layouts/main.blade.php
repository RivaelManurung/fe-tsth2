<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Responsive Scan Stylesheets-->
    <!-- Global stylesheets -->
    <link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ asset('template/assets/js/vendor/notifications/noty.min.js') }}"></script>
    {{-- <script src="{{asset('template/assets/demo/pages/extra_sweetalert.js')}}"></script> --}}
    <script src="{{ asset('template/assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <script src="{{ asset('template/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/datatables_extension_buttons_html5.js') }}"></script>

    <link href="{{ asset('template/assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
    {{-- <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script> --}}
    <script src="{{ asset('template/assets/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/datatables_extension_key_table.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/key_table.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/fullcalendar_styling.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/dashboard/sparklines.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/dashboard/lines.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/dashboard/areas.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/dashboard/donuts.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/deashboard/bars.js') }}"></script> --}}
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    {{-- <script src="{{ asset('template/assets/demo/charts/pages/dashboard/pies.js') }}"></script> --}}
    <script src="{{ asset('template/assets/demo/data/dashboard/bullets.json') }}"></script>
    <!-- /theme JS files -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.3/dist/parsley.min.js"></script>

    {{-- font awesome  --}}
    <link href="{{ asset('template/assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

    <!-- Main navbar -->
    @include('layouts.navbar')

    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            @include('layouts.sidebar')

            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                @include('components.page_header')
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">
                    <!-- Dashboard content -->
                    @yield('content')
                    <!-- /dashboard content -->
                </div>
                <!-- /content area -->

                {{-- <!-- Tombol Scan -->
                <button id="scan-btn" class="btn btn-primary d-flex  btn-position btn-circle">
                    <i class="ph-scan ph-2x rounded"></i>
                </button>

                <!-- Container Scanner -->
                <div id="scanner-container" style="display: none;">
                    <button id="close-btn">✖</button>
                    <video id="preview"></video>
                    <input type="text" id="qrcode-result" class="form-control mt-2" readonly>
                </div> --}}

                <!-- Footer -->
                @include('layouts.footer')
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @include('components.demo_config')

    <!-- Notifications -->
    @include('components.notifications')

    <!-- /notifications -->


    <!-- Demo config -->

    <!-- /demo config -->

</body>
{{--
<script>
    const swalCombineElement = document.querySelector('#sweet_combine');
    if (swalCombineElement) {
        swalCombineElement.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'No, cancel!',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Kalau klik Yes, kirim form logout
                    document.getElementById('logoutForm').submit();
                }
                // Gak usah pakai else, biar kalau cancel yaudah selesai
            });
        });
    }
</script> --}}

<script>
    const swalCombineElement = document.querySelector('#sweet_combine');
    if (swalCombineElement) {
        swalCombineElement.addEventListener('click', function() {
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to logout now?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="ph-sign-out"></i> Yes, log me out',
                cancelButtonText: '<i class="ph-x-circle"></i> Nope, stay logged in',
                buttonsStyling: false,
                reverseButtons: true,
                background: '#fdfdfd',
                color: '#333',
                iconColor: '#0d6efd',
                customClass: {
                    popup: 'rounded-4 shadow-lg border border-light-subtle',
                    title: 'fw-semibold fs-5',
                    confirmButton: 'btn btn-primary px-4 py-2 me-2',
                    cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
                // Cancel? Gak ngapa-ngapain. Biar smooth.
            });
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch("http://localhost:8090/api/auth/refresh-permission", {
                headers: {
                    'Authorization': 'Bearer {{ auth()->user()?->token() ?? '' }}',
                    'Accept': 'application/json'
                }
            })

            .then(response => response.json())
            .then(data => {
                console.log('Permission refreshed:', data);
            })
            .catch(error => {
                console.error('Failed to refresh permission:', error);
            });
    });
</script>
@stack('js')

</html>
