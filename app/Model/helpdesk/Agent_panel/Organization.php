<?php

namespace App\Model\helpdesk\Agent_panel;

use App\BaseModel;

class Organization extends BaseModel
{
    /* define the table name */

    protected $table = 'organization';

    /* Define the fillable fields */
    protected $fillable = ['id', 'name', 'phone', 'website', 'address', 'head', 'internal_notes'];

    public function userRelation()
    {
        $related = \App\Model\helpdesk\Agent_panel\User_org::class;

        return $this->hasMany($related, 'org_id');
    }

    public function getUserIds()
    {
        $user_relations = $this->userRelation()->pluck('user_id')->toArray();

        return $user_relations;
    }

    public function users()
    {
        $user = new \App\User();
        $user_ids = $this->getUserIds();
        $users = $user->whereIn('id', $user_ids);

        return $users;
    }
}
