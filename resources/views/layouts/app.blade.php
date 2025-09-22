<?php
// resources/views/layouts/app.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="http://103.255.15.227/lifemedia_logo.png?v=1753515070" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DEVO - Dashboard Monitoring Depo Sampah')</title>
    
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

        /* Modern Header Navigation - SUPER FIXED */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
            padding: 1rem 0 !important;
            position: sticky;
            top: 0;
            z-index: 1030;
            min-height: 80px !important;
            height: 80px !important;
        }

        /* Container untuk navbar dengan padding konsisten - FORCE OVERRIDE */
        .navbar .container-fluid {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
            max-width: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: nowrap !important;
            height: 100% !important;
            margin: 0 !important;
        }

        /* Left section dengan menu toggle dan brand - FORCE TIGHT SPACING */
        .navbar-left {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important; /* Reduced gap from 1rem to 0.75rem */
            flex-shrink: 0 !important;
            margin-right: 0 !important;
        }

        /* Menu toggle button - SUPER SPECIFIC STYLING */
        #menu-toggle,
        .menu-toggle-btn,
        .navbar .menu-toggle-btn,
        .navbar-left .btn {
            background: rgba(255,255,255,0.1) !important;
            border: 2px solid rgba(255,255,255,0.2) !important;
            border-radius: 12px !important;
            padding: 0.75rem !important;
            width: 48px !important;
            height: 48px !important;
            min-width: 48px !important;
            max-width: 48px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: var(--transition) !important;
            cursor: pointer !important;
            margin: 0 !important;
            flex-shrink: 0 !important;
        }

        #menu-toggle:hover,
        .menu-toggle-btn:hover,
        .navbar .menu-toggle-btn:hover,
        .navbar-left .btn:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            transform: scale(1.05) !important;
        }

        #menu-toggle:hover i,
        .menu-toggle-btn:hover i,
        .navbar .menu-toggle-btn:hover i,
        .navbar-left .btn:hover i {
            color: white !important;
        }

        #menu-toggle i,
        .menu-toggle-btn i,
        .navbar .menu-toggle-btn i,
        .navbar-left .btn i {
            color: var(--dark-color) !important;
            font-size: 1.125rem !important;
            transition: var(--transition) !important;
            margin: 0 !important;
        }

        /* Brand styling - SUPER SPECIFIC */
        .navbar-brand,
        .navbar .navbar-brand,
        .navbar-left .navbar-brand {
            font-weight: 800 !important;
            font-size: 2rem !important;
            background: var(--primary-gradient) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            font-family: 'Space Grotesk', sans-serif !important;
            text-decoration: none !important;
            transition: var(--transition) !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
            white-space: nowrap !important;
        }

        .navbar-brand:hover,
        .navbar .navbar-brand:hover,
        .navbar-left .navbar-brand:hover {
            transform: scale(1.05) !important;
            filter: brightness(1.1) !important;
            -webkit-text-fill-color: transparent !important;
            text-decoration: none !important;
        }

        .navbar-brand:focus,
        .navbar .navbar-brand:focus,
        .navbar-left .navbar-brand:focus {
            -webkit-text-fill-color: transparent !important;
            text-decoration: none !important;
        }

        /* Icon spacing in brand */
        .navbar-brand i,
        .navbar .navbar-brand i,
        .navbar-left .navbar-brand i {
            margin-right: 0.5rem !important;
            color: transparent !important; /* Let gradient handle color */
            background: var(--primary-gradient) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Right section dengan actions - KEEP CONSISTENT */
        .navbar-right {
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            flex-shrink: 0 !important;
            margin-left: auto !important;
        }

        /* Override any Bootstrap navbar classes that might interfere */
        .navbar > .container-fluid {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        /* Prevent any flex-grow on navbar items */
        .navbar .navbar-nav,
        .navbar .nav,
        .navbar > * {
            flex-grow: 0 !important;
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

        /* Notifications System */
        .notification-dropdown {
            position: relative;
        }

        .notification-btn {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            transition: var(--transition);
            cursor: pointer;
        }

        .notification-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-gradient);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            border: 2px solid white;
        }

        .notification-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 400px;
            max-height: 500px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-xl);
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
            overflow: hidden;
            margin-top: 1rem;
        }

        .notification-dropdown-menu.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .notification-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .notification-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
            padding: 0;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background: rgba(0, 0, 0, 0.02);
        }

        .notification-item.critical {
            background: rgba(239, 68, 68, 0.05);
            border-left: 4px solid var(--danger-color);
        }

        .notification-item.critical .notification-icon {
            background: var(--danger-gradient);
        }

        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .notification-text {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
        }

        /* Status Classes with Modern Gradients */
        .status-normal { 
            background: var(--success-gradient);
            color: white;
        }
        .status-warning { 
            background: var(--warning-gradient);
            color: white;
        }
        .status-critical { 
            background: var(--danger-gradient);
            color: white;
        }

        /* Modern Cards */
        .depo-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .depo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .depo-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .depo-card.normal::before { background: var(--success-gradient); }
        .depo-card.warning::before { background: var(--warning-gradient); }
        .depo-card.critical::before { background: var(--danger-gradient); }

        /* Volume Progress with Animation */
        .volume-progress {
            height: 24px;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .volume-progress .progress-bar {
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: width 0.6s ease;
        }

        .volume-progress .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.3) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0.3) 75%, transparent 75%);
            background-size: 24px 24px;
            animation: progressShimmer 2s linear infinite;
        }

        @keyframes progressShimmer {
            0% { transform: translateX(-24px); }
            100% { transform: translateX(24px); }
        }

        /* LED Indicator */
        .led-indicator {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        .led-on {
            background: var(--danger-color);
            box-shadow: 0 0 20px var(--danger-color), inset 0 2px 4px rgba(255,255,255,0.3);
            animation: ledPulse 2s infinite;
        }

        .led-off {
            background: #9ca3af;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
        }

        @keyframes ledPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
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

        /* Filter Section */
        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filter-btn {
            border: 2px solid transparent;
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            margin: 0.5rem;
            background: rgba(255, 255, 255, 0.8);
            color: var(--dark-color);
            transition: var(--transition);
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            transition: var(--transition);
            z-index: -1;
        }

        .filter-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .filter-btn:hover::before {
            left: 0;
        }

        .filter-btn.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-md);
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            min-height: calc(100vh - 120px);
        }

        /* Footer */
        footer {
            background: rgba(30, 41, 59, 0.95) !important;
            backdrop-filter: blur(20px);
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .real-time-indicator {
            animation: pulse 2s infinite;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* User dropdown button */
        .user-dropdown-btn {
            background: rgba(255,255,255,0.1) !important;
            border: 2px solid rgba(255,255,255,0.2) !important;
            border-radius: 12px !important;
            padding: 0.5rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            transition: var(--transition) !important;
            height: 48px !important;
        }

        .user-dropdown-btn:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .login-btn {
            background: var(--primary-gradient) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            color: white !important;
            font-weight: 600 !important;
            transition: var(--transition) !important;
            height: 48px !important;
            display: flex !important;
            align-items: center !important;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white !important;
        }

        /* Responsive Design - UPDATED */
        @media (max-width: 768px) {
            .navbar .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .navbar-left {
                gap: 0.5rem !important; /* Tighter on mobile */
            }

            .navbar-brand,
            .navbar .navbar-brand,
            .navbar-left .navbar-brand {
                font-size: 1.5rem !important;
            }

            .modern-sidebar {
                width: 320px;
                left: -320px;
            }

            .notification-dropdown-menu {
                width: 320px;
                right: -120px;
            }

            .nav-menu-item {
                margin: 0.25rem 0.5rem;
                padding: 1rem 1.5rem;
            }

            .sidebar-header {
                padding: 1.5rem;
            }

            .navbar-right {
                gap: 0.5rem !important;
            }
        }

        @media (max-width: 480px) {
            .navbar-left {
                gap: 0.25rem !important; /* Even tighter on very small screens */
            }

            .modern-sidebar {
                width: 280px;
                left: -280px;
            }

            .nav-menu-item .menu-desc {
                display: none;
            }

            .navbar-brand,
            .navbar .navbar-brand,
            .navbar-left .navbar-brand {
                font-size: 1.25rem !important;
            }

            /* Hide text on mobile for user dropdown to save space */
            .user-dropdown-btn span {
                display: none !important;
            }
        }

        /* CRITICAL: Force override any potential conflicting styles */
        .navbar-expand-lg .navbar-collapse {
            flex-basis: auto !important;
        }

        .navbar-expand-lg .navbar-toggler {
            display: none !important;
        }

        /* Ensure no extra margins/padding on navbar elements */
        .navbar .navbar-nav {
            margin: 0 !important;
            padding: 0 !important;
        }

        .navbar .nav-link {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Override Bootstrap's default navbar-brand margin */
        .navbar > .container-fluid .navbar-brand {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }

        /* Force specific behavior on the navbar structure */
        .navbar-expand-lg {
            flex-wrap: nowrap !important;
        }

        .navbar-expand-lg > .container-fluid {
            flex-wrap: nowrap !important;
        }

        /* Debug helper (remove this after testing) */
        .debug-navbar {
            .navbar-left {
                border: 2px solid red !important;
            }
            .navbar-brand {
                border: 2px solid blue !important;
            }
            #menu-toggle {
                border: 2px solid green !important;
            }
        }

        /* Loading States */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
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
                </i>DEVO
            </h4>
            <p class="sidebar-subtitle">Dashboard Monitoring</p>
        </div>
        
        <div class="nav-menu-section">
            <div class="nav-menu-title">Menu Utama</div>
            
            <a href="{{ route('dashboard') }}" class="nav-menu-item {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <div class="menu-text">
                    <div class="menu-title">Dashboard</div>
                    <div class="menu-desc">Monitoring real-time depo sampah</div>
                </div>
            </a>
            
            <a href="{{ route('report.index') }}" class="nav-menu-item {{ Route::currentRouteName() === 'report.index' ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="menu-text">
                    <div class="menu-title">Report</div>
                    <div class="menu-desc">Laporan dan Tinjauan Laporan</div>
                </div>
            </a>
            
            <a href="{{ route('about') }}" class="nav-menu-item {{ Route::currentRouteName() === 'about' ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i>
                <div class="menu-text">
                    <div class="menu-title">About</div>
                    <div class="menu-desc">Informasi dan bantuan</div>
                </div>
            </a>
        </div>

        @auth
        <div class="nav-menu-section">
            <div class="nav-menu-title">Admin Panel</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-menu-item">
                <i class="fas fa-cogs"></i>
                <div class="menu-text">
                    <div class="menu-title">Admin Dashboard</div>
                    <div class="menu-desc">Pengaturan dan kontrol sistem</div>
                </div>
            </a>
            
            <a href="{{ route('admin.depos.index') }}" class="nav-menu-item">
                <i class="fas fa-warehouse"></i>
                <div class="menu-text">
                    <div class="menu-title">Kelola Depo</div>
                    <div class="menu-desc">Kelola data depo dan sensor</div>
                </div>
            </a>
            
            <a href="{{ route('admin.reports.index') }}" class="nav-menu-item">
                <i class="fas fa-chart-bar"></i>
                <div class="menu-text">
                    <div class="menu-title">Kelola Laporan</div>
                    <div class="menu-desc">Analisis dan review laporan</div>
                </div>
            </a>
        </div>
        @endauth
    </div>

    <!-- Modern Header Navigation - RESTRUCTURED -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Left Section: Menu Toggle + Brand -->
            <div class="navbar-left">
                <button class="btn menu-toggle-btn" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <link rel="icon" href="http://103.255.15.227/lifemedia_logo.png?v=1753515070" type="image/png">
                <a class="navbar-brand heading-font" href="{{ route('dashboard') }}">
                <i class="fas fa-recycle me-2"></i> DEVO
</a>
            </div>
                @auth
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle user-dropdown-btn d-flex align-items-center" data-bs-toggle="dropdown">
                        <div class="me-2 d-flex align-items-center justify-content-center rounded-circle text-white" style="width: 32px; height: 32px; background: var(--primary-gradient);">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: var(--border-radius); backdrop-filter: blur(20px); background: rgba(255,255,255,0.95);">
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-cog me-2"></i>Admin Panel
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
                @else
                <a class="btn login-btn d-flex align-items-center" href="{{ route('auth.login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i>Login Admin
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-2 heading-font">
                        <i class="fas fa-recycle me-2 text-primary"></i>
                        DEVO - Dashboard Monitoring
                    </h5>
                    <p class="mb-0 opacity-75">Sistem monitoring volume sampah real-time untuk pengelolaan sampah yang lebih efektif dan sustainable.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <small class="opacity-75">
                        <i class="fas fa-clock me-1"></i>
                        Last Update: <span id="last-update">{{ now()->format('d/m/Y H:i:s') }}</span>
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Real-time System - Improved notification system -->
    <script>
        // Global variables
        let criticalNotifications = [];
        let currentFilter = 'all';
        let isMenuOpen = false;
        let isNotificationOpen = false;
        let activeDepoAlerts = {}; // Track depos that are currently critical

        // Initialize AOS
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: false
        });

        // WebSocket configuration
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });

        // Listen to critical alerts
        const alertChannel = pusher.subscribe('critical-alerts');
        alertChannel.bind('critical_volume_alert', function(data) {
            handleCriticalNotification(data);
        });

        // Listen to public dashboard updates
        const publicChannel = pusher.subscribe('public-dashboard');
        publicChannel.bind('depo_status_updated', function(data) {
            updateDepoCard(data.depo);
            
            // Handle status changes - only show notifications for critical depos (> 90%)
            if (data.depo.persentase_volume > 90) {
                if (!activeDepoAlerts[data.depo.id]) {
                    handleCriticalNotification({
                        type: 'critical_volume_alert',
                        depo: data.depo,
                        message: `PERINGATAN: Depo ${data.depo.nama_depo} telah mencapai kapasitas ${data.depo.persentase_volume.toFixed(1)}%`,
                        timestamp: new Date().toISOString()
                    });
                    activeDepoAlerts[data.depo.id] = true;
                }
            } else {
                // Remove from critical alerts if volume drops below 90%
                if (activeDepoAlerts[data.depo.id]) {
                    removeDepoNotification(data.depo.id);
                    delete activeDepoAlerts[data.depo.id];
                }
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeMenuSystem();
            initializeNotificationSystem();
            checkInitialCriticalDepos();
            initializeAnimations();
            fixNavbarSpacing(); // Add this new function
        });

        // NEW: Function to fix navbar spacing issues
        function fixNavbarSpacing() {
            const navbar = document.querySelector('.navbar');
            const containerFluid = navbar?.querySelector('.container-fluid');
            const navbarLeft = navbar?.querySelector('.navbar-left');
            const menuToggle = document.getElementById('menu-toggle');
            const navbarBrand = navbar?.querySelector('.navbar-brand');
            
            // Debug log (remove after testing)
            console.log('Navbar elements check:', {
                navbar: !!navbar,
                containerFluid: !!containerFluid,
                navbarLeft: !!navbarLeft,
                menuToggle: !!menuToggle,
                navbarBrand: !!navbarBrand
            });
            
            // Force correct structure if needed
            if (navbar && containerFluid) {
                // Ensure container-fluid has correct styles
                containerFluid.style.display = 'flex';
                containerFluid.style.alignItems = 'center';
                containerFluid.style.justifyContent = 'space-between';
                containerFluid.style.flexWrap = 'nowrap';
                containerFluid.style.paddingLeft = '2rem';
                containerFluid.style.paddingRight = '2rem';
                containerFluid.style.height = '100%';
                containerFluid.style.margin = '0';
                
                // Ensure navbar-left has correct styles
                if (navbarLeft) {
                    navbarLeft.style.display = 'flex';
                    navbarLeft.style.alignItems = 'center';
                    navbarLeft.style.gap = '0.75rem';
                    navbarLeft.style.flexShrink = '0';
                    navbarLeft.style.marginRight = '0';
                }
                
                // Ensure menu toggle has correct styles
                if (menuToggle) {
                    menuToggle.style.width = '48px';
                    menuToggle.style.height = '48px';
                    menuToggle.style.minWidth = '48px';
                    menuToggle.style.maxWidth = '48px';
                    menuToggle.style.margin = '0';
                    menuToggle.style.flexShrink = '0';
                    menuToggle.style.display = 'flex';
                    menuToggle.style.alignItems = 'center';
                    menuToggle.style.justifyContent = 'center';
                    menuToggle.style.padding = '0.75rem';
                }
                
                // Ensure navbar brand has correct styles
                if (navbarBrand) {
                    navbarBrand.style.margin = '0';
                    navbarBrand.style.padding = '0';
                    navbarBrand.style.flexShrink = '0';
                    navbarBrand.style.whiteSpace = 'nowrap';
                    navbarBrand.style.display = 'flex';
                    navbarBrand.style.alignItems = 'center';
                    navbarBrand.style.lineHeight = '1';
                    
                    // Fix icon spacing
                    const icon = navbarBrand.querySelector('i');
                    if (icon) {
                        icon.style.marginRight = '0.5rem';
                    }
                }
            }
            
            // Force navbar height
            if (navbar) {
                navbar.style.minHeight = '80px';
                navbar.style.height = '80px';
                navbar.style.padding = '1rem 0';
            }
            
            // Check for any potential conflicting elements
            const navbarNav = navbar?.querySelector('.navbar-nav');
            if (navbarNav && navbarNav.children.length === 0) {
                // Remove empty navbar-nav that might be taking space
                navbarNav.remove();
            }
            
            // Remove any Bootstrap collapse elements if they exist
            const navbarCollapse = navbar?.querySelector('.navbar-collapse');
            if (navbarCollapse && navbarCollapse.children.length === 0) {
                navbarCollapse.remove();
            }
            
            console.log('Navbar spacing fix applied');
        }

        // Add a mutation observer to catch dynamic changes
        if (typeof MutationObserver !== 'undefined') {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' && mutation.target.classList?.contains('navbar')) {
                        setTimeout(() => fixNavbarSpacing(), 100);
                    }
                });
            });
            
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.querySelector('.navbar');
                if (navbar) {
                    observer.observe(navbar, { childList: true, subtree: true });
                }
            });
        }

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
            
            // Close sidebar when clicking on menu items
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
            menuToggle.innerHTML = '<i class="fas fa-times"></i>';
            
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
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            
            // Restore body scroll
            document.body.style.overflow = '';
        }

        // Notification System - Simplified (no toast, auto-hide when < 90%)
        function initializeNotificationSystem() {
            const notificationToggle = document.getElementById('notification-toggle');
            const notificationMenu = document.getElementById('notification-menu');
            
            notificationToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleNotifications();
            });
            
            // Close notifications when clicking outside
            document.addEventListener('click', function(e) {
                if (isNotificationOpen && !notificationMenu.contains(e.target) && !notificationToggle.contains(e.target)) {
                    closeNotifications();
                }
            });
        }

        function toggleNotifications() {
            if (isNotificationOpen) {
                closeNotifications();
            } else {
                openNotifications();
            }
        }

        function openNotifications() {
            const notificationMenu = document.getElementById('notification-menu');
            isNotificationOpen = true;
            notificationMenu.classList.add('show');
        }

        function closeNotifications() {
            const notificationMenu = document.getElementById('notification-menu');
            isNotificationOpen = false;
            notificationMenu.classList.remove('show');
        }

        function handleCriticalNotification(data) {
            // Only add notification if depo volume > 90%
            if (data.depo.persentase_volume <= 90) {
                return;
            }

            // Check if notification for this depo already exists
            const existingIndex = criticalNotifications.findIndex(n => 
                n.depo && n.depo.id === data.depo.id
            );
            
            if (existingIndex !== -1) {
                // Update existing notification
                criticalNotifications[existingIndex].depo = data.depo;
                criticalNotifications[existingIndex].message = data.message;
                criticalNotifications[existingIndex].timestamp = new Date(data.timestamp);
            } else {
                // Add new notification
                const notification = {
                    id: Date.now(),
                    type: 'critical',
                    depo: data.depo,
                    message: data.message,
                    timestamp: new Date(data.timestamp)
                };
                
                criticalNotifications.unshift(notification);
            }
            
            // Update UI
            updateNotificationBadge();
            updateNotificationList();
        }

        function removeDepoNotification(depoId) {
            criticalNotifications = criticalNotifications.filter(n => 
                !(n.depo && n.depo.id === depoId)
            );
            updateNotificationBadge();
            updateNotificationList();
        }

        function updateNotificationBadge() {
            const badge = document.getElementById('notification-badge');
            const count = document.getElementById('notification-count');
            const criticalCount = criticalNotifications.length;
            
            if (criticalCount > 0) {
                badge.style.display = 'flex';
                count.textContent = criticalCount > 99 ? '99+' : criticalCount;
            } else {
                badge.style.display = 'none';
            }
        }

        function updateNotificationList() {
            const notificationList = document.getElementById('notification-list');
            
            if (criticalNotifications.length === 0) {
                notificationList.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle text-success mb-2" style="font-size: 3rem; opacity: 0.5;"></i>
                        <p class="text-muted">Tidak ada notifikasi critical</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            criticalNotifications.slice(0, 10).forEach(notification => {
                const timeAgo = getTimeAgo(notification.timestamp);
                html += `
                    <div class="notification-item critical">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${notification.depo.nama_depo} - CRITICAL!</div>
                            <div class="notification-text">Volume: ${notification.depo.persentase_volume.toFixed(1)}% - Segera kosongkan!</div>
                            <div class="notification-time">
                                <i class="fas fa-clock me-1"></i>${timeAgo}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            notificationList.innerHTML = html;
        }

        function getTimeAgo(date) {
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Baru saja';
            if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' menit lalu';
            if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' jam lalu';
            return Math.floor(diffInSeconds / 86400) + ' hari lalu';
        }

        function checkInitialCriticalDepos() {
            // Check existing depos for critical status (> 90%)
            const depoCards = document.querySelectorAll('[data-depo-id]');
            depoCards.forEach(card => {
                const progressBar = card.querySelector('.progress-bar');
                if (progressBar) {
                    const percentageText = progressBar.textContent.replace('%', '');
                    const percentage = parseFloat(percentageText);
                    
                    if (percentage > 90) {
                        const depoName = card.querySelector('h5').textContent;
                        const depoId = card.getAttribute('data-depo-id');
                        
                        const depo = {
                            id: depoId,
                            nama_depo: depoName,
                            persentase_volume: percentage,
                            status: 'critical'
                        };
                        
                        activeDepoAlerts[depo.id] = true;
                        handleCriticalNotification({
                            type: 'critical_volume_alert',
                            depo: depo,
                            message: `PERINGATAN: Depo ${depo.nama_depo} telah mencapai kapasitas ${depo.persentase_volume.toFixed(1)}%!`,
                            timestamp: new Date().toISOString()
                        });
                    }
                }
            });
        }

        function updateDepoCard(depo) {
            const card = document.querySelector(`[data-depo-id="${depo.id}"]`);
            if (card) {
                // Add loading animation
                card.classList.add('loading-shimmer');
                
                setTimeout(() => {
                    // Update percentage
                    const progressBar = card.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = depo.persentase_volume + '%';
                        progressBar.textContent = depo.persentase_volume.toFixed(1) + '%';
                        progressBar.className = `progress-bar status-${depo.status}`;
                    }

                    // Update status badge
                    const statusBadge = card.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.className = `badge status-${depo.status} status-badge rounded-pill`;
                        statusBadge.textContent = depo.status_text;
                    }

                    // Update LED indicator
                    const ledIndicator = card.querySelector('.led-indicator');
                    if (ledIndicator) {
                        ledIndicator.className = `led-indicator ${depo.led_status ? 'led-on' : 'led-off'}`;
                    }

                    // Update card class
                    card.className = card.className.replace(/\b(normal|warning|critical)\b/, depo.status);
                    
                    // Remove loading animation
                    card.classList.remove('loading-shimmer');
                    
                    // Add update animation
                    card.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                }, 500);
            }
        }

        function initializeAnimations() {
            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.depo-card, .stats-card').forEach(card => {
                observer.observe(card);
            });
        }

        // Filter functionality
        function initializeFilters() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    filterDepos(filter);
                    
                    // Update active state
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }

        function filterDepos(status) {
            currentFilter = status;
            const depoCards = document.querySelectorAll('.depo-card');
            
            depoCards.forEach((card, index) => {
                const cardContainer = card.closest('[class*="col-"]');
                if (status === 'all' || card.classList.contains(status)) {
                    cardContainer.style.display = 'block';
                    // Staggered animation
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0) scale(1)';
                    }, index * 100);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px) scale(0.95)';
                    setTimeout(() => {
                        cardContainer.style.display = 'none';
                    }, 300);
                }
            });
        }

        // Update timestamp
        setInterval(function() {
            document.getElementById('last-update').textContent = new Date().toLocaleString('id-ID');
        }, 30000);

        // Initialize filters when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.filter-btn')) {
                initializeFilters();
            }
        });
    </script>
    
    @stack('scripts')
    <style>
        .fa-calendar + span {
            display: none !important;
        }
    </style>
    
</body>
</html>