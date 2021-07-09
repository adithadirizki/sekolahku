<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
	<meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
	<meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
	<meta name="author" content="PIXINVENT">
	<title>Login Page - Vuexy - Bootstrap HTML admin template</title>
	<link rel="apple-touch-icon" href="<?= base_url('app-assets/images/ico/apple-icon-120.png') ?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets/images/ico/favicon.ico') ?>">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

	<!-- BEGIN: Vendor CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/vendors.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>">
	<!-- END: Vendor CSS-->

	<!-- BEGIN: Theme CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.css') ?>">

	<!-- BEGIN: Page CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/pages/page-auth.css') ?>">
	<!-- END: Page CSS-->

	<!-- BEGIN: Custom CSS-->
	<!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
	<!-- BEGIN: Content-->
	<div class="app-content content ">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<div class="auth-wrapper auth-v1 px-2">
					<div class="auth-inner py-2">
						<!-- Login v1 -->
						<div class="card mb-0">
							<div class="card-body">

								<h4 class="card-title mb-1">Welcome to SEKOLAH-KU!</h4>
								<p class="card-text mb-2">Please sign-in to your account and start the adventure</p>

								<form id="login" class="auth-login-form mt-2" enctype="multipart/form-data" onsubmit="return false;">
									<div class="form-group">
										<label for="username" class="form-label">Username</label>
										<input type="text" class="form-control" id="username" name="username" required autofocus />
									</div>
									<div class="form-group">
										<label for="password">Password</label>
										<div class="input-group input-group-merge form-password-toggle">
											<input type="password" class="form-control form-control-merge" id="password" name="password" required />
											<div class="input-group-append">
												<span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input class="custom-control-input" name="remember_me" type="checkbox" id="remember_me" />
											<label class="custom-control-label" for="remember_me"> Remember Me </label>
										</div>
									</div>
									<div class="form-group text-right">
										<a href="page-auth-forgot-password-v1.html">
											<span>Forgot Password?</span>
										</a>
									</div>
									<button type="submit" class="btn btn-primary btn-block">Sign in</button>
								</form>
							</div>
						</div>
						<!-- /Login v1 -->
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- END: Content-->


	<!-- BEGIN: Vendor JS-->
	<script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
	<script src="<?= base_url('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>"></script>
	<!-- BEGIN Vendor JS-->

	<!-- BEGIN: Theme JS-->
	<script src="<?= base_url('app-assets/js/core/app-menu.js') ?>"></script>
	<script src="<?= base_url('app-assets/js/core/app.js') ?>"></script>
	<!-- END: Theme JS-->

	<script>
		$(window).on('load', function() {
			if (feather) {
				feather.replace({
					width: 14,
					height: 14
				});
			}
		})
	</script>
	<script>
		$(document).ready(function() {
			$(document).on('submit', '#login', function(e) {
				e.preventDefault();
				var data = $(this).serialize();
				$.ajax({
					url: "<?= base_url('api/auth/login') ?>",
					type: "post",
					dataType: "json",
					data: data,
					beforeSend: function() {
						$('.blockUI').show();
					},
					success: function(result) {
						$('.blockUI').hide();
						if (result.error === false) {
							Swal.fire({
								title: "Login successfully!",
								text: result.message,
								icon: "success",
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								window.location.href = "<?= base_url('dashboard') ?>";
							})
						} else if (result.error === true) {
							Swal.fire({
								title: "Login failed.",
								text: result.message,
								icon: "error",
								showConfirmButton: false,
								timer: 3000
							})
						}
					},
					error: function() {
						$('.blockUI').hide();
					}
				})
			})
		})
	</script>
</body>
<!-- END: Body-->

</html>