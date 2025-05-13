<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="bg-light">

    <!-- Page content -->
    <div class="page-content">

        <!-- Content wrapper -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center min-vh-100">

                    <!-- Login form -->
                    <form class="login-form" action="{{ route('auth.login') }}" method="POST">
                        @csrf

                        <div class="card shadow-lg border-0 rounded-4" style="min-width: 360px; max-width: 420px; width: 100%;">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('template/assets/images/logo_icon.png') }}" class="h-48px mb-2" alt="">
                                    <h3 class="fw-semibold mb-0">Login</h3>
                                    <small class="text-muted">Enter your credentials below</small>
                                </div>

                                <!-- Global login error -->
                                @if ($errors->has('login_error'))
                                    <div class="alert alert-danger text-center">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                @endif

                                <!-- Username -->
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-3 @error('name') is-invalid @enderror" placeholder="Masukkan Username.." required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start position-relative">
                                        <input type="password" name="password" id="passwordInput" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="•••••••••••" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                        <button type="button" onclick="togglePassword()" class="position-absolute end-0 top-50 translate-middle-y me-3 p-0 bg-transparent border-0" style="z-index: 10;">
                                            <i id="toggleIcon" class="ph-eye text-muted fs-5"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback d-block mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remember me -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                <!-- Submit -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                                        Login
                                    </button>
                                </div>
                                 <!-- Optional: Link to Register / Forgot Password -->
                                 <div class="text-center">
                                    <a  class="text-muted">Forgot your password?</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /Login form -->

                </div>
                <!-- /Content area -->

            </div>
            <!-- /Inner content -->

        </div>
        <!-- /Content wrapper -->

    </div>
    <!-- /Page content -->
    <!-- Demo config -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
		<div class="position-absolute top-50 end-100 visible">
			<button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0" data-bs-toggle="offcanvas" data-bs-target="#demo_config">
				<i class="ph-gear"></i>
			</button>
		</div>

		<div class="offcanvas-header border-bottom py-0">
			<h5 class="offcanvas-title py-3">Demo configuration</h5>
			<button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div>

		<div class="offcanvas-body">
			<div class="fw-semibold mb-2">Color mode</div>
			<div class="list-group mb-3">
				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-sun ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Light theme</span>
								<div class="fs-sm text-muted">Set light theme or reset to default</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="light" checked>
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-moon ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Dark theme</span>
								<div class="fs-sm text-muted">Switch to dark theme</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="dark">
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-translate ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Auto theme</span>
								<div class="fs-sm text-muted">Set theme based on system mode</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="auto">
					</div>
				</label>
			</div>


	</div>
	<!-- /demo config -->

    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ph-eye', 'ph-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('ph-eye-slash', 'ph-eye');
            }
        }
    </script>

</body>

</html>
