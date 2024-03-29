<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function getFirstNameAttribute()
    {
        return Str::of($this->name)->trim()->split('/ /')[0];
    }

    public function searchNotecards($term)
    {
        if(strlen($term) < 3) return null;

        $likeTerm = '%' . $term . '%';

        return $this->notecards()
            ->where(function ($query) use ($likeTerm) {
                $query
                    ->where('title', 'like', $likeTerm)
                    ->orWhere('markdown', 'like', $likeTerm)
                    ->orWhereHas('folder', function ($query) use ($likeTerm) {
                        return $query->where('name', 'like', $likeTerm);
                    });
            })
            ->inOrder()
            ->get();
    }

    public function folders()
    {
        return $this->hasMany('App\Models\Folder');
    }

    public function notecards()
    {
        return $this->hasManyThrough('App\Models\Notecard', 'App\Models\Folder');
    }

    public function collections()
    {
        return $this->hasMany('App\Models\Collection');
    }
}
