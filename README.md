# Authentication System with OTP and Google Sign-In

A secure PHP authentication system with email verification, OTP two-factor authentication, and Google OAuth integration.

## Features

- 🔐 **User Registration** with email verification
- 🔑 **Secure Login** with OTP two-factor authentication
- 📧 **Gmail SMTP** email delivery
- 🔍 **Google Sign-In** with custom OAuth implementation
- 👤 **User Profile** management
- 🛡️ **Session Security** with proper logout
- 📱 **Responsive Design** with modern UI

## Requirements

- PHP 8.0 or higher
- MySQL/MariaDB database
- XAMPP/WAMP/MAMP (for local development)
- Composer (for dependency management)
- Gmail account (for email sending)

## Quick Setup

### 1. Clone/Download the Project

```bash
git clone <repository-url>
cd CC106_MIDTERM
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Database Setup

Create a database and import the provided SQL structure:

```sql
CREATE DATABASE auth_system;
USE auth_system;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Email verification table
CREATE TABLE email_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- OTP codes table
CREATE TABLE otp_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp_code VARCHAR(10) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 4. Configuration

#### Database Configuration
Edit `core/database.php` with your database credentials:

```php
private $host = 'localhost';
private $db_name = 'auth_system';
private $username = 'root';
private $password = '';
```

#### Email Configuration
Edit `config/email.php` with your Gmail credentials:

```php
'email' => [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 465,
    'encryption' => 'smtps',
    'smtp_username' => 'your-gmail@gmail.com',
    'smtp_password' => 'your-app-password',
    'from_email' => 'your-gmail@gmail.com',
    'from_name' => 'Your App Name'
]
```

**Important**: Use an App Password for Gmail, not your regular password. [Create App Password here](https://myaccount.google.com/apppasswords)

#### Google OAuth Configuration (Optional)
Edit `config/google.php` with your Google OAuth credentials:

```php
'google' => [
    'client_id' => 'your-google-client-id.apps.googleusercontent.com',
    'client_secret' => 'your-google-client-secret',
    'redirect_uri' => 'http://localhost/CC106_MIDTERM/index.php?action=google_callback',
    'scopes' => [
        'https://www.googleapis.com/auth/userinfo.email',
        'https://www.googleapis.com/auth/userinfo.profile'
    ]
]
```

### 5. Google OAuth Setup (Optional)

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable APIs:
   - Google+ API (or People API)
   - Google OAuth2 API
4. Create OAuth 2.0 Client ID:
   - Go to "APIs & Services" → "Credentials"
   - Click "Create Credentials" → "OAuth 2.0 Client ID"
   - Select "Web application"
   - Add authorized redirect URI: `http://localhost/CC106_MIDTERM/index.php?action=google_callback`
   - Save and copy Client ID and Client Secret
5. Configure OAuth consent screen if prompted

### 6. Web Server Configuration

#### Using XAMPP
1. Place the project in `htdocs/CC106_MIDTERM/`
2. Start Apache and MySQL
3. Access via: `http://localhost/CC106_MIDTERM/`

#### Using Other Web Servers
Ensure the web root points to the project directory and configure URL rewriting if needed.

## Usage

### Registration Flow
1. User fills registration form
2. System sends verification email
3. User clicks verification link
4. Account is verified and ready for login

### Login Flow
1. User enters email and password
2. System generates and sends OTP via email
3. User enters OTP
4. If correct, user is logged in

### Google Sign-In Flow
1. User clicks "Sign in with Google"
2. Redirects to Google for authorization
3. Google redirects back with user data
4. User is logged in (existing) or registered (new)

## File Structure

```
CC106_MIDTERM/
├── app/
│   ├── controllers/
│   │   └── AuthController.php     # Main authentication logic
│   ├── models/
│   │   └── user.php               # User database operations
│   ├── views/
│   │   ├── home.php               # User dashboard
│   │   ├── login.php              # Login form
│   │   ├── register.php           # Registration form
│   │   ├── otp.php                # OTP verification form
│   │   └── verify_email.php       # Email verification message
│   └── lib/
│       └── GoogleOAuth.php        # Custom Google OAuth implementation
├── config/
│   ├── email.php                  # Email configuration
│   └── google.php                 # Google OAuth configuration
├── core/
│   ├── controller.php             # Base controller
│   ├── model.php                  # Base model
│   └── database.php               # Database connection
├── public/
│   └── css/
│       └── style.css              # Styling
├── vendor/                        # Composer dependencies
├── index.php                      # Main entry point
└── README.md                      # This file
```

## Security Features

- **Password Hashing**: Uses `password_hash()` with bcrypt
- **Email Verification**: Prevents fake email registrations
- **OTP Protection**: Two-factor authentication for login
- **Session Security**: Proper session management and logout
- **SQL Injection Protection**: Uses prepared statements
- **XSS Protection**: Output escaping with `htmlspecialchars()`
- **CSRF Protection**: Secure form handling

## Customization

### Adding New Authentication Methods
1. Create new method in `AuthController.php`
2. Add corresponding routes in `index.php`
3. Create necessary views in `app/views/`

### Modifying Email Templates
Edit the email content in `AuthController.php` methods:
- `register()` - Verification email
- `login()` - OTP email

### Styling
Modify `public/css/style.css` to customize the appearance.

## Troubleshooting

### Common Issues

#### Gmail SMTP Not Working
- Enable "Less secure app access" or use App Password
- Check SMTP credentials in `config/email.php`
- Ensure SSL/TLS is enabled in PHP

#### Google OAuth Not Working
- Verify redirect URI matches exactly in Google Console
- Check client ID and secret in `config/google.php`
- Ensure required APIs are enabled

#### Database Connection Issues
- Check database credentials in `core/database.php`
- Ensure MySQL/MariaDB is running
- Verify database and table names

#### OTP Not Working
- Check email delivery in spam folder
- Verify OTP expiration time (default: 5 minutes)
- Check database `otp_codes` table

### Debug Mode
Enable debug logging by checking error logs:
```bash
tail -f /var/log/apache2/error.log
# or XAMPP: /xampp/apache/logs/error.log
```

## Dependencies

- **PHPMailer**: For Gmail SMTP email sending
- **Custom GoogleOAuth**: Pure PHP cURL implementation (no external dependencies)

## License

This project is for educational purposes. Feel free to modify and use according to your needs.

## Support

For issues and questions:
1. Check the troubleshooting section
2. Review error logs
3. Verify configuration files
4. Test database connectivity

---

**Version**: 1.0  
**Last Updated**: 2025  
**PHP Version**: 8.0+  
**Database**: MySQL/MariaDB
