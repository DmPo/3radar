<?php

use Phinx\Migration\AbstractMigration;

class AddUser extends AbstractMigration
{

    public function up()
    {
       // $this->createDatabase('civicos_db', [])->save();

        $users = $this->table('users');
        $users
            ->addColumn('password', 'string', ['limit' => 500])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('first_name', 'string', ['limit' => 50])
            ->addColumn('last_name', 'string', ['limit' => 50])
            ->addColumn('phone', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('staff', 'boolean', ['default' => false])
            ->addColumn('last_sign_in', 'datetime', ['null' => true])
            ->addColumn('sign_in_count', 'integer', ['null' => true])
            ->addTimestamps()
            ->addIndex(array('email'), ['unique' => true])
            ->save();
    }

    public function down()
    {
        $this->table('users')->drop();
    }
}
