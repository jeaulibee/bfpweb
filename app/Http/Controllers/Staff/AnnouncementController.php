<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements for staff.
     */
    public function index()
    {
        // Fetch latest announcements, newest first
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(10);

        return view('staff.announcements.index', compact('announcements'));
    }

    /**
     * Display a single announcement for staff.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Get related announcements (latest 3 announcements excluding current one)
        $relatedAnnouncements = Announcement::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('staff.announcements.show', compact('announcement', 'relatedAnnouncements'));
    }
}