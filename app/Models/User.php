<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    /**
     * Hak akses ke Filament Panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            // Admin, Student, dan Staff BISA mengakses login page Admin
            return $this->hasAnyRole(['admin', 'student', 'staff']);
        }

        if ($panel->getId() === 'student') {
            return $this->hasRole('student');
        }

        if ($panel->getId() === 'staff') {
            return $this->hasRole('staff');
        }

        return false;
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function AssetReturn()
    {
        return $this->hasMany(AssetReturn::class);
    }
}
