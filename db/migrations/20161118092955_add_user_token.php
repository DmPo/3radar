<?php

use Phinx\Migration\AbstractMigration;

class AddUserToken extends AbstractMigration
{
    public function change()
    {
        $users = $this->table('users');
        $users
            ->addColumn('token', 'string', ['null' => true, 'limit'=>'255'])
            ->save();
    }
}
