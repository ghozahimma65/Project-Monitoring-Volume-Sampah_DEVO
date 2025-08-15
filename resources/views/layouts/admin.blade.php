<?php

// resources/views/layouts/admin.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - DEVO')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('styles')
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #29356d 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            
            --primary-color: #2563eb;
            --primary-dark: #4b5275;
            --secondary-color: #f8fafc;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
            --light-color: #f1f5f9;
            
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
            --shadow-xl: 0 20px 50px rgba(0,0,0,0.15);
            
            --border-radius: 16px;
            --border-radius-lg: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Nunito Sans', sans-serif;
        }

        .heading-font {
            font-family: 'Space Grotesk', sans-serif;
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(21, 17, 255, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(48, 59, 126, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(42, 150, 189, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Modern Header Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Space Grotesk', sans-serif;
            text-decoration: none;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        /* Modern Sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modern-sidebar {
            position: fixed;
            top: 0;
            left: -400px;
            width: 400px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px) saturate(180%);
            box-shadow: var(--shadow-xl);
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-sidebar.show {
            left: 0;
        }

        .sidebar-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .sidebar-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .sidebar-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .sidebar-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar-subtitle {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .nav-menu-section {
            padding: 2rem 0;
        }

        .nav-menu-title {
            padding: 0 2rem 1rem 2rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }

        .nav-menu-item {
            display: flex;
            align-items: center;
            padding: 1.25rem 2rem;
            margin: 0.25rem 1rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--dark-color);
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .nav-menu-item:hover {
            color: white;
            transform: translateX(8px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        .nav-menu-item:hover::before {
            left: 0;
        }

        .nav-menu-item.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-md);
            transform: translateX(8px);
        }

        .nav-menu-item i {
            font-size: 1.25rem;
            margin-right: 1rem;
            width: 24px;
            text-align: center;
            transition: var(--transition);
        }

        .nav-menu-item:hover i {
            transform: scale(1.1);
        }

        .nav-menu-item .menu-text {
            flex: 1;
        }

        .nav-menu-item .menu-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .nav-menu-item .menu-desc {
            font-size: 0.8rem;
            opacity: 0.8;
            line-height: 1.3;
        }

        .nav-menu-item .badge {
            margin-left: auto;
            font-size: 0.7rem;
            animation: badgePulse 2s infinite;
        }

        @keyframes badgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            min-height: calc(100vh - 120px);
        }

        .content-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        /* Stats Cards */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .stats-card .icon {
            width: 72px;
            height: 72px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .stats-card.primary .icon { background: var(--primary-gradient); color: white; }
        .stats-card.success .icon { background: var(--success-gradient); color: white; }
        .stats-card.warning .icon { background: var(--warning-gradient); color: white; }
        .stats-card.danger .icon { background: var(--danger-gradient); color: white; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-sidebar {
                width: 320px;
                left: -320px;
            }

            .navbar-brand {
                font-size: 1.5rem;
            }

            .nav-menu-item {
                margin: 0.25rem 0.5rem;
                padding: 1rem 1.5rem;
            }

            .sidebar-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .modern-sidebar {
                width: 280px;
                left: -280px;
            }

            .nav-menu-item .menu-desc {
                display: none;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Modern Sidebar -->
    <div class="modern-sidebar" id="modern-sidebar">
        <div class="sidebar-header">
            <button class="sidebar-close" id="sidebar-close">
                <i class="fas fa-times"></i>
            </button>
            <h4 class="sidebar-brand">
                <i class="fas fa-recycle me-2"></i>DEVO
            </h4>
            <p class="sidebar-subtitle">{{ Auth::user()->name }}</p>
        </div>
        
        <div class="nav-menu-section">
            <div class="nav-menu-title">Menu Admin</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <div class="menu-text">
                    <div class="menu-title">Dashboard</div>
                    <div class="menu-desc">Monitoring dan statistik</div>
                </div>
            </a>
            
            <a href="{{ route('admin.depos.index') }}" class="nav-menu-item {{ request()->routeIs('admin.depos.*') ? 'active' : '' }}">
                <i class="fas fa-warehouse"></i>
                <div class="menu-text">
                    <div class="menu-title">Kelola Depo</div>
                    <div class="menu-desc">Manajemen data depo sampah</div>
                </div>
            </a>
            
            <a href="{{ route('admin.reports.index') }}" class="nav-menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="menu-text">
                    <div class="menu-title">Kelola Laporan</div>
                    <div class="menu-desc">Review dan tindak lanjut laporan</div>
                </div>
                <span id="report-notification" class="badge bg-danger d-none">0</span>
            </a>
        </div>

        <div class="nav-menu-section">
            <div class="nav-menu-title">Quick Actions</div>
            
            <a href="{{ route('dashboard') }}" class="nav-menu-item" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <div class="menu-text">
                    <div class="menu-title">Public Dashboard</div>
                    <div class="menu-desc">Lihat tampilan publik</div>
                </div>
            </a>
            
            <a href="#" class="nav-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <div class="menu-text">
                    <div class="menu-title">Logout</div>
                    <div class="menu-desc">Keluar dari sistem</div>
                </div>
            </a>
        </div>
        
        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Modern Header Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Menu Toggle -->
            <button class="btn me-3" id="menu-toggle" style="background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 0.75rem;">
                <i class="fas fa-bars" style="color: var(--dark-color);"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand heading-font" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-recycle me-2"></i>DEVO 
            </a>
            
            <!-- Header Actions -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="text-muted">{{ now()->format('d/m/Y') }}</span>
                
                {{-- TAMBAHKAN BLOK NOTIFIKASI DI SINI --}}
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative;">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" id="notification-count" style="display: none; font-size: 0.6em; padding: .35em .55em;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" style="width: 350px; border-radius: var(--border-radius);"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Pusat Notifikasi
                        </h6>
                        <div id="notification-list">
                            {{-- Diisi oleh JavaScript --}}
                        </div>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Tandai semua sudah dibaca</a>
                    </div>
                </div>
                {{-- AKHIR BLOK NOTIFIKASI --}}

                <!-- User Menu -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" style="background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.2); border-radius: 12px;" data-bs-toggle="dropdown">
                        <div class="me-2 d-flex align-items-center justify-content-center rounded-circle text-white" style="width: 32px; height: 32px; background: var(--primary-gradient);">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: var(--border-radius); backdrop-filter: blur(20px); background: rgba(255,255,255,0.95);">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Public Dashboard
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="content-header fade-in">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-muted mb-0">@yield('page-subtitle', 'Kelola sistem monitoring depo sampah')</p>
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius: var(--border-radius); backdrop-filter: blur(20px); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius: var(--border-radius); backdrop-filter: blur(20px); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Content -->
        <div class="fade-in">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin System -->
    <script>
        let isMenuOpen = false;



        
        // Initialize AOS
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: false
        });

        // WebSocket for admin
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });

        // Listen to admin notifications
        const adminChannel = pusher.subscribe('admin-notifications');
        adminChannel.bind('new_report', function(data) {
            updateReportBadge();
        });

        const adminDashboardChannel = pusher.subscribe('admin-dashboard');
        adminDashboardChannel.bind('critical_volume_alert', function(data) {
            showCriticalAlert(data);
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeMenuSystem();
            loadNotificationsCount();
        });

        // Menu System
        function initializeMenuSystem() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('modern-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebarClose = document.getElementById('sidebar-close');
            
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                openSidebar();
            });
            
            sidebarClose.addEventListener('click', function(e) {
                e.stopPropagation();
                closeSidebar();
            });
            
            sidebarOverlay.addEventListener('click', function() {
                closeSidebar();
            });
            
            // Close sidebar on escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeSidebar();
                }
            });
            
            // Close sidebar when clicking on menu items (for better UX)
            const menuItems = sidebar.querySelectorAll('.nav-menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    closeSidebar();
                });
            });
        }

        function openSidebar() {
            const sidebar = document.getElementById('modern-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const menuToggle = document.getElementById('menu-toggle');
            
            isMenuOpen = true;
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            menuToggle.innerHTML = '<i class="fas fa-times" style="color: var(--dark-color);"></i>';
            
            // Animate menu items with stagger
            const menuItems = sidebar.querySelectorAll('.nav-menu-item');
            menuItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-30px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 80 + 200);
            });
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('modern-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const menuToggle = document.getElementById('menu-toggle');
            
            isMenuOpen = false;
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            menuToggle.innerHTML = '<i class="fas fa-bars" style="color: var(--dark-color);"></i>';
            
            // Restore body scroll
            document.body.style.overflow = '';
        }

        function updateReportBadge() {
            const reportBadge = document.getElementById('report-notification');
            if (reportBadge) {
                reportBadge.classList.remove('d-none');
                reportBadge.textContent = parseInt(reportBadge.textContent) + 1;
            }
        }

        function showCriticalAlert(data) {
            Swal.fire({
                icon: 'error',
                title: 'ALERT: DEPO PENUH!',
                html: `
                    <div class="alert alert-danger">
                        <h5>${data.depo.nama_depo}</h5>
                        <p><strong>Volume:</strong> ${data.depo.persentase_volume}%</p>
                        <p><strong>Lokasi:</strong> ${data.depo.lokasi}</p>
                        <p class="mb-0">${data.message}</p>
                    </div>
                `,
                confirmButtonText: 'Check Depo',
                confirmButtonColor: '#dc3545'
            });
        }

        function loadNotificationsCount() {
            fetch('{{ url("/admin/notifications/latest") }}')
                .then(response => response.json())
                .then(notifications => {
                    if (notifications.length > 0) {
                        const reportBadge = document.getElementById('report-notification');
                        if (reportBadge) {
                            reportBadge.textContent = notifications.length;
                            reportBadge.classList.remove('d-none');
                        }
                    }
                })
                .catch(error => console.log('Notification loading error:', error));
        }

        // Update timestamp
        setInterval(function() {
            document.getElementById('last-update').textContent = new Date().toLocaleString('id-ID');
        }, 30000);
    </script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')

    @push('scripts')
<script>
    function loadNotifications() {
        fetch('{{ route("admin.notifications.latest") }}') // Kita akan buat route ini
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('notification-count');
                const listElement = document.getElementById('notification-list');
                
                listElement.innerHTML = ''; // Kosongkan daftar lama

                if (data.length > 0) {
                    countElement.innerText = data.length;
                    countElement.style.display = 'inline';

                    data.forEach(notif => {
                        const notifItem = `
                        <a class="dropdown-item d-flex align-items-center" href="${notif.data.url}">
                            <div class="mr-3">
                                <div class="icon-circle bg-danger">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${new Date(notif.created_at).toLocaleDateString('id-ID')}</div>
                                <span class="font-weight-bold">${notif.data.pesan}</span>
                            </div>
                        </a>
                        `;
                        listElement.innerHTML += notifItem;
                    });
                } else {
                    countElement.style.display = 'none';
                    listElement.innerHTML = '<span class="dropdown-item text-center small text-gray-500">Tidak ada notifikasi baru</span>';
                }
            })
            .catch(error => console.error('Gagal memuat notifikasi:', error));
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        // Cek notifikasi baru setiap 30 detik
        setInterval(loadNotifications, 30000); 
    });
</script>
@endpush
</body>
</html>