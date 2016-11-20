<?php

use Phinx\Migration\AbstractMigration;

class CiviosDump extends AbstractMigration
{

    public function up()
    {
        $phinx_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('phinx.yml'));
        $default_bd = $phinx_conf['environments']['default_database'];
        $db_settings = $phinx_conf['environments'][$default_bd];
        $pass = $db_settings['pass'];
        $name = $db_settings['name'];
        $user = $db_settings['user'];
        $host = $db_settings['host'];
        shell_exec("export PGPASSWORD='$pass'; psql -h $host -d $name -U $user -f ". realpath('db/civic.sql') . PHP_EOL);
    }

    public function down()
    {

    }
}
