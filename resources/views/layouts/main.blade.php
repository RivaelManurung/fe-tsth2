<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Responsive Scan Stylesheets-->
    <link href="{{ asset('template/assets/css/style.css') }}" rel="stylesheet" type="text/css">
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
    <script src="{{ asset('template/assets/js/vendor/notifications/noty.min.js') }}"></script>
    {{-- <script src="{{asset('template/assets/demo/pages/extra_sweetalert.js')}}"></script> --}}
    <script src="{{ asset('template/assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/datatables_extension_buttons_html5.js') }}"></script>

    <link href="{{ asset('template/assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/datatables_extension_key_table.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/tables/datatables/extensions/key_table.min.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/fullcalendar_styling.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.3/dist/parsley.min.js"></script>

    {{-- font awesome  --}}
    <link href="{{ asset('template/assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">

    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        scanner.addListener('scan', function(content) {
            document.getElementById('qrcode-result').value = content;
            alert("QR Code Terdeteksi: " + content);
        });

        document.getElementById('scan-btn').addEventListener('click', function() {
            document.getElementById('scanner-container').style.display = 'flex';

            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]); // Gunakan kamera pertama
                } else {
                    alert('Tidak ada kamera yang ditemukan.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        });

        document.getElementById('close-btn').addEventListener('click', function() {
            document.getElementById('scanner-container').style.display = 'none';
            scanner.stop(); // Matikan kamera saat ditutup
        });

        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="barang_gambar"]');
            const base64Input = document.querySelector('input[name="barang_gambar_base64"]');
            const form = document.querySelector('#modalCreateBarang form');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // e.target.result is the base64 string (including the data:image part)
                        base64Input.value = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    base64Input.value = '';
                }
            });

            form.addEventListener('submit', function(e) {
                const file = fileInput.files[0];
                if (file && !base64Input.value) {
                    e.preventDefault(); // cancel submit
                    alert('Mohon tunggu, gambar masih diproses...');
                }
            });
        });
    </script>
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
                        // Jika pilih Yes, kirimkan form logout
                        document.querySelector('#logoutForm').submit(); // Form logout akan disubmit
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelled',
                            'You are still logged in.',
                            'error'
                        );
                    }
                });
            });
        }
    </script>
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

                <!-- Tombol Scan -->
                <button id="scan-btn" class="btn btn-primary d-flex  btn-position btn-circle">
                    <i class="ph-scan ph-2x rounded"></i>
                </button>

                <!-- Container Scanner -->
                <div id="scanner-container" style="display: none;">
                    <button id="close-btn">✖</button>
                    <video id="preview"></video>
                    <input type="text" id="qrcode-result" class="form-control mt-2" readonly>
                </div>

                <!-- Footer -->
                @include('layouts.footer')
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Notifications -->
    @include('components.notifications')

    <!-- /notifications -->


    <!-- Demo config -->
    @include('components.demo_config')

    <!-- /demo config -->

</body>

</html>
