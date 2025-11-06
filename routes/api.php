<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenAuthController;
use App\Http\Controllers\Api\CitizenDashboardController;
use App\Http\Controllers\Api\AnnouncementApiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AlertController; // ✅ Added for ESP32 alerts
use App\Models\Incident;

/*
|--------------------------------------------------------------------------
| 🌍 Public Routes
|--------------------------------------------------------------------------
*/

// 🔹 Latest incidents endpoint
Route::get('/incidents/latest', function () {
    $incidents = Incident::with('mapping')
        ->latest()
        ->take(5)
        ->get();

    $safeIncidents = $incidents->map(function ($incident) {
        return [
            'id'          => $incident->id,
            'title'       => $incident->title,
            'description' => $incident->description ?? 'No description available',
            'location'    => $incident->location ?? 'Unknown Location',
            'priority'    => $incident->priority ?? 'Not specified',
            'latitude'    => $incident->mapping->latitude ?? null,
            'longitude'   => $incident->mapping->longitude ?? null,
            'created_at'  => $incident->created_at->toDateTimeString(),
        ];
    });

    return response()->json($safeIncidents);
});

// 🔹 Mark notifications as read
Route::post('/incidents/mark-read', [NotificationController::class, 'markRead']);

/*
|--------------------------------------------------------------------------
| 🚨 ESP32 Sensor Alert Endpoint
|--------------------------------------------------------------------------
| The ESP32 (fire/smoke sensors) will send POST requests here.
| Example JSON:
| {
|   "type": "fire",
|   "message": "Flame detected!",
|   "device_id": 1
| }
|--------------------------------------------------------------------------
*/
Route::post('/alerts', [AlertController::class, 'apiStore']);

/*
|--------------------------------------------------------------------------
| 👥 Citizen Routes (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('citizen')->group(function () {
    Route::post('/register', [CitizenAuthController::class, 'register']);
    Route::post('/login', [CitizenAuthController::class, 'login']);
    Route::get('/announcements', [AnnouncementApiController::class, 'index']);
    Route::get('/citizen/latest-announcement', [CitizenDashboardController::class, 'getLatestAnnouncement']);
    // 🔥 Public report endpoint
    Route::post('/public-report', [CitizenDashboardController::class, 'storeIncidentPublic']);

    // 🚨 Public alerts
    Route::get('/alerts', [CitizenDashboardController::class, 'alerts']);

    // 📊 Public reports filtered by user ID
    Route::get('/my-reports/{user_id}', [CitizenDashboardController::class, 'getUserReportsPublic']);

    // 🔐 Google Mobile Login
    Route::post('/auth/google/mobile', [CitizenAuthController::class, 'googleMobileLogin']);
});

/*
|--------------------------------------------------------------------------
| 🔒 Protected Routes (Citizen needs token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('citizen')->group(function () {
    Route::post('/logout', [CitizenAuthController::class, 'logout']);
    Route::get('/profile', [CitizenDashboardController::class, 'profile']);
    Route::post('/report', [CitizenDashboardController::class, 'storeIncident']);
    Route::get('/incidents', [CitizenDashboardController::class, 'listIncidents']);
    Route::get('/my-reports', [CitizenDashboardController::class, 'myReports']);
});