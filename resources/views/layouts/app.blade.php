<!DOCTYPE html>
<html lang="en" class="@if(($settings->theme ?? 'light') == 'dark') dark @endif">
<head>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFP - @yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { 
            background: #f8f9fa; 
            transition: background-color 0.3s ease;
        }
        
        /* Dark mode styles */
        .dark body {
            background: #0f172a;
        }

        .dark .sidebar {
            background: #1e293b;
        }

        .dark .topbar {
            background: #1e293b;
            border-bottom-color: #334155;
            color: #f1f5f9;
        }

        .dark .main-content {
            background: #0f172a;
            color: #f1f5f9;
        }

        .dark .dropdown-menu {
            background: #1e293b;
            border-color: #334155;
        }

        .dark .dropdown-menu a {
            color: #cbd5e1;
            border-bottom-color: #334155;
        }

        .dark .dropdown-menu a:hover {
            background: #334155;
            color: #ffffff;
        }

        .dark .dropdown-trigger {
            color: #cbd5e1;
        }

        .dark .dropdown-trigger:hover {
            background: #334155;
            color: #ffffff;
        }

        .dark .notif-dropdown {
            background: #1e293b;
            border-color: #334155;
        }

        .dark .notif-dropdown .header {
            background: linear-gradient(135deg, #1e293b, #334155);
        }

        .dark .notif-item {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .notif-item:hover {
            background: #334155;
        }

        .dark .notif-item .notif-title {
            color: #f1f5f9;
        }

        .dark .notif-item .notif-desc {
            color: #94a3b8;
        }

        .dark .toast {
            background: #1e293b;
            color: #f1f5f9;
            border-color: #334155;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #c1121f;
            color: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 25px 0;
            transition: width 0.3s ease, background-color 0.3s ease;
            z-index: 50;
        }
        .sidebar.collapsed { width: 70px; }

        .sidebar .logo {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .sidebar .logo img {
            width: 50px;
            height: 50px;
            margin: 0 auto 8px;
            border-radius: 50%;
            object-fit: cover;
        }
        .sidebar a, .sidebar .dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #f1f1f1;
            text-decoration: none;
            transition: background 0.3s, color 0.3s;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
        }
        .sidebar a:hover,
        .sidebar a.active,
        .sidebar .dropdown-btn:hover {
            background: #a40e19;
        }
        .sidebar.collapsed a span,
        .sidebar.collapsed .dropdown-btn span,
        .sidebar.collapsed .logo h1 {
            display: none;
        }

        /* Submenu */
        .submenu {
            max-height: 0;
            overflow: hidden;
            flex-direction: column;
            margin-left: 10px;
            transition: max-height 0.3s ease;
        }
        .submenu a {
            padding-left: 20px;
            font-size: 14px;
            background: #b71c29;
            border-radius: 8px;
        }
        .submenu a:hover,
        .submenu a.active {
            background: #91121b;
        }

        /* Topbar */
        .topbar {
            height: 60px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #dee2e6;
            margin-left: 240px;
            transition: margin-left 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
            z-index: 1000;
            position: relative;
        }
        .sidebar.collapsed ~ .topbar { margin-left: 70px; }

        .hamburger {
            cursor: pointer;
            border: none;
            background: none;
            color: #c1121f;
            transition: transform 0.3s;
        }
        .hamburger:hover { transform: rotate(90deg); }

        /* Main content */
        .main-content {
            margin-left: 240px;
            padding: 25px;
            transition: margin-left 0.3s ease, background-color 0.3s ease, color 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .sidebar.collapsed ~ .main-content { margin-left: 70px; }

        /* Modern Dropdown - UPDATED */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-trigger {
            background: none;
            border: none;
            color: #374151;
            font-weight: 600;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        .dropdown-trigger:hover {
            background: rgba(193, 18, 31, 0.1);
            color: #c1121f;
            transform: translateY(-1px);
        }
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: #ffffff;
            min-width: 200px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            z-index: 1001;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f3f4f6;
            margin-top: 8px;
        }
        .dropdown-menu.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f8fafc;
            font-size: 14px;
            font-weight: 500;
        }
        .dropdown-menu a:last-child {
            border-bottom: none;
        }
        .dropdown-menu a:hover {
            background: linear-gradient(135deg, #fef2f2, #fef2f2);
            color: #c1121f;
            transform: translateX(4px);
        }
        .dropdown-menu a i {
            width: 16px;
            text-align: center;
            font-size: 14px;
        }

        /* Modern Notification System */
        .notif-bell {
            position: relative;
            cursor: pointer;
            color: #c1121f;
            transition: all 0.3s ease;
            background: none;
            border: none;
            padding: 8px;
            border-radius: 8px;
        }
        .notif-bell:hover {
            background: rgba(193, 18, 31, 0.1);
            transform: scale(1.1);
        }

        .badge-notif {
            position: absolute;
            top: 0;
            right: 0;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border-radius: 50%;
            font-size: 11px;
            padding: 2px 6px;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
            border: 2px solid #ffffff;
            display: none;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .notif-dropdown {
            position: absolute;
            right: 0;
            top: 50px;
            width: 380px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            z-index: 1002;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }
        .notif-dropdown.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .notif-dropdown .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
        }
        .notif-dropdown .header h3 {
            font-weight: 700;
            color: white;
            font-size: 16px;
            margin: 0;
        }
        .notif-dropdown .header-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .notif-dropdown .clear-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .notif-dropdown .clear-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .notif-dropdown .notif-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .notif-dropdown .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid #f8fafc;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }
        .notif-dropdown .notif-item:hover {
            background: #f8fafc;
            transform: translateX(4px);
        }
        .notif-dropdown .notif-item:last-child {
            border-bottom: none;
        }
        .notif-dropdown .notif-item.unread {
            background: linear-gradient(135deg, #fef2f2, #fef2f2);
            border-left: 3px solid #c1121f;
        }
        .notif-dropdown .notif-item .notif-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .notif-dropdown .notif-item.incident .notif-icon {
            background: linear-gradient(135deg, #fef3c7, #f59e0b);
            color: #92400e;
        }
        .notif-dropdown .notif-item.alert .notif-icon {
            background: linear-gradient(135deg, #fee2e2, #ef4444);
            color: #991b1b;
        }
        .notif-dropdown .notif-item.info .notif-icon {
            background: linear-gradient(135deg, #dbeafe, #3b82f6);
            color: #1e40af;
        }
        .notif-dropdown .notif-item .notif-content {
            flex: 1;
            min-width: 0;
        }
        .notif-dropdown .notif-item .notif-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 4px;
            line-height: 1.4;
        }
        .notif-dropdown .notif-item .notif-desc {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .notif-dropdown .notif-item .notif-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #9ca3af;
        }
        .notif-dropdown .notif-item .notif-actions {
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .notif-dropdown .notif-item:hover .notif-actions {
            opacity: 1;
        }
        .notif-dropdown .notif-item .action-btn {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 12px;
        }
        .notif-dropdown .notif-item .action-btn:hover {
            background: #e5e7eb;
            color: #374151;
        }
        .notif-dropdown .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }
        .notif-dropdown .empty-state i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.5;
        }
        .notif-dropdown .empty-state p {
            font-size: 14px;
            margin-bottom: 8px;
        }
        .notif-dropdown .empty-state .subtext {
            font-size: 12px;
            color: #d1d5db;
        }

        /* Toast System - UPDATED */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .toast {
            background: #ffffff;
            color: #1f2937;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-left: 4px solid #c1121f;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            border: 1px solid #f3f4f6;
        }
        .toast.show {
            transform: translateX(0);
        }
        .toast.success {
            border-left-color: #10b981;
            background: linear-gradient(135deg, #f0fdf4, #ffffff);
        }
        .toast.error {
            border-left-color: #ef4444;
            background: linear-gradient(135deg, #fef2f2, #ffffff);
        }
        .toast.info {
            border-left-color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff, #ffffff);
        }
        .toast.warning {
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, #fffbeb, #ffffff);
        }
        .toast .toast-icon {
            font-size: 18px;
            flex-shrink: 0;
        }
        .toast.success .toast-icon { color: #10b981; }
        .toast.error .toast-icon { color: #ef4444; }
        .toast.info .toast-icon { color: #3b82f6; }
        .toast.warning .toast-icon { color: #f59e0b; }
        .toast .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            margin-left: auto;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        .toast .toast-close:hover {
            background: #f3f4f6;
            color: #374151;
        }

        /* Dark mode toast styles */
        .dark .toast {
            background: #1e293b;
            color: #f1f5f9;
            border-color: #334155;
        }

        .dark .toast.success {
            background: linear-gradient(135deg, #064e3b, #1e293b);
            border-left-color: #10b981;
        }

        .dark .toast.error {
            background: linear-gradient(135deg, #7f1d1d, #1e293b);
            border-left-color: #ef4444;
        }

        .dark .toast.info {
            background: linear-gradient(135deg, #1e3a8a, #1e293b);
            border-left-color: #3b82f6;
        }

        .dark .toast.warning {
            background: linear-gradient(135deg, #78350f, #1e293b);
            border-left-color: #f59e0b;
        }

        /* Notification Modal */
        .notif-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .notif-modal.active {
            opacity: 1;
            pointer-events: auto;
        }
        .notif-modal .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        .notif-modal.active .modal-content {
            transform: scale(1);
        }
        .notif-modal .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
        }
        .notif-modal .modal-header h3 {
            font-weight: 700;
            color: white;
            font-size: 18px;
            margin: 0;
        }
        .notif-modal .close-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 16px;
        }
        .notif-modal .close-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .notif-modal .modal-body {
            padding: 24px;
            max-height: 400px;
            overflow-y: auto;
        }
        .notif-modal .modal-item {
            margin-bottom: 20px;
        }
        .notif-modal .modal-item:last-child {
            margin-bottom: 0;
        }
        .notif-modal .modal-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            margin-bottom: 6px;
        }
        .notif-modal .modal-value {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        .notif-modal .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .notif-modal .modal-btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .notif-modal .modal-btn.secondary {
            background: #f3f4f6;
            color: #374151;
        }
        .notif-modal .modal-btn.secondary:hover {
            background: #e5e7eb;
        }
        .notif-modal .modal-btn.primary {
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
        }
        .notif-modal .modal-btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
        }

        /* Confirmation Modal */
        .confirmation-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .confirmation-modal.active {
            opacity: 1;
            pointer-events: auto;
        }
        .confirmation-modal .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        .confirmation-modal.active .modal-content {
            transform: scale(1);
        }
        .confirmation-modal .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
        }
        .confirmation-modal .modal-header h3 {
            font-weight: 700;
            color: white;
            font-size: 18px;
            margin: 0;
        }
        .confirmation-modal .close-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 16px;
        }
        .confirmation-modal .close-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .confirmation-modal .modal-body {
            padding: 24px;
            text-align: center;
        }
        .confirmation-modal .modal-icon {
            font-size: 48px;
            color: #c1121f;
            margin-bottom: 16px;
        }
        .confirmation-modal .modal-message {
            font-size: 16px;
            color: #374151;
            margin-bottom: 8px;
        }
        .confirmation-modal .modal-submessage {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }
        .confirmation-modal .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        .confirmation-modal .modal-btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            min-width: 100px;
        }
        .confirmation-modal .modal-btn.cancel {
            background: #f3f4f6;
            color: #374151;
        }
        .confirmation-modal .modal-btn.cancel:hover {
            background: #e5e7eb;
        }
        .confirmation-modal .modal-btn.confirm {
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
        }
        .confirmation-modal .modal-btn.confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
        }

        /* Map Styles */
        .leaflet-container {
            position: relative;
            z-index: 1 !important;
            font-family: 'Poppins', sans-serif !important;
        }
        .leaflet-pane {
            z-index: 1 !important;
        }
        .leaflet-top,
        .leaflet-bottom {
            z-index: 2 !important;
        }
        .leaflet-control {
            z-index: 3 !important;
        }

        /* Custom Marker Styles */
        .custom-marker {
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .custom-marker:hover {
            transform: scale(1.2);
            z-index: 1000 !important;
        }

        /* Priority Colors */
        .marker-critical {
            background: #8B5CF6 !important; /* Violet */
            animation: critical-pulse 1.5s infinite;
        }
        .marker-pending {
            background: #F59E0B !important; /* Yellow */
            animation: pulse 2s infinite;
        }
        .marker-in-progress {
            background: #3B82F6 !important; /* Blue */
            animation: pulse 2s infinite;
        }
        .marker-resolved {
            background: #10B981 !important; /* Green */
        }

        @keyframes critical-pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7); }
            70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(139, 92, 246, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(139, 92, 246, 0); }
        }

        /* Dashboard Map Styles */
        .mark-item { transition: all 0.2s ease; }
        .mark-item:hover { transform: translateX(4px); }
        .pulse { animation: pulse 2s infinite; }
        .report-item:hover {
            background-color: #f9fafb;
            cursor: pointer;
        }
        .highlight-marker {
            animation: highlight-pulse 1.5s infinite;
            z-index: 1000 !important;
        }
        @keyframes highlight-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        .modal.active {
            display: block !important;
        }
        .modal.active .scale-95 {
            transform: scale(1) !important;
        }

        /* Elevation Meter */
        .elevation-meter {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        /* Real-time Badge */
        .real-time-badge {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            animation: glow 2s infinite;
        }

        @keyframes glow {
            0% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.5); }
            50% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.8); }
            100% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.5); }
        }

        /* Modern Search Box */
        .search-box {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .search-box:focus-within {
            box-shadow: 0 4px 25px rgba(193, 18, 31, 0.15);
            border-color: #c1121f;
        }

        /* Modern Button Styles */
        .btn-modern {
            background: linear-gradient(135deg, #c1121f, #a40e19);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(193, 18, 31, 0.3);
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(193, 18, 31, 0.4);
        }

        @media (max-width: 768px) {
            .sidebar { left: -240px; }
            .sidebar.open { left: 0; }
            .topbar, .main-content { margin-left: 0; }
            .notif-dropdown {
                width: 320px;
                right: -50px;
            }
            .elevation-meter {
                bottom: 10px;
                right: 10px;
                font-size: 12px;
                padding: 8px 12px;
            }
            .toast-container {
                top: 70px;
                right: 10px;
                left: 10px;
            }
            .toast {
                min-width: auto;
                max-width: none;
            }
        }
    </style>

    <script>
        // Global Theme Manager
        class GlobalThemeManager {
            constructor() {
                this.currentTheme = this.getStoredTheme() || this.getPreferredTheme();
                this.init();
            }

            getStoredTheme() {
                return localStorage.getItem('bfp_theme');
            }

            setStoredTheme(theme) {
                localStorage.setItem('bfp_theme', theme);
            }

            getPreferredTheme() {
                const storedTheme = this.getStoredTheme();
                if (storedTheme) {
                    return storedTheme;
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            setTheme(theme) {
                this.currentTheme = theme;
                
                if (theme === 'auto') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    document.documentElement.classList.toggle('dark', prefersDark);
                } else {
                    document.documentElement.classList.toggle('dark', theme === 'dark');
                }
                
                this.setStoredTheme(theme);
                this.dispatchThemeChangeEvent();
            }

            toggleTheme() {
                const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme);
                return newTheme;
            }

            dispatchThemeChangeEvent() {
                document.dispatchEvent(new CustomEvent('themeChanged', {
                    detail: { theme: this.currentTheme }
                }));
            }

            init() {
                // Set initial theme
                this.setTheme(this.currentTheme);

                // Watch for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (this.currentTheme === 'auto') {
                        this.setTheme('auto');
                    }
                });

                // Add keyboard shortcut (Ctrl/Cmd + D)
                document.addEventListener('keydown', (e) => {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                        e.preventDefault();
                        const newTheme = this.toggleTheme();
                        this.showToast(`Theme changed to ${newTheme} mode`, 'success');
                    }
                });
            }

            showToast(message, type = 'info') {
                const toastContainer = document.getElementById('toastContainer') || this.createToastContainer();
                const toast = document.createElement('div');
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    warning: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };
                
                toast.className = `toast ${type}`;
                toast.innerHTML = `
                    <i class="toast-icon ${icons[type]}"></i>
                    <span>${message}</span>
                    <button class="toast-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                toastContainer.appendChild(toast);
                
                // Show toast with animation
                setTimeout(() => {
                    toast.classList.add('show');
                }, 100);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.remove('show');
                        setTimeout(() => {
                            if (toast.parentElement) {
                                toast.remove();
                            }
                        }, 300);
                    }
                }, 5000);
            }

            createToastContainer() {
                const container = document.createElement('div');
                container.className = 'toast-container';
                container.id = 'toastContainer';
                document.body.appendChild(container);
                return container;
            }
        }

        // Initialize theme immediately to prevent flash
        (function() {
            const storedTheme = localStorage.getItem('bfp_theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (storedTheme === 'dark' || (storedTheme === 'auto' && systemPrefersDark) || (!storedTheme && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body>
    <!-- Toast Container - UPDATED POSITION -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="{{ asset('images/bfp.jpg') }}" alt="BFP Logo">
            <h1>BFP</h1>
        </div>

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="home"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.incidents.index') }}" class="{{ request()->routeIs('admin.incidents.*') ? 'active' : '' }}">
                <i data-lucide="flame"></i> <span>Incident Reports</span>
            </a>
            <a href="{{ route('admin.mapping.index') }}" class="{{ request()->routeIs('admin.mapping.*') ? 'active' : '' }}">
                <i data-lucide="map"></i> <span>GPS & Mapping</span>
            </a>
            <div class="dropdown-btn flex items-center justify-between" onclick="toggleSubmenu('iotSubmenu', this)">
                <div class="flex items-center gap-2">
                    <i data-lucide="cpu"></i>
                    <span>IoT</span>
                </div>
                <span class="arrow">></span>
            </div>

            <div class="submenu" id="iotSubmenu">
                <a href="{{ route('admin.devices.index') }}" class="{{ request()->routeIs('admin.devices.*') ? 'active' : '' }}">
                    <i data-lucide="server"></i> Devices
                </a>
                <a href="{{ route('admin.alerts.index') }}" class="{{ request()->routeIs('admin.alerts.*') ? 'active' : '' }}">
                    <i data-lucide="bell"></i> Alerts
                </a>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                <i data-lucide="users"></i> <span>Staff Management</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i data-lucide="user"></i> <span>Users</span>
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i data-lucide="megaphone"></i> <span>Announcements</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i data-lucide="settings"></i> <span>Settings</span>
            </a>
        @elseif(Auth::user()->role === 'staff')
            <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <i data-lucide="home"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('staff.alerts.index') }}" class="{{ request()->routeIs('staff.alerts.*') ? 'active' : '' }}">
                <i data-lucide="alert-triangle"></i> <span>My Alerts</span>
            </a>
            <a href="{{ route('staff.incidents.index') }}" class="{{ request()->routeIs('staff.incidents.*') ? 'active' : '' }}">
                <i data-lucide="flame"></i> <span>My Incidents</span>
            </a>
            <a href="{{ route('staff.devices.index') }}" class="{{ request()->routeIs('staff.devices.*') ? 'active' : '' }}">
                <i data-lucide="server"></i> <span>Devices</span>
            </a>
            <a href="{{ route('staff.mapping.index') }}" class="{{ request()->routeIs('staff.mapping.*') ? 'active' : '' }}">
                <i data-lucide="map"></i> <span>Map</span>
            </a>
            <a href="{{ route('staff.announcements.index') }}" class="{{ request()->routeIs('staff.announcements.*') ? 'active' : '' }}">
                <i data-lucide="megaphone"></i> <span>Announcements</span>
            </a>
        @endif
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <button class="hamburger" id="hamburger">
            <i data-lucide="menu"></i>
        </button>
        <h2 class="text-xl font-semibold">@yield('title')</h2>

        <div class="flex items-center gap-5 relative">
            <!-- Theme Toggle Button -->
            <button class="notif-bell" id="themeToggle" title="Toggle dark mode (Ctrl+D)">
                <i data-lucide="sun-moon" id="themeIcon"></i>
            </button>

            <!-- Modern Notification -->
            <div class="notif-bell" id="notifBell">
                <i data-lucide="bell"></i>
                <span class="badge-notif" id="badgeNotif">0</span>

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="header">
                        <h3>Notifications</h3>
                        <div class="header-actions">
                            <button id="markAllRead" class="clear-btn">Mark All Read</button>
                            <button id="clearNotif" class="clear-btn">Clear All</button>
                        </div>
                    </div>
                    <div class="notif-list" id="notifList">
                        <div class="empty-state">
                            <i class="fas fa-bell-slash"></i>
                            <p>No new notifications</p>
                            <p class="subtext">We'll notify you when something arrives</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Dropdown - UPDATED -->
<div class="dropdown">
    <button class="dropdown-trigger" id="dropdownTrigger">
        <span>{{ Auth::user()->name ?? 'User' }}</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
    </button>
    <div class="dropdown-menu" id="dropdownMenu">
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.settings.index') }}">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        @elseif(Auth::user()->role === 'staff')
            <a href="#">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        @endif
        
        <!-- Safe profile link that won't throw error -->
        <a href="#" onclick="showProfileInfo()">
            <i class="fas fa-user"></i>
            Profile
        </a>
        
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>
</div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="main-content">@yield('content')</div>

    <!-- Notification Modal -->
    <div class="notif-modal" id="notifModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Incident Details</h3>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button class="modal-btn secondary" onclick="closeModal()">Close</button>
                <button class="modal-btn primary" id="modalActionBtn">View Details</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Clear All Notifications</h3>
                <button class="close-btn" onclick="closeConfirmationModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="modal-message">Are you sure you want to clear all notifications?</div>
                <div class="modal-submessage">This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel" onclick="closeConfirmationModal()">Cancel</button>
                <button class="modal-btn confirm" id="confirmClearAll">Clear All</button>
            </div>
        </div>
    </div>

    <!-- Audio element for notification sound -->
    <audio id="notificationSound" preload="auto">
        <source src="{{ asset('sounds/notifications.wav') }}" type="audio/wav">
        <source src="{{ asset('sounds/notifications.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
    // Initialize global theme manager
    window.globalThemeManager = new GlobalThemeManager();

    // Update theme icon based on current theme
    function updateThemeIcon() {
        const themeIcon = document.getElementById('themeIcon');
        if (themeIcon) {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            lucide.createIcons();
        }
    }

    // Theme toggle functionality
    document.getElementById('themeToggle')?.addEventListener('click', () => {
        const newTheme = window.globalThemeManager.toggleTheme();
        updateThemeIcon();
        window.globalThemeManager.showToast(`Theme changed to ${newTheme} mode`, 'success');
    });

    // Update icon on theme change
    document.addEventListener('themeChanged', updateThemeIcon);
    
    // Initial icon update
    updateThemeIcon();

    lucide.createIcons();

    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburger');
    const notifBell = document.getElementById('notifBell');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifList = document.getElementById('notifList');
    const badgeNotif = document.getElementById('badgeNotif');
    const notifModal = document.getElementById('notifModal');
    const modalBody = document.getElementById('modalBody');
    const modalTitle = document.getElementById('modalTitle');
    const modalActionBtn = document.getElementById('modalActionBtn');
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmClearAll = document.getElementById('confirmClearAll');
    const dropdownTrigger = document.getElementById('dropdownTrigger');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const toastContainer = document.getElementById('toastContainer');

    // Initialize notifications from localStorage
    let notifications = JSON.parse(localStorage.getItem('bfp_notifications')) || [];
    let currentNotification = null;

    // Modern Dropdown Functionality
    dropdownTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle('active');
        
        // Rotate chevron icon
        const chevron = dropdownTrigger.querySelector('i');
        chevron.style.transform = dropdownMenu.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('active');
            const chevron = dropdownTrigger.querySelector('i');
            chevron.style.transform = 'rotate(0deg)';
        }
        
        // Close notification dropdown
        if (!notifBell.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.remove('active');
        }
    });

    // Play notification sound
    function playNotificationSound() {
        const sound = document.getElementById('notificationSound');
        if (sound) {
            sound.currentTime = 0;
            sound.volume = 0.3;
            sound.play().catch(e => {
                console.log('Audio play failed:', e);
            });
        }
    }

    // Update notification counter
    function updateNotificationCounter() {
        const unreadCount = notifications.filter(notif => notif.unread).length;
        
        if (unreadCount > 0) {
            badgeNotif.textContent = unreadCount;
            badgeNotif.style.display = 'flex';
        } else {
            badgeNotif.style.display = 'none';
        }
    }

    // Save notifications to localStorage
    function saveNotifications() {
        localStorage.setItem('bfp_notifications', JSON.stringify(notifications));
    }

    // Sidebar toggle
    hamburger.addEventListener('click', () => {
        if (window.innerWidth <= 768) sidebar.classList.toggle('open');
        else sidebar.classList.toggle('collapsed');
    });

    // Notification toggle
    notifBell.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('active');
    });

    // Add new notification instantly
    function addNewNotification(notification) {
        // Check if notification already exists
        const existingNotification = notifications.find(notif => 
            notif.id === notification.id || 
            (notif.title === notification.title && notif.created_at === notification.created_at)
        );
        
        if (existingNotification) {
            console.log('Notification already exists:', notification);
            return;
        }

        notification.id = notification.id || Date.now();
        notification.created_at = notification.created_at || new Date().toISOString();
        notification.unread = true;
        
        notifications.unshift(notification);
        renderNotifications();
        updateNotificationCounter();
        saveNotifications();
        
        // Play sound for new notification
        playNotificationSound();
        
        // Show toast notification
        window.globalThemeManager.showToast(`New notification: ${notification.title}`, 'info');
        
        console.log('New notification added:', notification);
    }

    // Fetch notifications from API
    async function fetchNotifications() {
        try {
            const res = await fetch('/api/incidents/latest');
            if (!res.ok) throw new Error('Network response not OK');
            const data = await res.json();

            let newNotifications = false;
            
            // Merge with existing notifications
            data.forEach(apiNotif => {
                const exists = notifications.some(notif => notif.id === apiNotif.id);
                if (!exists) {
                    const newNotif = {
                        id: apiNotif.id,
                        title: apiNotif.title || 'Fire Incident Report',
                        description: apiNotif.description || apiNotif.desc || 'No description available',
                        location: apiNotif.location || 'Unknown location',
                        priority: apiNotif.priority || 'medium',
                        created_at: apiNotif.created_at || new Date().toISOString(),
                        unread: true
                    };
                    notifications.unshift(newNotif);
                    newNotifications = true;
                }
            });

            if (newNotifications) {
                renderNotifications();
                updateNotificationCounter();
                saveNotifications();
                playNotificationSound();
            }
            
        } catch (err) {
            console.error('Error fetching notifications:', err);
        }
    }

    // Render notifications
    function renderNotifications() {
        notifList.innerHTML = '';
        
        if (notifications.length > 0) {
            notifications.forEach((notif, index) => {
                const notifItem = document.createElement('div');
                notifItem.className = `notif-item incident ${notif.unread ? 'unread' : ''}`;
                notifItem.innerHTML = `
                    <div class="notif-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title">${notif.title || 'Fire Incident Report'}</div>
                        <div class="notif-desc">${notif.description || notif.desc || 'No description available'}</div>
                        <div class="notif-meta">
                            <span>${formatTime(notif.created_at)}</span>
                            <div class="notif-actions">
                                <button class="action-btn" onclick="markAsRead(${notif.id})" title="Mark as read">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="action-btn" onclick="removeNotification(${notif.id})" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                notifItem.addEventListener('click', (e) => {
                    if (!e.target.closest('.action-btn')) {
                        markAsRead(notif.id);
                        showNotificationModal(notif);
                    }
                });
                
                notifList.appendChild(notifItem);
            });
        } else {
            notifList.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <p>No new notifications</p>
                    <p class="subtext">We'll notify you when something arrives</p>
                </div>`;
        }
    }

    // Show notification modal
    function showNotificationModal(notification) {
        currentNotification = notification;
        modalTitle.textContent = notification.title || 'Fire Incident Report';
        
        const description = notification.description || 
                           notification.desc || 
                           'No description available';
        
        const location = notification.location || 'Unknown location';
        
        const priority = notification.priority ? 
                        notification.priority.charAt(0).toUpperCase() + notification.priority.slice(1) : 
                        'Not specified';
        
        let reportedAt = 'Invalid Date';
        try {
            if (notification.created_at) {
                const date = new Date(notification.created_at);
                reportedAt = isNaN(date.getTime()) ? 'Invalid Date' : formatDateTime(notification.created_at);
            }
        } catch (e) {
            console.log('Date parsing error:', e);
        }
        
        modalBody.innerHTML = `
            <div class="modal-item">
                <div class="modal-label">Description</div>
                <div class="modal-value">${description}</div>
            </div>
            <div class="modal-item">
                <div class="modal-label">Location</div>
                <div class="modal-value">${location}</div>
            </div>
            <div class="modal-item">
                <div class="modal-label">Priority</div>
                <div class="modal-value">${priority}</div>
            </div>
            <div class="modal-item">
                <div class="modal-label">Reported At</div>
                <div class="modal-value">${reportedAt}</div>
            </div>
        `;
        
        modalActionBtn.textContent = 'View Incident Details';
        if (notification.id) {
            modalActionBtn.onclick = () => {
                window.location.href = `/admin/incidents/${notification.id}`;
            };
            modalActionBtn.style.display = 'block';
        } else {
            modalActionBtn.style.display = 'none';
        }
        
        notifModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Close modal
    function closeModal() {
        notifModal.classList.remove('active');
        document.body.style.overflow = 'auto';
        currentNotification = null;
    }

    // Mark as read by ID
    function markAsRead(id) {
        const notification = notifications.find(notif => notif.id === id);
        if (notification && notification.unread) {
            notification.unread = false;
            renderNotifications();
            updateNotificationCounter();
            saveNotifications();
        }
    }

    // Remove notification by ID
    function removeNotification(id) {
        notifications = notifications.filter(notif => notif.id !== id);
        renderNotifications();
        updateNotificationCounter();
        saveNotifications();
    }

    // Show confirmation modal for clearing all notifications
    function showClearAllConfirmation() {
        confirmationModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Close confirmation modal
    function closeConfirmationModal() {
        confirmationModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Clear all notifications
    confirmClearAll.addEventListener('click', () => {
        notifications = [];
        renderNotifications();
        updateNotificationCounter();
        saveNotifications();
        notifDropdown.classList.remove('active');
        closeConfirmationModal();
        
        // Show success message
        window.globalThemeManager.showToast('All notifications cleared', 'success');
    });

    // Mark all as read
    document.getElementById('markAllRead').addEventListener('click', () => {
        notifications.forEach(notif => notif.unread = false);
        renderNotifications();
        updateNotificationCounter();
        saveNotifications();
        
        // Show success message
        window.globalThemeManager.showToast('All notifications marked as read', 'success');
    });

    // Clear all notifications with confirmation
    document.getElementById('clearNotif').addEventListener('click', () => {
        if (notifications.length === 0) {
            window.globalThemeManager.showToast('No notifications to clear', 'info');
            return;
        }
        showClearAllConfirmation();
    });

    // Utility functions
    function formatTime(dateString) {
        if (!dateString) return 'Unknown time';
        
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return 'Invalid date';
            
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            
            if (diffMins < 1) return 'Just now';
            if (diffMins < 60) return `${diffMins}m ago`;
            if (diffHours < 24) return `${diffHours}h ago`;
            return date.toLocaleDateString();
        } catch (e) {
            return 'Invalid date';
        }
    }

    function formatDateTime(dateString) {
        if (!dateString) return 'Unknown date';
        
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                return 'Invalid Date';
            }
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            return 'Invalid Date';
        }
    }

    // Simulate new notification for testing
    function simulateNewNotification() {
        const newNotif = {
            id: Date.now(),
            title: 'Test Fire Incident',
            description: 'This is a test incident notification',
            location: 'Test Location',
            priority: 'high',
            created_at: new Date().toISOString(),
            unread: true
        };
        addNewNotification(newNotif);
    }

    // Submenu toggle
    function toggleSubmenu(id, btn) {
        const submenu = document.getElementById(id);
        const arrow = btn.querySelector('.arrow');
        if (submenu.style.maxHeight && submenu.style.maxHeight !== "0px") {
            submenu.style.maxHeight = "0";
            arrow.classList.remove('open');
        } else {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
            arrow.classList.add('open');
        }
    }

    // Close modal on backdrop click
    notifModal.addEventListener('click', (e) => {
        if (e.target === notifModal) {
            closeModal();
        }
    });

    // Close confirmation modal on backdrop click
    confirmationModal.addEventListener('click', (e) => {
        if (e.target === confirmationModal) {
            closeConfirmationModal();
        }
    });

    // Initialize notifications
    function initializeNotifications() {
        renderNotifications();
        updateNotificationCounter();
        
        // Add welcome notification if no notifications exist
        if (notifications.length === 0) {
            setTimeout(() => {
                addNewNotification({
                    title: 'Welcome to BFP System',
                    description: 'Your fire incident management system is ready',
                    location: 'System',
                    priority: 'info'
                });
            }, 1000);
        }
    }

    // REAL-TIME PUSHER INTEGRATION - IMPROVED
    function initializeRealTimeUpdates() {
        try {
            if (typeof Pusher === 'undefined') {
                console.error('Pusher is not loaded');
                return;
            }

            const pusherKey = "{{ env('PUSHER_APP_KEY', 'default_key') }}";
            const pusherCluster = "{{ env('PUSHER_APP_CLUSTER', 'mt1') }}";
            
            if (!pusherKey || pusherKey === 'default_key') {
                console.error('Pusher key not configured');
                return;
            }

            console.log('Initializing Pusher with key:', pusherKey, 'cluster:', pusherCluster);

            const pusher = new Pusher(pusherKey, {
                cluster: pusherCluster,
                encrypted: true
            });

            // Subscribe to multiple channels for better compatibility
            const incidentsChannel = pusher.subscribe('incidents');
            const privateChannel = pusher.subscribe('private-incidents');
            
            // Bind to various event names
            incidentsChannel.bind('IncidentReported', function(data) {
                console.log('🔔 IncidentReported event received:', data);
                handleNewIncident(data.incident || data);
            });

            incidentsChannel.bind('incident.reported', function(data) {
                console.log('🔔 incident.reported event received:', data);
                handleNewIncident(data.incident || data);
            });

            incidentsChannel.bind('new-incident', function(data) {
                console.log('🔔 new-incident event received:', data);
                handleNewIncident(data.incident || data);
            });

            privateChannel.bind('IncidentReported', function(data) {
                console.log('🔔 Private IncidentReported event received:', data);
                handleNewIncident(data.incident || data);
            });

            // Connection status monitoring
            
            pusher.connection.bind('disconnected', function() {
                console.log('❌ Pusher disconnected');
            });

            pusher.connection.bind('error', function(err) {
                console.error('❌ Pusher connection error:', err);
            });

            console.log('Pusher real-time updates initialized');

        } catch (error) {
            console.error('Error initializing Pusher:', error);
        }
    }

    // Handle new incident from real-time update
    function handleNewIncident(incident) {
        console.log('🆕 Handling new incident:', incident);
        
        if (!incident) {
            console.error('No incident data received');
            return;
        }

        // Create notification from incident data
        const newNotif = {
            id: incident.id || Date.now(),
            title: incident.title || 'New Fire Incident',
            description: incident.description || incident.desc || 'A new fire incident has been reported',
            location: incident.location || 'Unknown location',
            priority: incident.priority || 'medium',
            created_at: incident.created_at || incident.timestamp || new Date().toISOString(),
            unread: true
        };

        addNewNotification(newNotif);
        
        // Update map if exists
        if (window.addIncidentToMap) {
            window.addIncidentToMap(incident);
        }

        console.log('✅ Incident notification created:', newNotif);
    }

    // Initialize everything when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeNotifications();
        
        // Initialize real-time updates
        initializeRealTimeUpdates();

        // Also fetch notifications from API periodically as backup
        setInterval(fetchNotifications, 30000); // Every 30 seconds

        // Test function - remove in production
        window.testNotification = function() {
            simulateNewNotification();
        };

        console.log('Notification system initialized');
    });

    // Make functions globally available for testing
    window.addNewNotification = addNewNotification;
    window.simulateNewNotification = simulateNewNotification;
    window.playNotificationSound = playNotificationSound;

    </script>

    @yield('scripts')
</body>
</html>