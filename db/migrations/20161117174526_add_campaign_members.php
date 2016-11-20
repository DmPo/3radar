<?php

use Phinx\Migration\AbstractMigration;

class AddCampaignMembers extends AbstractMigration
{

    public function change()
    {
        $table = $this->table('campaign_member');
        $table
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addForeignKey('user_id', 'users')
            ->addColumn('campaign_id', 'integer', ['null' => false])
            ->addForeignKey('campaign_id', 'campaigns')
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('subscribing', 'boolean', ['default' => false])
            ->addTimestamps()
            ->save();
    }
}
