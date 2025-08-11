<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'data',
        'created_at',
        'is_read',
        'target_audience',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('target_audience', 'admin');
    }

    public function scopeForPublic($query)
    {
        return $query->where('target_audience', 'public');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
}