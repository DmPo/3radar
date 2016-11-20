<?php

namespace App\Model;

class User extends \PHPixie\ORM\Model
{
    protected $has_many = [

        'campaigns' => [
            'model' => 'campaign',
            'through' => 'campaign_members',
            'key' => 'user_id',
            'foreign_key' => 'campaign_id'
        ],
        'my_campaigns' => [
            'model' => 'campaign',
            'key' => 'author_id',
        ]
    ];
}