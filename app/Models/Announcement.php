<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',   // content of the announcement
        'status',    // e.g., 'active', 'inactive'
        'created_by' // admin user who created it
    ];

    /**
     * Get the user who created the announcement
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
