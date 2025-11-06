<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ========================
// Controllers
// ========================
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;

// Admin Controllers
use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\Admin\MappingController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\AlertMappingController;

// Staff Controllers
use App\Http\Controllers\Staff\IncidentController as StaffIncidentController;
use App\Http\Controllers\Staff\MappingController as StaffMappingController;
use App\Http\Controllers\Staff\DeviceController as StaffDeviceController;
use App\Http\Controllers\Staff\AlertController as StaffAlertController;
use App\Http\Controllers\Staff\AnnouncementController as StaffAnnouncementController;

// Google Auth Controller
use App\Http\Controllers\Auth\GoogleController;

// Forgot Password (OTP) Controller
use App\Http\Controllers\Auth\ForgotPasswordController;

// ========================
// Landing Page
// ========================
Route::get('/', fn() => view('landing.index'))->name('landing');

// ========================
// Google Login Routes
// ========================
Route::get('/auth/google/admin', [GoogleController::class, 'redirectToGoogleAdmin'])->name('google.redirect.admin');
Route::get('/auth/google/staff', [GoogleController::class, 'redirectToGoogleStaff'])->name('staff.google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// ========================
// Forgot Password (OTP) Routes
// ========================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password.form');
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.sendOtp');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verifyOtp');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset.password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.resetPassword');
Route::post('/password/resend-otp', [AuthController::class, 'resendOtp'])->name('password.resendOtp');

// ========================
// Global Heartbeat Route
// ========================
Route::post('/user/heartbeat', [AuthController::class, 'heartbeat'])->name('user.heartbeat');

// ========================
// Admin Routes
// ========================
Route::prefix('admin')->group(function () {
    // --- Auth ---
    Route::get('login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::get('register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('register', [AuthController::class, 'adminRegister'])->name('admin.register.submit');
    
    // --- Protected Admin Routes ---
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // --- Incidents ---
        Route::resource('incidents', IncidentController::class, ['as' => 'admin']);
        Route::put('/incidents/{id}/complete', [IncidentController::class, 'complete'])->name('admin.incidents.complete');
        Route::post('/incidents/bulk-delete', [IncidentController::class, 'bulkDelete'])->name('admin.incidents.bulk-delete');
        Route::put('/incidents/bulk-complete', [IncidentController::class, 'bulkComplete'])->name('admin.incidents.bulk-complete');
        Route::post('/incidents/{incident}/quick-update', [IncidentController::class, 'quickUpdate'])->name('admin.incidents.quick-update');
        Route::get('/incidents/{incident}/timeline', [IncidentController::class, 'timeline'])->name('admin.incidents.timeline');
        Route::get('/incidents/{incident}/check-updates', [IncidentController::class, 'checkUpdates'])->name('admin.incidents.check-updates');

        // --- Maps ---
        Route::get('/maps', [MapController::class, 'index'])->name('admin.maps.index');
        Route::post('/incidents/map', [IncidentController::class, 'storeMap'])->name('admin.incidents.store.map');

        // --- Mapping ---
        Route::resource('mapping', MappingController::class, ['as' => 'admin']);

        // --- ALERT MAPPINGS TABLE ---
        Route::resource('alert-mappings', AlertMappingController::class, ['as' => 'admin']);

        // --- ALERT MAPPING (for Leaflet Map) ---
        Route::get('/alert-mapping', [AlertMappingController::class, 'index'])->name('admin.alertmapping.index');
        Route::get('/api/alert-mapping', [AlertMappingController::class, 'getAlertMappings'])->name('admin.alertmapping.api');

        // --- Devices & Alerts ---
        Route::resource('devices', DeviceController::class, ['as' => 'admin']);
        // ADD THIS LINE FOR DEVICE STATUS UPDATES
        Route::put('/devices/{device}/status', [DeviceController::class, 'updateStatus'])->name('admin.devices.status');
        
        Route::resource('alerts', AlertController::class, ['as' => 'admin']);
        Route::post('/api/alerts', [AlertController::class, 'apiStore']);

        // --- Staff Management ---
        Route::resource('staff', AdminStaffController::class, ['as' => 'admin']);
        Route::get('/staff/fetch', [AdminStaffController::class, 'fetchStaff'])->name('admin.staff.fetch');

        // --- Users Management ---
        Route::resource('users', UsersController::class, ['as' => 'admin']);
        Route::get('/users/status/{id}', [UsersController::class, 'status'])->name('admin.users.status');
        Route::get('/users/statuses', [UsersController::class, 'allStatuses'])->name('admin.users.statuses');

        // --- Announcements ---
        Route::resource('announcements', AnnouncementController::class, ['as' => 'admin']);

        // --- Settings ---
        Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('admin.settings.update');

        // --- API for Maps ---
        Route::get('/api/incidents/map', [IncidentController::class, 'getIncidentsForMap'])->name('admin.incidents.map.api');
        Route::get('/api/maps/incidents', [MapController::class, 'getIncidentsForMap'])->name('admin.maps.incidents.api');
        Route::get('/api/maps/incidents/filter', [MapController::class, 'filterIncidents'])->name('admin.maps.incidents.filter');
        Route::get('/api/maps/incidents/search', [MapController::class, 'searchIncidents'])->name('admin.maps.incidents.search');
        Route::get('/api/maps/incidents/clusters', [MapController::class, 'getIncidentClusters'])->name('admin.maps.incidents.clusters');
        Route::get('/api/maps/stats', [MapController::class, 'getMapStats'])->name('admin.maps.stats');
    });
});

