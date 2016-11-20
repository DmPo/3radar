<?php
$phinx_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../phinx.yml'));
$default_bd = $phinx_conf['environments']['default_database'];
$db_settings = $phinx_conf['environments'][$default_bd];
return array(
    'default' => array(
        'user' => $db_settings['user'],
        'password' => $db_settings['pass'],
        'driver' => 'PDO',
        'connection' => $db_settings['adapter'] . ':host=' . $db_settings['host'] . ';dbname=' . $db_settings['name'],
	)
);
