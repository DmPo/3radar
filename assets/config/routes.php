<?php
return array(
    'api' => array(
        '/api(/<action>(/<param1>(/<param2>(/<param3>(/<param4>)))))',
        array(
            'controller' => 'api',
            'action' => 'index'
        ),
    ),
    'admin' => array(
        '/admin(/<action>(/<operation>(/<id>)))',
        array(
            'controller' => 'admin',
            'action' => 'index'
        ),
    ),
    'default' => array(
        '(/<action>(/<id>))',
        array(
            'controller' => 'Pages',
            'action' => 'index'
        ),
    ),
);