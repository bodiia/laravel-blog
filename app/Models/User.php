<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Model implements Authenticatable, CanResetPassword, Authorizable
{
    use HasFactory;
    use Notifiable;
    use \Illuminate\Auth\Authenticatable;
    use \Illuminate\Auth\Passwords\CanResetPassword;
    use \Illuminate\Foundation\Auth\Access\Authorizable;

    public const DEFAULT_PICTURE = 'profile_pics/default_profile_picture.png';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function getProfilePictureAttribute()
    {
        if (! $this->attributes['profile_picture']) {
            return static::DEFAULT_PICTURE;
        }
        return $this->attributes['profile_picture'];
    }
}
