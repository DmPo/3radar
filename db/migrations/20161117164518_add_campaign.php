<?php

use Phinx\Migration\AbstractMigration;

class AddCampaign extends AbstractMigration
{

    public function change()
    {
        $table = $this->table('campaigns');
        $table
            ->addColumn('author', 'integer', ['null' => false])
            ->addForeignKey('author', 'users')
            ->addColumn('council_id', 'integer', ['null' => false])
            ->addForeignKey('council_id', 'councils')
            ->addColumn('reason', 'text', ['null' => true])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('literature', 'boolean', ['default' => false])
            ->addColumn('training', 'boolean', ['default' => false])
            ->addColumn('subscribing', 'boolean', ['default' => false])
            ->addTimestamps()
            ->save();
    }
}
