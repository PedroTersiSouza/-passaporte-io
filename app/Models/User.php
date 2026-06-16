<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relacionamentos ────────────────────────────────────────────────────

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function inscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user')
                    ->withPivot('ticket_code', 'status')
                    ->withTimestamps();
    }

    // ─── Helpers de perfil ──────────────────────────────────────────────────

    public function isOrganizador(): bool
    {
        return $this->role === 'organizador';
    }

    public function isParticipante(): bool
    {
        return $this->role === 'participante';
    }
}
