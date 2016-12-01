<?php

use Phinx\Migration\AbstractMigration;

class ResetToken extends AbstractMigration
{

    public function up()
    {
        $this->table('users')
            ->addColumn('reset_token', 'string', ['null' => true, 'limit' => '255'])
            ->addColumn('token_created_at', 'datetime', ['null' => true])
            ->save();


    }
}
