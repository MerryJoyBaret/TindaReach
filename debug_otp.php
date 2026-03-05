<?php
require_once 'app/models/user.php';
require_once 'core/model.php';

$userModel = new User();

echo "=== Testing OTP System ===\n";

// Check if there are any OTP codes in the database
try {
    $stmt = $userModel->db->query("SELECT * FROM otp_codes ORDER BY created_at DESC LIMIT 5");
    $otpCodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Recent OTP codes in database:\n";
    foreach ($otpCodes as $otp) {
        echo "ID: {$otp['id']}, User ID: {$otp['user_id']}, Code: {$otp['otp_code']}, Expires: {$otp['expires_at']}, Created: {$otp['created_at']}\n";
        echo "  Is expired? " . (strtotime($otp['expires_at']) < time() ? "YES" : "NO") . "\n";
        echo "  Time until expiry: " . (strtotime($otp['expires_at']) - time()) . " seconds\n\n";
    }

    if (empty($otpCodes)) {
        echo "No OTP codes found in database.\n";
    }
} catch (Exception $e) {
    echo "Error accessing database: " . $e->getMessage() . "\n";
}

// Test current time
echo "Current server time: " . date('Y-m-d H:i:s') . "\n";
echo "Current timestamp: " . time() . "\n";

// Test manual OTP verification
echo "\n=== Manual OTP Test ===\n";
if (!empty($otpCodes)) {
    $latestOtp = $otpCodes[0];
    echo "Testing verification with latest OTP:\n";
    echo "User ID: {$latestOtp['user_id']}, OTP: {$latestOtp['otp_code']}\n";
    
    $result = $userModel->verifyOTP($latestOtp['user_id'], $latestOtp['otp_code']);
    echo "Verification result: " . ($result ? "SUCCESS" : "FAILED") . "\n";
}
?>
