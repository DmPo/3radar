<?php
return array(
    'default' => array(
        'model' => 'user',
        'login' => array(
            'password' => array(
                'login_field' => 'email',
                'password_field' => 'password',
                'login_token_field' => 'token'
            ),
        ),
    )
);