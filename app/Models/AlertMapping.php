<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'alert_id',
        'latitude',
        'longitude',
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}
