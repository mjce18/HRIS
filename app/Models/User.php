<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'phone',
        'status',
        'account_activated',
        'activation_token',
        'activation_token_expires_at',
        'profile_picture',
        'last_seen',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'account_activated' => 'boolean',
            'activation_token_expires_at' => 'datetime',
            'last_seen' => 'datetime',
        ];
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function unreadMessages()
    {
        return $this->receivedMessages()->where('is_read', false);
    }

    /**
     * Check if user is online (active within last 5 minutes)
     */
    public function isOnline()
    {
        if (!$this->last_seen) {
            return false;
        }
        
        return $this->last_seen->gt(now()->subMinutes(5));
    }

    /**
     * Get user's online status as string
     */
    public function getOnlineStatus()
    {
        if ($this->isOnline()) {
            return 'online';
        }

        if (!$this->last_seen) {
            return 'offline';
        }

        // Show "away" if last seen within 30 minutes
        if ($this->last_seen->gt(now()->subMinutes(30))) {
            return 'away';
        }

        return 'offline';
    }

    /**
     * Get formatted last seen time
     */
    public function getLastSeenFormatted()
    {
        if (!$this->last_seen) {
            return 'Never';
        }

        if ($this->isOnline()) {
            return 'Online';
        }

        return $this->last_seen->diffForHumans();
    }
}
