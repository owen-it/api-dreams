<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use OwenIt\Auditing\Auditing;

class Dream extends Auditing
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dreams';

    /**
     * Added attribute
     *
     * @var array
     */
    protected $appends = ['is_owner', 'elapsed_time'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'user_id'];
    
    /**
     * Custom message
     * 
     * @var string
     */
    public static $customMessage = 'Dream {type} by ';

    /**
     * Custom fields
     * 
     * @var array
     */
    public static $customFields = [
        'content' => ' is now dreaming of "{new}".'
    ];

    /**
     * The belongsTo relation.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get owner
     * is_owner mutator.
     *
     * @return mixed
     */
    public function getIsOwnerAttribute()
    {
        return (int) $this->attributes['user_id'] === (int) Authorizer::getResourceOwnerId();
    }

    /**
     * Get Elapsed time
     *
     * @return mixed
     */
    public function getElapsedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

}
