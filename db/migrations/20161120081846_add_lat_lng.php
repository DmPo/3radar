<?php

use Phinx\Migration\AbstractMigration;

class AddLatLng extends AbstractMigration
{

    public function change()
    {
        $this->table('districts')
            ->addColumn('lat', 'string', ['null' => true, 'limit' => '255'])
            ->addColumn('lng', 'string', ['null' => true, 'limit' => '255'])
            ->save();
    }
}
