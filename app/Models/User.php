<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function conselhos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Conselho::class, 'conselho_user');
    }

    public function termAcceptances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TermAcceptance::class);
    }

    public function hasAcceptedTerms(?int $conselhoId = null): bool
    {
        $version = config('terms.version', '1.0');

        return $this->termAcceptances()
            ->where('version', $version)
            ->when($conselhoId, function ($query, $id) {
                return $query->where('conselho_id', $id);
            }, function ($query) {
                return $query->whereNull('conselho_id');
            })
            ->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'user') {
            return $this->conselhos()->exists();
        }

        return false;
    }

    public function getTenants(Panel $panel): array|\Illuminate\Support\Collection
    {
        return $this->conselhos;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->conselhos->contains($tenant);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'terms_accepted_at',
        'tipo_representante',
        'oidc_sub',
        'auth_server_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms_accepted_at' => 'datetime',
        ];
    }
}
