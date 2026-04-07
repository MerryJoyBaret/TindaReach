<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TindaReach - Choose Your Role</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="/TindaReach_Current/public/css/bootstrap-custom.css">
	<link rel="stylesheet" href="/TindaReach_Current/public/css/style.css">
</head>
<body class="bg-light min-vh-100 position-relative">
	<!-- Top Right Logout Button -->
	<div class="position-absolute top-0 end-0 p-3">
		<?php if(!empty($user)): ?>
			<div class="d-flex align-items-center">
				<span class="me-2 text-muted">
					<i class="bi bi-person-circle me-1"></i>
					<?=htmlspecialchars($user['fullname'])?>
				</span>
				<a class="btn btn-outline-secondary btn-sm" href="index.php?action=logout">
					<i class="bi bi-box-arrow-right me-1"></i>Logout
				</a>
			</div>
		<?php else: ?>
			<div class="d-flex gap-2">
				<a class="btn btn-outline-primary btn-sm" href="index.php?action=login">
					<i class="bi bi-box-arrow-in-right me-1"></i>Login
				</a>
				<a class="btn btn-primary btn-sm" href="index.php?action=register">
					<i class="bi bi-person-plus me-1"></i>Register
				</a>
			</div>
		<?php endif; ?>
	</div>

	<!-- Welcome Section -->
	<section class="py-3">
		<div class="container text-center">
			<h1 class="display-5 fw-bold mb-2">Welcome to TindaReach</h1>
			<p class="lead text-muted mb-3">Connecting suppliers and sari-sari stores for a better business ecosystem</p>
			<?php if(!empty($message)): ?>
				<div class="alert alert-success alert-dismissible fade show d-inline-block" role="alert">
					<?=htmlspecialchars($message)?>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<!-- Role Selection Section -->
	<section class="pb-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9">
					<div class="text-center mb-4">
						<h2 class="h2 fw-bold mb-2">Choose Your Role</h2>
						<p class="text-muted mb-3">Select how you want to participate in the TindaReach ecosystem</p>
					</div>

					<div class="row g-3">
						<!-- Supplier Card -->
						<div class="col-md-6">
							<div class="card h-100 border-0 shadow-sm hover-lift transition-all duration-300">
								<div class="card-body p-3 text-center">
									<div class="mb-3">
										<div class="icon-box bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
											<i class="bi bi-truck fs-4"></i>
										</div>
									</div>
									<h3 class="card-title h5 fw-bold mb-2">Supplier</h3>
									<p class="card-text text-muted small mb-3">
										Connect with thousands of sari-sari stores and expand your distribution network.
									</p>
									<ul class="list-unstyled text-start mb-3 small">
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Reach more stores</li>
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Manage inventory</li>
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Track orders</li>
									</ul>
									<a href="index.php?action=supplier_dashboard" class="btn btn-primary w-100">
										<i class="bi bi-arrow-right-circle me-1"></i>Continue as Supplier
									</a>
								</div>
							</div>
						</div>

						<!-- Sari-Sari Store Owner Card -->
						<div class="col-md-6">
							<div class="card h-100 border-0 shadow-sm hover-lift transition-all duration-300">
								<div class="card-body p-3 text-center">
									<div class="mb-3">
										<div class="icon-box bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
											<i class="bi bi-shop fs-4"></i>
										</div>
									</div>
									<h3 class="card-title h5 fw-bold mb-2">Sari-Sari Store Owner</h3>
									<p class="card-text text-muted small mb-3">
										Source products from trusted suppliers and streamline your operations.
									</p>
									<ul class="list-unstyled text-start mb-3 small">
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Find suppliers</li>
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Order products</li>
										<li class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Track deliveries</li>
									</ul>
									<a href="index.php?action=store_dashboard" class="btn btn-success w-100">
										<i class="bi bi-arrow-right-circle me-1"></i>Continue as Store Owner
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Features Section -->
	<section class="py-5 bg-white">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-4 mb-4">
					<div class="feature-box">
						<i class="bi bi-shield-check text-primary fs-1 mb-3"></i>
						<h4 class="fw-bold mb-3">Verified Suppliers</h4>
						<p class="text-muted">All suppliers are verified and rated by the community for your peace of mind.</p>
					</div>
				</div>
				<div class="col-lg-4 mb-4">
					<div class="feature-box">
						<i class="bi bi-lightning-charge text-warning fs-1 mb-3"></i>
						<h4 class="fw-bold mb-3">Fast Delivery</h4>
						<p class="text-muted">Quick and reliable delivery tracking from supplier to your doorstep.</p>
					</div>
				</div>
				<div class="col-lg-4 mb-4">
					<div class="feature-box">
						<i class="bi bi-graph-up text-success fs-1 mb-3"></i>
						<h4 class="fw-bold mb-3">Business Growth</h4>
						<p class="text-muted">Analytics and insights to help you grow your business efficiently.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg-dark text-white py-4 mt-5">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h5 class="fw-bold mb-3">TindaReach</h5>
					<p class="text-muted">Empowering local businesses through technology</p>
				</div>
				<div class="col-md-6 text-md-end">
					<p class="text-muted mb-0">&copy; 2024 TindaReach. All rights reserved.</p>
				</div>
			</div>
		</div>
	</footer>

	<!-- Bootstrap JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
