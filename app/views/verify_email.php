<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Email Verification</title>
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<div class="container">
	<h2>Email Verification</h2>
	<?php if(!empty($message)): ?>
		<p class="success"><?=htmlspecialchars($message)?></p>
	<?php endif; ?>
	<?php if(!empty($error)): ?>
		<p class="error"><?=htmlspecialchars($error)?></p>
	<?php endif; ?>
	<p><a href="index.php?action=login">Go to Login</a></p>
	</div>
</body>
</html>
