<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel')) - Sistem Informasi Data Pelanggan</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            :root {
                --primary-color: #007bff;
                --secondary-color: #6c757d;
                --success-color: #28a745;
                --danger-color: #dc3545;
                --warning-color: #ffc107;
                --info-color: #17a2b8;
            }

            * {
                margin: 0;
                padding: 0;
            }

            html, body {
                height: 100%;
            }

            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                min-height: 100vh;
            }

            .navbar {
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .navbar-brand {
                font-weight: 700;
                font-size: 1.4rem;
                letter-spacing: 0.5px;
            }

            .nav-link {
                margin: 0 8px;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .nav-link:hover,
            .nav-link.active {
                color: #ffc107 !important;
                border-bottom: 2px solid #ffc107;
                padding-bottom: 2px;
            }

            main {
                padding: 2rem 0;
                min-height: calc(100vh - 100px);
            }

            .page-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 2rem;
                border-radius: 8px;
                margin-bottom: 2rem;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            }

            .page-header h1 {
                margin: 0;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .card {
                border: none;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border-radius: 12px;
                transition: all 0.3s ease;
                margin-bottom: 1.5rem;
            }

            .card:hover {
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                transform: translateY(-2px);
            }

            .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 12px 12px 0 0 !important;
                padding: 1.25rem;
                font-weight: 600;
            }

            .card-body {
                padding: 1.5rem;
            }

            .table {
                background-color: white;
                margin-bottom: 0;
            }

            .table thead {
                background-color: #f8f9fa;
                font-weight: 600;
                color: #495057;
            }

            .table tbody tr {
                transition: all 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: #f8f9fa;
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 8px;
                padding: 0.6rem 1.2rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }

            .btn-secondary {
                background-color: #6c757d;
                border: none;
                border-radius: 8px;
                padding: 0.6rem 1.2rem;
                font-weight: 600;
            }

            .btn-success {
                background-color: #28a745;
                border: none;
                border-radius: 8px;
            }

            .btn-danger {
                background-color: #dc3545;
                border: none;
                border-radius: 8px;
            }

            .btn-group-action {
                display: flex;
                gap: 0.5rem;
            }

            .stat-card {
                border-left: 5px solid;
                padding: 1.5rem;
                margin-bottom: 1rem;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }

            .stat-card.primary {
                border-left-color: #007bff;
            }

            .stat-card.success {
                border-left-color: #28a745;
            }

            .stat-card.info {
                border-left-color: #17a2b8;
            }

            .stat-card.warning {
                border-left-color: #ffc107;
            }

            .stat-card h6 {
                color: #6c757d;
                font-weight: 500;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
            }

            .stat-card .stat-value {
                font-size: 2rem;
                font-weight: 700;
                color: #333;
            }

            .badge {
                padding: 0.5rem 0.75rem;
                border-radius: 6px;
                font-weight: 600;
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                border: 1px solid #dee2e6;
                padding: 0.7rem;
                font-size: 0.95rem;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }

            .alert {
                border-radius: 8px;
                border: none;
                margin-bottom: 1.5rem;
            }

            .container-fluid {
                padding: 0 1.5rem;
            }

            @media (max-width: 768px) {
                .page-header {
                    margin-bottom: 1.5rem;
                    padding: 1.5rem;
                }

                .page-header h1 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        @include('layouts.navigation')

        <main>
            <div class="container-fluid">
                {{-- Support both classic @section('content') and Blade component slots ($slot / $header) --}}
                @isset($header)
                    <div class="page-header">
                        {{ $header }}
                    </div>
                @endisset

                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    </body>
</html>
