<?php
session_start();
require_once 'app/controllers/AuthController.php';

$action = $_GET['action'] ?? 'login';

$controller = new AuthController();

switch($action){
    case 'register':
        $controller->register();
        break;
    case 'verify':
        $controller->verify();
        break;
    case 'login':
        $controller->login();
        break;
    case 'otp':
        $controller->otp();
        break;
    case 'verifyOTP':
        $controller->verifyOTP();
        break;
    case 'google_login':
        $controller->googleLogin();
        break;
    case 'google_callback':
        $controller->googleCallback();
        break;
    case 'home':
        $controller->home();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->login();
}