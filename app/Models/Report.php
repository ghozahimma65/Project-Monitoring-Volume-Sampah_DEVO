<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Report extends Model
{
    protected $fillable = [
        'report_id',
        'depo_id',
        'tanggal_laporan', 
        'kategori',
        'deskripsi',
        'foto',
        'status',
        'admin_response',
        'resolved_at'
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
        'resolved_at' => 'datetime',
        'foto' => 'array'
    ];

    public function depo()
    {
        return $this->belongsTo(Depo::class, 'depo_id');belongsTo(Depo::class);
    }
    
    // Generate report ID otomatis
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($report) {
            if (empty($report->report_id)) {
                $lastReport = static::whereYear('created_at', date('Y'))
                    ->orderBy('id', 'desc')
                    ->first();
                
                $number = $lastReport ? (int)substr($lastReport->report_id, -3) + 1 : 1;
                $report->report_id = 'RPT-' . date('Y') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}