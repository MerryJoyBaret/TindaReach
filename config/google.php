<?php

require_once 'vendor/autoload.php';

// Google API configuration
return [
    'google' => [
        'client_id' => 'YOUR_GOOGLE_CLIENT_ID',
        'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
        'redirect_uri' => 'http://localhost/CC106_MIDTERM/index.php?action=google_callback',
        'scopes' => [
            'https://www.googleapis.com/auth/userinfo.email',  
            'https://www.googleapis.com/auth/userinfo.profile'
        ]
    ]
];
