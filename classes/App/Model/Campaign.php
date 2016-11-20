<?php

namespace App\Model;

class Campaign extends \PHPixie\ORM\Model
{
    protected $belongs_to = [
        'author' => [
            'model' => 'user',
            'key' => 'author_id'
        ],
        'council' => [
            'model' => 'council',
            'key' => 'council_id'
        ]
    ];
    protected $has_many = array(
        'members' => array(
            'model' => 'campaign_member',
            'key' => 'campaign_id'
        )
    );

}