// ========================
// Staff Routes
// ========================
Route::prefix('staff')->group(function () {
    // --- Auth ---
    Route::get('login', [AuthController::class, 'showStaffLogin'])->name('staff.login');
    Route::post('login', [AuthController::class, 'staffLogin'])->name('staff.login.submit');
    Route::get('register', [AuthController::class, 'showStaffRegister'])->name('staff.register');
    Route::post('register', [AuthController::class, 'staffRegister'])->name('staff.register.submit');

    // --- Protected Staff Routes ---
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');

        // --- Incidents ---
        Route::resource('incidents', StaffIncidentController::class)
            ->names('staff.incidents')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::put('/incidents/{id}/complete', [StaffIncidentController::class, 'complete'])->name('staff.incidents.complete');
        Route::post('/incidents/{incident}/quick-update', [StaffIncidentController::class, 'quickUpdate'])->name('staff.incidents.quick-update');
        Route::get('incidents/map', [StaffIncidentController::class, 'map'])->name('staff.incidents.map');
        Route::get('/api/incidents/map', [StaffIncidentController::class, 'getIncidentsForMap'])->name('staff.incidents.map.api');

        // --- Devices ---
        Route::resource('devices', StaffDeviceController::class)->names('staff.devices')->only(['index', 'show']);

        // --- Alerts ---
        Route::resource('alerts', StaffAlertController::class)->names('staff.alerts')->only(['index', 'show']);
        Route::post('alerts/{alert}/mark-read', [StaffAlertController::class, 'markRead'])->name('staff.alerts.markRead');

        // --- Mapping ---
        Route::resource('mapping', StaffMappingController::class)->names('staff.mapping')->only(['index']);

        // --- Announcements ---
        Route::resource('announcements', StaffAnnouncementController::class)->names('staff.announcements')->only(['index', 'show']);

        // --- Staff User Status ---
        Route::get('/users/statuses', [UsersController::class, 'allStatuses'])->name('staff.users.statuses');
    });
});

// ========================
// Global API Routes
// ========================
Route::prefix('api')->group(function () {
    Route::get('/incidents/map', [IncidentController::class, 'getIncidentsForMap'])->name('api.incidents.map');
    Route::get('/users/statuses', [UsersController::class, 'allStatuses'])->name('api.users.statuses');
});

// ========================
// Global Logout
// ========================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');