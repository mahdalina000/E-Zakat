<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'admin_type', 'is_active', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'admin_upz', 'admin_baznas'], true);
    }

    public function isAdminBaznas(): bool
    {
        return $this->role === 'admin_baznas';
    }

    public function isAdminUpz(): bool
    {
        return $this->role === 'admin_upz';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];
        if (in_array('admin', $roles, true) && $this->isAdmin()) {
            return true;
        }
        return in_array($this->role, $roles, true);
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin (Pemko)',
            'admin_baznas' => 'Admin BAZNAS',
            'admin_upz' => 'Admin UPZ',
            'admin' => 'Admin UPZ/BAZNAS',
            'user' => 'User',
            default => ucfirst($this->role),
        };
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'created_by');
    }

    public function loginActivities()
    {
        return $this->hasMany(LoginActivity::class);
    }

    public function wargaProfile()
    {
        return $this->hasOne(WargaProfile::class, 'user_id');
    }

    public function zakatRecords()
    {
        return $this->hasMany(ZakatRecord::class, 'user_id');
    }

    public function calculationHistories()
    {
        return $this->hasMany(CalculationHistory::class, 'user_id');
    }

    public function heirs()
    {
        return $this->hasMany(Heir::class, 'user_id');
    }
}
