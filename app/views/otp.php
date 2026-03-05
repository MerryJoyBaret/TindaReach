<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>OTP Verification</title>
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<div class="container">
	<h2>Enter OTP</h2>
	<?php if(!empty($error)): ?>
		<p class="error"><?=htmlspecialchars($error)?></p>
	<?php endif; ?>
	<form method="post" action="index.php?action=verifyOTP">
		<div>
			<label>OTP Code</label><br>
			<input type="text" name="otp" pattern="\d{6}" required>
		</div>
		<button type="submit">Verify OTP</button>
	</form>
	</div>
</body>
</html>
