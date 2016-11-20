<?php

use Phinx\Migration\AbstractMigration;

class UpdateCampaignMembers extends AbstractMigration
{
    public function change()
    {
        $this->table('campaign_member')->rename('campaign_members')->save();
    }
}
