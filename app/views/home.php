<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<div class="container">
	<h2>Home</h2>
	<?php if(!empty($message)): ?>
		<p class="success"><?=htmlspecialchars($message)?></p>
	<?php endif; ?>
	<?php if(!empty($user)): ?>
		<p>Welcome, <?=htmlspecialchars($user['fullname'])?>! (<?=htmlspecialchars($user['email'])?>)</p>
	<?php else: ?>
		<p>Welcome!</p>
	<?php endif; ?>
	<p><a href="index.php?action=logout">Logout</a></p>
	</div>
</body>
</html>
