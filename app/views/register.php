<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TindaReach Register</title>
    <link rel="stylesheet" href="/TindaReach_Current/public/css/style.css?v=20260324">
</head>
<body class="auth-page">
	<div class="auth-shell">
		<div class="brand-panel">
			<div class="brand-panel-logo">TR</div>
			<h1>Welcome to TindaReach</h1>
			<p>Connecting tindas and suppliers</p>
			<div class="brand-icons">
				<span>🏪 Store</span>
				<span>🤝 Partnership</span>
				<span>📦 Supplies</span>
			</div>
		</div>

		<div class="form-panel">
		<h2 class="form-title">Create your account</h2>
		<p class="form-subtitle">Join TindaReach and grow local business partnerships.</p>

		<?php if(!empty($error)): ?>
			<p class="flash flash-error"><?=htmlspecialchars($error)?></p>
		<?php endif; ?>

		<form method="post" action="index.php?action=register" data-auth-form novalidate>
			<div class="form-group">
				<label for="fullname">Full Name</label>
				<div class="input-wrap">
					<span class="input-icon">👤</span>
					<input id="fullname" type="text" name="fullname" placeholder="Juan Dela Cruz" required>
				</div>
				<p class="hint field-error" data-error-for="fullname"></p>
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<div class="input-wrap">
					<span class="input-icon">✉</span>
					<input id="email" type="email" name="email" placeholder="you@business.com" required>
				</div>
				<p class="hint field-error" data-error-for="email"></p>
			</div>

			<div class="form-group">
				<label for="business_name">Business Name <span class="brand-subtitle">(optional)</span></label>
				<input id="business_name" type="text" name="business_name" placeholder="Sample Tinda / Supplier Name">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<div class="password-wrap">
					<span class="input-icon">🔒</span>
					<input id="password" type="password" name="password" placeholder="Create a secure password" required>
					<button type="button" class="toggle-password" data-toggle-password="password" aria-label="Show password">👁</button>
				</div>
				<p class="hint field-error" data-error-for="password"></p>
				<div class="strength-meter">
					<div class="strength-fill" data-strength-fill></div>
				</div>
				<p class="hint" data-strength-hint>Use 8+ chars, letters, numbers, and symbols.</p>
			</div>

			<div class="form-group">
				<label for="confirm_password">Confirm Password</label>
				<div class="password-wrap">
					<span class="input-icon">🔒</span>
					<input id="confirm_password" type="password" name="confirm_password" placeholder="Re-enter your password" required>
					<button type="button" class="toggle-password" data-toggle-password="confirm_password" aria-label="Show password">👁</button>
				</div>
				<p class="hint field-error" data-error-for="confirm_password"></p>
			</div>

			<div class="form-group terms-row">
				<label class="checkbox-label">
					<input type="checkbox" name="terms" required>
					<span>I agree to the Terms &amp; Conditions</span>
				</label>
				<p class="hint field-error" data-error-for="terms"></p>
			</div>

			<div class="dual-actions">
				<button class="btn-primary" type="submit" data-loading-button data-loading-label="Signing up...">Sign Up</button>
				<a class="btn-outline" href="index.php?action=login" data-fade-link>Sign In</a>
			</div>
		</form>

		<p class="auth-footer">
			Already have an account?
			<a href="index.php?action=login" data-fade-link>Login</a>
		</p>
		</div>
	</div>
	<script src="/TindaReach_Current/public/js/auth.js?v=20260324"></script>
</body>
</html>
