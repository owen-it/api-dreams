<?php

namespace App\Repositories;


use App\Entity\Dream;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DreamRepository
{
    /**
     * Get dreams with user paginate.
     *
     * @param  integer $n
     * @return collection
     */
    public function getDreamsWithUserPaginate($n, $search = null)
    {
        $dreams = Dream::with('user')
            ->where(function ($query) use ($search) {
                if ($search)
                    $query->where('content', 'like', "%{$search}%");
            })
            ->latest()
            ->simplePaginate($n);

        return $dreams;
    }

    /**
     * Store a dream.
     *
     * @param  array $inputs
     * @param  integer $user_id
     * @return boolean
     */
    public function store($inputs, $user_id)
    {
        $dream = new Dream;
        $dream->content = $inputs['content'];
        $dream->user_id = $user_id;
        $dream->save();
    }

    /**
     * Update a dream.
     *
     * @param  array $inputs
     * @param  integer $id
     * @return boolean
     */
    public function update($inputs, $id)
    {
        $dream = $this->getById($id);

        if ($this->checkUser($dream)) {
            $dream->content = $inputs['content'];
            return $dream->save();
        }
        return false;
    }

    /**
     * Destroy a dream.
     *
     * @param  integer $id
     * @return boolean
     */
    public function destroy($id)
    {
        $dream = $this->getById($id);
        if ($this->checkUser($dream)) {
            return $dream->delete();
        }
        return false;
    }

    /**
     * Get a dream by id.
     *
     * @param  integer $id
     * @return boolean
     */
    public function getById($id)
    {
        return Dream::with('user')->find($id);
    }

    /**
     * Check valid user.
     *
     * @param Dream|\App\Entity\Dream $dream
     * @return bool
     */
    private function checkUser(Dream $dream)
    {
        return Authorizer::getResourceOwnerId() == $dream->user_id;
    }
}