<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<div class="container">
	<h2>Register</h2>
	<?php if(!empty($error)): ?>
		<p class="error"><?=htmlspecialchars($error)?></p>
	<?php endif; ?>
	<form method="post" action="index.php?action=register">
		<div>
			<label>Full Name</label><br>
			<input type="text" name="fullname" required>
		</div>
		<div>
			<label>Email</label><br>
			<input type="email" name="email" required>
		</div>
		<div>
			<label>Password</label><br>
			<input type="password" name="password" required>
		</div>
		<button type="submit">Register</button>
	</form>
	<p>Already have an account? <a href="index.php?action=login">Login</a></p>
	</div>
</body>
</html>
