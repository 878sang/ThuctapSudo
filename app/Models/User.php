<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'display_name', 'email', 'password', 'phone', 'dob', 'gender', 'role', 'avatar', 'type'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_STAFF = 'staff';
    const ROLE_CUSTOMER = 'customer';

    /**
     * Check if the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if the user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Check if the user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
    public function likedReviews()
    {
        return $this->belongsToMany(Review::class, 'review_likes', 'user_id', 'review_id')->withTimestamps();
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('storage/avatars/' . $this->avatar) : (file_exists(public_path('storage/images/avatar_placeholder.png')) ? asset('storage/images/avatar_placeholder.png') : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=DDECFF&color=006DF0&size=128');
    }
    public function getPointsAttribute(): int
    {
        return 1560;
    }
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
            'dob' => 'date',
        ];
    }
}
