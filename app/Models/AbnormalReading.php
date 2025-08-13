<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbnormalReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'depo_id',
        'nilai_terbaca',
        'catatan',
        'acknowledged_at',
    ];

    public function depo()
    {
        return $this->belongsTo(Depo::class);
    }
}