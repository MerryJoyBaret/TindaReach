<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<div class="container">
	<h2>Login</h2>
	<?php if(!empty($message)): ?>
		<p class="success"><?=htmlspecialchars($message)?></p>
	<?php endif; ?>
	<?php if(!empty($error)): ?>
		<p class="error"><?=htmlspecialchars($error)?></p>
	<?php endif; ?>
	<form method="post" action="index.php?action=login">
		<div>
			<label>Email</label><br>
			<input type="email" name="email" required>
		</div>
		<div>
			<label>Password</label><br>
			<input type="password" name="password" required>
		</div>
		<button type="submit">Login</button>
	</form>
	
	<div style="margin: 20px 0; text-align: center;">
		<p>or</p>
		<a href="index.php?action=google_login" style="display: inline-block; background: #4285f4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif;">
			Sign in with Google
		</a>
	</div>
	
	<p>Don't have an account? <a href="index.php?action=register">Register</a></p>
	</div>
</body>
</html>
