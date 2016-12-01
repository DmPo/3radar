<?php

use Phinx\Migration\AbstractMigration;

class AddOauthTokens extends AbstractMigration
{

    public function up()
    {
        $table = $this->table('users');
        $table->addColumn('oauth_token', 'string', ['null'=> true, 'limit'=>'255']);
        $table->save();
    }
}
