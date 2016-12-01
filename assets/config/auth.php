<?php
return [
    'default' => [
        'model' => 'user',
        'login' => [
            'password' => [
                'login_field' => 'email',
                'password_field' => 'password',
                'login_token_field' => 'token'
            ]
        ]
    ]
];