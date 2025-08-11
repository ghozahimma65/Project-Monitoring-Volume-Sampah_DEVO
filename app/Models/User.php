<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        // Debug: Ensure role exists and check value
        return isset($this->role) && $this->role === 'admin';
    }

    /**
     * Check if the user is a super admin
     */
    public function isSuperAdmin(): bool
    {
        return isset($this->role) && $this->role === 'super_admin';
    }

    /**
     * Get user role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role ?? 'user') {
            'admin' => 'Administrator',
            'super_admin' => 'Super Administrator', 
            'user' => 'User',
            default => 'Unknown'
        };
    }
}