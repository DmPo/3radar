<?php

use Phinx\Migration\AbstractMigration;

class UpdateCouncils extends AbstractMigration
{

    public function up()
    {
        $this->execute('TRUNCATE public.campaign_members CASCADE;');
        $this->execute('TRUNCATE public.campaigns CASCADE;');
        $this->execute('TRUNCATE public.councils CASCADE;');
        $this->execute(file_get_contents('db/n_councils.sql'));
    }
}
