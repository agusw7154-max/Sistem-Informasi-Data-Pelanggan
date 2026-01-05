<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 2rem 1rem;
            }
            .login-header {
                color: white;
                text-align: center;
                margin-bottom: 2rem;
            }
            .login-header h1 {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
                font-weight: bold;
            }
            .login-header p {
                margin: 0;
                font-size: 1rem;
                opacity: 0.9;
            }
            .login-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 15px 50px rgba(0,0,0,0.3);
                padding: 2.5rem;
                max-width: 450px;
                width: 100%;
            }
            .form-control {
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 0.75rem;
                font-size: 0.95rem;
            }
            .form-control:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }
            .form-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 0.5rem;
            }
            .btn-login {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 0.8rem;
                font-weight: 600;
                transition: all 0.3s;
                color: white;
                border-radius: 6px;
            }
            .btn-login:hover {
                background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
                transform: translateY(-2px);
                box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
                color: white;
            }
            .form-check-input:checked {
                background-color: #667eea;
                border-color: #667eea;
            }
            .form-check-input:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            }
            .form-link {
                color: #667eea;
                text-decoration: none;
                font-size: 0.9rem;
            }
            .form-link:hover {
                color: #764ba2;
                text-decoration: underline;
            }
            .divider {
                text-align: center;
                margin: 1.5rem 0;
                position: relative;
            }
            .divider::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                width: 100%;
                height: 1px;
                background: #ddd;
            }
            .divider span {
                position: relative;
                background: white;
                padding: 0 1rem;
                color: #999;
                font-size: 0.9rem;
            }
            .btn-outline-primary {
                color: #667eea;
                border-color: #667eea;
                border-radius: 6px;
                padding: 0.75rem;
                font-weight: 600;
            }
            .btn-outline-primary:hover {
                background-color: #667eea;
                border-color: #667eea;
                color: white;
            }
            .alert {
                border-radius: 6px;
                margin-bottom: 1.5rem;
            }
            @media (max-width: 768px) {
                .login-container {
                    padding: 2rem;
                }
                .login-header h1 {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-header">
            <h1>{{ config('app.name', 'Laravel') }}</h1>
            <p>Sistem Informasi Data Pelanggan</p>
        </div>
        
        <div class="login-container">
            {{ $slot }}
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
