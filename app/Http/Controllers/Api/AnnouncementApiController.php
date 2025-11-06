<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementApiController extends Controller
{
    /**
     * 📢 Get active announcements (PUBLIC)
     */
    public function index()
    {
        $announcements = Announcement::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'message as content', 'created_at']);

        return response()->json($announcements, 200);
    }
}