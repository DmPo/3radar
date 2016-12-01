<?php

use Phinx\Migration\AbstractMigration;

class UserOauth extends AbstractMigration
{

    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('oauth_provider', 'string', ['null'=> false, 'default'=> 'password', 'limit'=>'255']);
        $table->addColumn('oauth_uid', 'string', ['null'=> true, 'limit'=>'255']);
        $table->addColumn('social_link', 'string', ['null'=> true, 'limit'=>'255']);
        $table->save();
    }
}
