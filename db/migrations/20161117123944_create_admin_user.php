<?php

use Phinx\Migration\AbstractMigration;

class CreateAdminUser extends AbstractMigration
{

    public function change()
    {
        $data = [
            [
                'first_name' => 'admin',
                'last_name' => 'adminchenko',
                'password' => '4634b1fc62882d7d8a8bc267bfe65171:1468511421556c595891f40',
                'email' => 'admin@admin',
                'staff' => 1,
            ],

        ];

        $this->table('users')->insert($data)->save();
    }
}
