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
     * Log custom message
     */
    public static $logCustomMessage = '{user.name|Anonymous} {type} a dream {elapsed_time}';

    /**
     * Log custom fields message
     */
    public static $logCustomFields = [
        'content'  => ' Is now dreaming of "{new_value.content|old_value.content}"',
        'user_id' => [
            'updated' => '{||ownerName} owns the dream',
            'created' => '{owner.user.name} was defined as owner'
        ],
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
    
    /**
     * @param $log
     * @return string
     */
    public function ownerName($log)
    {
        return $log->owner->user->name;
    }

}
