<?php

use Phinx\Migration\AbstractMigration;

class UpdateUser extends AbstractMigration
{

    public function change()
    {
        $this->query("UPDATE users SET sign_in_count = 0;");
        $this->table('users')->changeColumn('sign_in_count', 'integer', ['default' => 0])->save();
    }
}
