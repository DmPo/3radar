<?php

namespace App\Model;

class District extends \PHPixie\ORM\Model
{
    protected $belongs_to= [
        'region'=> [
            'model'=>'region',
            'key'=>'region_id'
        ]
    ];

}