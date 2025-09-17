<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
    ];

    // Mutator for hashing passwords on set
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value ? bcrypt($value) : null
        );
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function isAdmin(): bool { return $this->role === UserRole::ADMIN; }
    public function isResponder(): bool { return $this->role === UserRole::RESPONDER; }
}
