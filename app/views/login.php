<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TindaReach Login</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="/TindaReach_Current/public/css/bootstrap-custom.css">
	<link rel="stylesheet" href="/TindaReach_Current/public/css/style.css?v=20260324">
</head>
<body class="auth-page bg-light">
	<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
		<div class="row w-100 g-0">
			<div class="col-lg-5">
				<div class="brand-panel h-100 d-flex flex-column justify-content-center align-items-center text-white p-4">
					<div class="brand-panel-logo bg-white bg-opacity-20 border border-white border-opacity-35 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px;">
						<span class="fw-bold">TR</span>
					</div>
					<h1 class="h3 mb-2">Welcome to TindaReach</h1>
					<p class="mb-3 opacity-75">Connecting tindas and suppliers</p>
					<div class="brand-icons d-flex flex-column gap-2">
						<span><i class="bi bi-shop me-2"></i>Store</span>
						<span><i class="bi bi-handshake me-2"></i>Partnership</span>
						<span><i class="bi bi-box-seam me-2"></i>Supplies</span>
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="form-panel p-4 p-lg-5 bg-white h-100 d-flex flex-column justify-content-center">
			<h2 class="form-title h2 mb-2">Welcome Back</h2>
			<p class="form-subtitle text-muted mb-4">Sign in to continue managing your store network.</p>

			<?php if(!empty($message)): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?=htmlspecialchars($message)?>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			<?php endif; ?>
			<?php if(!empty($error)): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?=htmlspecialchars($error)?>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			<?php endif; ?>

			<form method="post" action="index.php?action=login" data-auth-form novalidate class="needs-validation" novalidate>
				<div class="mb-3">
					<label for="email" class="form-label fw-semibold">Email or Username</label>
					<div class="input-group">
						<span class="input-group-text"><i class="bi bi-person"></i></span>
						<input id="email" type="text" name="email" placeholder="you@business.com" class="form-control" required>
					</div>
					<div class="invalid-feedback" data-error-for="email"></div>
				</div>

				<div class="mb-3">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<label for="password" class="form-label fw-semibold mb-0">Password</label>
						<a class="text-decoration-none small" href="#">Forgot Password?</a>
					</div>
					<div class="input-group">
						<span class="input-group-text"><i class="bi bi-lock"></i></span>
						<input id="password" type="password" name="password" placeholder="Enter your password" class="form-control" required>
						<button type="button" class="btn btn-outline-secondary" data-toggle-password="password" aria-label="Show password">
							<i class="bi bi-eye"></i>
						</button>
					</div>
					<div class="invalid-feedback" data-error-for="password"></div>
				</div>

				<button class="btn btn-primary btn-lg w-100 fw-bold" type="submit" data-loading-button data-loading-label="Logging in...">Login</button>
		</form>

			<div class="text-center my-4">
				<span class="text-muted">or continue with</span>
			</div>
			<div class="d-grid gap-2">
				<a class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2" href="index.php?action=google_login">
					<i class="bi bi-google"></i> Google
				</a>
			</div>

			<div class="text-center mt-4">
				<span class="text-muted">New to TindaReach?</span>
				<a href="index.php?action=register" class="text-decoration-none fw-bold ms-1" data-fade-link>Create Account</a>
			</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Bootstrap JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/TindaReach_Current/public/js/auth.js?v=20260324"></script>
</body>
</html>
