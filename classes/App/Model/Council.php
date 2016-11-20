<?php

namespace App\Model;

class Council extends \PHPixie\ORM\Model
{
    protected $belongs_to= [
        'district'=> [
            'model'=>'district',
            'key'=>'district_id'
        ]
    ];
}