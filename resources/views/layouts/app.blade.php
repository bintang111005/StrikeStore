<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StrikeStore') — StrikeStore</title>
    <meta name="description" content="@yield('meta_description', 'StrikeStore — Toko Perlengkapan Memancing Terlengkap')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --color-primary: #0ea5e9;
            --color-primary-dark: #0284c7;
            --color-primary-light: #38bdf8;
            --color-accent: #06b6d4;
            --color-surface: #0f172a;
            --color-surface-elevated: #1e293b;
            --color-surface-card: #1e293b;
            --color-border: #334155;
            --color-text: #f1f5f9;
            --color-text-muted: #94a3b8;
            --color-success: #22c55e;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --radius: 0.75rem;
            --font: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font);
            background: linear-gradient(135deg, #0c1222 0%, #0f172a 50%, #0c1426 100%);
            color: var(--color-text);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navigation */
        .nav-main {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 4rem;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
            color: var(--color-text);
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }
        .nav-brand svg {
            width: 2rem;
            height: 2rem;
        }
        .nav-brand span.highlight {
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-links {
            display: flex;
            gap: 0.25rem;
            list-style: none;
        }
        .nav-links a {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--color-text);
            background: rgba(255,255,255,0.05);
        }
        .nav-links a.active {
            background: rgba(14, 165, 233, 0.1);
            color: var(--color-primary-light);
        }

        /* Main Content */
        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .page-header h1 {
            font-size: 1.875rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            background: linear-gradient(135deg, var(--color-text), var(--color-text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .page-header p {
            color: var(--color-text-muted);
            font-size: 0.9375rem;
            margin-top: 0.25rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: var(--font);
            line-height: 1.5;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            color: white;
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.2);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary));
            box-shadow: 0 0 30px rgba(14, 165, 233, 0.35);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: var(--color-surface-elevated);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            transform: translateY(-1px);
        }
        .btn-warning {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            transform: translateY(-1px);
        }
        .btn-sm {
            padding: 0.375rem 0.875rem;
            font-size: 0.8125rem;
            border-radius: 0.5rem;
        }
        .btn-icon {
            width: 2.25rem;
            height: 2.25rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        /* Cards */
        .card {
            background: var(--color-surface-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .card:hover {
            border-color: rgba(14, 165, 233, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(14, 165, 233, 0.1);
        }
        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .table-container {
            background: var(--color-surface-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container thead {
            background: rgba(255,255,255,0.03);
        }
        .table-container th {
            padding: 0.875rem 1.25rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--color-border);
        }
        .table-container td {
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            border-bottom: 1px solid rgba(51, 65, 85, 0.3);
            vertical-align: middle;
        }
        .table-container tbody tr {
            transition: background 0.15s ease;
        }
        .table-container tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }
        .table-container tbody tr:last-child td {
            border-bottom: none;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.5rem;
        }
        .form-label .required {
            color: var(--color-danger);
            margin-left: 0.125rem;
        }
        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            color: var(--color-text);
            font-size: 0.875rem;
            font-family: var(--font);
            transition: all 0.2s ease;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }
        .form-control::placeholder {
            color: var(--color-text-muted);
            opacity: 0.6;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20' fill='%2394a3b8'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z'/%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }
        .form-hint {
            font-size: 0.8125rem;
            color: var(--color-text-muted);
            margin-top: 0.375rem;
        }
        .form-error {
            font-size: 0.8125rem;
            color: var(--color-danger);
            margin-top: 0.375rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        .badge-active {
            background: rgba(34, 197, 94, 0.12);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        .badge-inactive {
            background: rgba(148, 163, 184, 0.1);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }
        .badge-out-of-stock {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .badge-featured {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .badge-category {
            background: rgba(14, 165, 233, 0.1);
            color: var(--color-primary-light);
            border: 1px solid rgba(14, 165, 233, 0.2);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        /* Product image thumbnail */
        .product-thumb {
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            object-fit: cover;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--color-border);
        }
        .product-thumb-placeholder {
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
        }

        /* Price styling */
        .price {
            font-weight: 700;
            color: var(--color-primary-light);
            font-variant-numeric: tabular-nums;
        }
        .price-original {
            text-decoration: line-through;
            color: var(--color-text-muted);
            font-weight: 400;
            font-size: 0.8125rem;
        }

        /* Detail page */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
        }
        @media (max-width: 768px) {
            .detail-grid { grid-template-columns: 1fr; }
        }
        .detail-image {
            width: 100%;
            aspect-ratio: 1;
            border-radius: var(--radius);
            object-fit: cover;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--color-border);
        }
        .detail-image-placeholder {
            width: 100%;
            aspect-ratio: 1;
            border-radius: var(--radius);
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
        }
        .detail-meta {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .detail-meta dt {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        .detail-meta dd {
            font-size: 0.9375rem;
            color: var(--color-text);
        }
        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
        }
        .detail-info-item {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(51, 65, 85, 0.5);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        /* Actions group */
        .actions-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--color-surface-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.025em;
        }
        .stat-label {
            font-size: 0.8125rem;
            color: var(--color-text-muted);
        }

        /* Search & Filter bar */
        .filter-bar {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .filter-bar .form-control {
            max-width: 280px;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 1.25rem;
            border-top: 1px solid var(--color-border);
        }
        .pagination-wrapper nav { display: flex; gap: 0.25rem; }
        .pagination-wrapper a,
        .pagination-wrapper span {
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-muted);
            text-decoration: none;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }
        .pagination-wrapper a:hover {
            color: var(--color-text);
            background: rgba(255,255,255,0.05);
            border-color: var(--color-border);
        }
        .pagination-wrapper .active span {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        /* File upload */
        .file-upload {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed var(--color-border);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .file-upload:hover {
            border-color: var(--color-primary);
            background: rgba(14, 165, 233, 0.03);
        }
        .file-upload input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image preview */
        .image-preview {
            width: 100%;
            max-width: 200px;
            border-radius: var(--radius);
            margin-top: 0.75rem;
            border: 1px solid var(--color-border);
        }

        /* Checkbox & Toggle */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .form-check input[type="checkbox"] {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--color-border);
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        .form-check input[type="checkbox"]:checked {
            background: var(--color-primary);
            border-color: var(--color-primary);
        }
        .form-check input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 5px;
            height: 9px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--color-text-muted);
        }
        .empty-state svg {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            opacity: 0.3;
        }
        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.5rem;
        }

        /* Confirm delete modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal {
            background: var(--color-surface-elevated);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .modal h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .modal p {
            color: var(--color-text-muted);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .modal-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        /* Animations */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease;
        }
    </style>
</head>
<body>
    {{-- Navigation --}}
    <nav class="nav-main">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-brand">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="url(#brand-grad)"/>
                    <path d="M8 20C8 20 12 12 16 12C20 12 24 20 24 20" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="16" cy="18" r="2" fill="white"/>
                    <defs>
                        <linearGradient id="brand-grad" x1="0" y1="0" x2="32" y2="32">
                            <stop stop-color="#0ea5e9"/>
                            <stop offset="1" stop-color="#06b6d4"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>Strike<span class="highlight">Store</span></span>
            </a>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        Produk
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
