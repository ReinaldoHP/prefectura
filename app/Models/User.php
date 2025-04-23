<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación con el modelo Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verifica si el usuario es Administrador
     */
    public function isAdmin(): bool
    {
        return $this->role?->nombre  === 'Administrador';
    }

    /**
     * Verifica si el usuario es Coordinador
     */
    public function isCoordinador(): bool
    {
        return $this->role?->nombre  === 'Coordinador';
    }

    public function isRevisoraFiscal(): bool
    {
        return $this->role?->nombre === 'Revisora_Fiscal';
    }

    public function isCaja(): bool
{
    return $this->role?->slug === 'caja';
}



    /**
     * Permitir acceso a Filament solo a usuarios autorizados
     */
    public function canAccessFilament(): bool
{
    return $this->activo && $this->role && in_array($this->role->nombre, [
        'Administrador',
        'Coordinador',
        'Revisora_Fiscal',
        'Caja',
    ]);
}


}
