<?php
require_once __DIR__ . '/../../core/controller.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../lib/GoogleOAuth.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AuthController extends Controller {

    private function sendEmail($to, $subject, $body) {
        $config = require __DIR__ . '/../../config/email.php';
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host = $config['email']['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['email']['smtp_username'];
            $mail->Password = $config['email']['smtp_password'];
            $mail->SMTPSecure = $config['email']['encryption'] === 'smtps' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['email']['smtp_port'];
            
            $mail->setFrom($config['email']['from_email'], $config['email']['from_name']);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            return $mail->send();
        } catch (Exception $e) {
            error_log("Email failed to send: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if(empty($fullname) || empty($email) || empty($password)) {
                $this->view('register', ['error' => 'All fields are required.']);
                return;
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('register', ['error' => 'Invalid email address.']);
                return;
            }

            $userModel = new User();
            if($userModel->findByEmail($email)){
                $this->view('register', ['error' => 'Email already registered.']);
                return;
            }

            $userModel->register($fullname, $email, $password);

            $user = $userModel->findByEmail($email);

            $token = bin2hex(random_bytes(32));
            $userModel->saveToken($user['id'], $token);

            $host = $_SERVER['HTTP_HOST'];
            $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $verificationLink = "http://$host$path/index.php?action=verify&token=$token";

            // Send verification email using Gmail SMTP
            $subject = "Verify Your Email";
            $body = "Click to verify your account: $verificationLink";
            $this->sendEmail($email, $subject, $body);

            $this->view('verify_email', ['message' => 'Registration successful. Check your email for verification link.']);
        } else {
            $this->view('register');
        }
    }

    public function verify() {
        if(isset($_GET['token'])) {
            $token = $_GET['token'];
            $userModel = new User();
            if($userModel->verifyToken($token)) {
                // flash and redirect to login
                $_SESSION['message'] = 'Email verified successfully. Please login below.';
                header('Location: index.php?action=login');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid or expired token.';
                header('Location: index.php?action=login');
                exit;
            }
        } else {
            $_SESSION['error'] = 'No token provided.';
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if(empty($email) || empty($password)) {
                $this->view('login', ['error' => 'All fields are required.']);
                return;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if(!$user || !password_verify($password, $user['password'])) {
                $this->view('login', ['error' => 'Invalid credentials.']);
                return;
            }

            if(!$user['is_verified']){
                $this->view('login', ['error' => 'Please verify your email first.']);
                return;
            }

            // generate OTP (6 digits) and send to user's email
            $otp = random_int(100000, 999999);
            $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $userModel->saveOTP($user['id'], $otp, $expires);

            // Send OTP email using Gmail SMTP
            $subject = "Your OTP Code";
            $body = "Your OTP code is: $otp\nIt expires in 5 minutes.";
            $this->sendEmail($email, $subject, $body);

            $_SESSION['otp_user_id'] = $user['id'];
            $this->view('otp');
        } else {
            $data = [];
            if(!empty($_SESSION['message'])) {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if(!empty($_SESSION['error'])) {
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }
            $this->view('login', $data);
        }
    }

    public function otp() {
        // show OTP entry form
        $this->view('otp');
    }

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = trim($_POST['otp'] ?? '');
            $user_id = $_SESSION['otp_user_id'] ?? null;

            error_log("DEBUG: Controller verifyOTP - POST OTP: '$otp', Session user_id: '$user_id'");

            if(empty($otp) || !$user_id) {
                error_log("DEBUG: Invalid request - empty OTP or user_id");
                $this->view('otp', ['error' => 'Invalid request.']);
                return;
            }

            $userModel = new User();
            $result = $userModel->verifyOTP($user_id, $otp);

            error_log("DEBUG: User model verifyOTP returned: " . ($result ? 'true' : 'false'));

            if($result) {
                unset($_SESSION['otp_user_id']);
                $_SESSION['user_id'] = $user_id;
                header('Location: index.php?action=home');
                exit;
            } else {
                $this->view('otp', ['error' => 'Invalid or expired OTP.']);
            }
        } else {
            $this->view('otp');
        }
    }

    public function home() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);
        
        $data = ['user' => $user];
        
        // Pass success message if exists
        if(!empty($_SESSION['message'])) {
            $data['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        
        $this->view('home', $data);
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    public function googleLogin() {
        $config = require __DIR__ . '/../../config/google.php';
        
        $googleOAuth = new GoogleOAuth(
            $config['google']['client_id'],
            $config['google']['client_secret'],
            $config['google']['redirect_uri']
        );
        
        $authUrl = $googleOAuth->getAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }

    public function googleCallback() {
        $config = require __DIR__ . '/../../config/google.php';
        
        try {
            $googleOAuth = new GoogleOAuth(
                $config['google']['client_id'],
                $config['google']['client_secret'],
                $config['google']['redirect_uri']
            );
            
            if (isset($_GET['code'])) {
                // Get access token
                $tokenData = $googleOAuth->getAccessToken($_GET['code']);
                $accessToken = $tokenData['access_token'];
                
                // Get user info
                $userInfo = $googleOAuth->getUserInfo($accessToken);
                
                $email = $userInfo['email'];
                $fullname = $userInfo['name'];
                $googleId = $userInfo['id'];
                
                $userModel = new User();
                $user = $userModel->findByEmail($email);
                
                if ($user) {
                    // User exists, log them in
                    if (!$user['is_verified']) {
                        // Auto-verify Google users
                        $userModel->verifyGoogleUser($user['id']);
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['message'] = 'Successfully logged in with Google!';
                    header('Location: index.php?action=home');
                    exit;
                } else {
                    // Create new user
                    $randomPassword = bin2hex(random_bytes(16));
                    $userModel->register($fullname, $email, $randomPassword);
                    $newUser = $userModel->findByEmail($email);
                    $userModel->verifyGoogleUser($newUser['id']);
                    $_SESSION['user_id'] = $newUser['id'];
                    $_SESSION['message'] = 'Successfully registered and logged in with Google!';
                    header('Location: index.php?action=home');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Google authentication failed.';
                header('Location: index.php?action=login');
                exit;
            }
        } catch (Exception $e) {
            error_log("Google OAuth Error: " . $e->getMessage());
            $_SESSION['error'] = 'Google authentication failed. Please try again or use email login.';
            header('Location: index.php?action=login');
            exit;
        }
    }
}