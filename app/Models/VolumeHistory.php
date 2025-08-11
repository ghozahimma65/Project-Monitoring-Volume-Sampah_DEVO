<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'volume_history';

    protected $fillable = [
        'depo_id',
        'volume',
        'persentase',
        'status',
        'recorded_at',
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'persentase' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    // Relationships
    public function depo()
    {
        return $this->belongsTo(Depo::class);
    }
}