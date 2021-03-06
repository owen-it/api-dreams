<?php

namespace App\Entity;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use OwenIt\Auditing\Auditing;

class User extends Auditing implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Added attribute
     *
     * @var array
     */
    protected $appends = ['gravatar', 'elapsed_time'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * @var string
     */
    public static $logCustomMessage = 'User {new.name|empty} {type} ';
    
    /**
     * @var array
     */
    public static $logCustomFields = [
        'name'  => 'The name was defined as {new.name}',
        'email'  => 'The email was defined as {new.email}',
    ];

    /**
     * Dreams of user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dreams()
    {
        return $this->hasMany(Dream::class);
    }

    /**
     * HASH image gravatar
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return md5(strtolower(trim($this->email ?: 'default')));
    }
    
    /**
     * Elapsed time
     * 
     * @return mixed
     */
    public function getElapsedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
