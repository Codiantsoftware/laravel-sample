<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // User types
    public const TYPE_ADMIN = 'admin';
    public const TYPE_USER = 'user';

    // User statuses
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    // Verification types
    public const VERIFY_TYPE_REGISTER = 'registration';
    public const VERIFY_TYPE_RESET = 'reset-password';
    public const VERIFY_TYPE_OTP = 'otp-verification';

    // Array of OTP verification types
    public static $otpTypes = [
        self::VERIFY_TYPE_REGISTER,
        self::VERIFY_TYPE_RESET,
        self::VERIFY_TYPE_OTP,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'profile_image',
        'phone_code',
        'phone_number',
        'status',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_image_url',
    ];

    /**
     * Default attribute values.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_INACTIVE,
    ];

    /**
     * Set the user's password attribute.
     *
     * @param string $value The password value
     * 
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the user's profile image URL attribute.
     *
     * @return string
     */
    public function getProfileImageUrlAttribute()
    {
        if (filter_var($this->profile_image, FILTER_VALIDATE_URL)) {
            $url = $this->profile_image;
        } else {
            $url = getImageUrl($this->profile_image);
        }

        return $url;
    }

    /**
     * Scope a query to filter users by status.
     *
     * @param Builder     $query  The query builder
     * @param string|null $status The status value
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status = null)
    {
        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope a query to exclude admin users.
     *
     * @param Builder $query The query builder
     * 
     * @return Builder
     */
    public function scopeNotAdmin($query)
    {
        return $query->where('user_type', '<>', User::TYPE_ADMIN);
    }

    /**
     * Scope a query to include only admin users.
     *
     * @param Builder $query The query builder
     * 
     * @return Builder
     */
    public function scopeOnlyAdmin($query)
    {
        return $query->where('user_type', User::TYPE_ADMIN);
    }

    /**
     * Check if the user is verified.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return null !== $this->email_verified_at;
    }
}
