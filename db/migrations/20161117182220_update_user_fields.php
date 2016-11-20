<?php

use Phinx\Migration\AbstractMigration;

class UpdateUserFields extends AbstractMigration
{

    public function change()
    {
        $users = $this->table('users');
        $users
            ->addColumn('region_id', 'integer', ['null' => true])
            ->addForeignKey('region_id', 'regions')
            ->save();
    }
}
