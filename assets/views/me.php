<?php include 'layout.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">Мої кампанії</div>
                <div class="panel-body">
                    <ul class="media-list">
                        <?php foreach ($user->my_campaigns->find_all() as $campaign):?>
                        <li class="media">
                            <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted"><?=date('d.m.Y H:i:s',strtotime($campaign->created_at))?></small>
                                </span>
                                <a href="/campaigns/<?=$campaign->id?>">
                                    <strong class="text-success"><?=$campaign->council->major_name?> -</strong>
                                </a>
                                <p>
                                    <?= $campaign->council->district->region->name ?> /
                                    <?= $campaign->council->district->name ?> /
                                    <?= $campaign->council->name ?>
                                </p>
                                <p><?=$campaign->reason?></p>
                                <span class=" pull-right">
                                    <small>Приєдналося <?=$campaign->members->count_all()?> людей</small>
                                </span>
                            </div>
                            <hr>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">Кампанії в яких я приймаю учать</div>
                <div class="panel-body">
                    <ul class="media-list">
                        <?php foreach ($user->campaigns->find_all() as $campaign):?>
                            <li class="media">
                                <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted"><?=date('d.m.Y H:i:s',strtotime($campaign->created_at))?></small>
                                </span>
                                    <a href="/campaigns/<?=$campaign->id?>">
                                        <strong class="text-success"><?=$campaign->council->major_name?> </strong>
                                    </a>
                                    <p><?=$campaign->reason?></p>
                                    <p>
                                        <?= $campaign->council->district->region->name ?> /
                                        <?= $campaign->council->district->name ?> /
                                        <?= $campaign->council->name ?>
                                    </p>
                                    <span class=" pull-right">
                                    <small>Приєдналося <?=$campaign->members->count_all()?> людей</small>
                                </span>
                                </div>
                                <hr>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
