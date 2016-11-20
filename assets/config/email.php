<?php
return array(
    'default' => array(
        'type' => 'smtp',

        'hostname' => 'klasttuft.com',
        'port' => '587',
        'username' => "info@klasttuft.com",
        'password' => "M8Q23TDvT1",
        'timeout' => null,

        'sendmail_command' => null,

        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ),
        'mail_parameters' => null
    )
);