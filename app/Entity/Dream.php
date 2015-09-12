<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
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
     * The belongsTo relation.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * is_owner mutator.
     *
     */
    public function getIsOwnerAttribute()
    {
        return (int) $this->attributes['user_id'] === (int) Authorizer::getResourceOwnerId();
    }

    /**
     * @return mixed
     */
    public function getElapsedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

}
