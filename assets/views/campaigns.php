<?php include 'layout.php'; ?>

<div class="container" ng-app="ZradarApp" ng-controller="campaignCtrl">
    <?php if(!$single_company):?>
    <h3 class="h3 text-center">Existing campaigns</h3>
    <section class="section-map">
        <div id="map"></div>
    </section>
    <?php endif;?>
    <?php foreach ($campaigns as $campaign): ?>
        <div class="panel panel-default" id="<?= $campaign->id?>">
            <div class="panel-body">
                <h4 class="h4"><?= $campaign->council->major_name ?></h4>
                <p>
                    <?= $campaign->council->district->region->name ?> /
                    <?= $campaign->council->district->name ?> /
                    <?= $campaign->council->name ?>
                </p>
                <p> <?= $campaign->council->major_bio ?></p>
                <p>
                    <strong>In the office since </strong><?= $campaign->council->selection_date ?>
                </p>
                <p>
                    <strong>Campaign reason:</strong>
                    <?= $campaign->reason ?>
                </p>
                <p style="font-size: 14px; font-weight: normal;">
                    <strong>Details:</strong>
                    <?= $campaign->description ?>
                </p>
                <span class="pull-right">
                    Participating:
                    <label class="badge"><?= $campaign->members->count_all() ?></label>
                </span>
                <?php if (!$campaign->members->where('user_id', $user->id)->find()->loaded() && $campaign->author->id != $user->id): ?>
                    <button class="btn btn-default" data-toggle="modal" data-target="#join-modal"
                            ng-click="select_campaign(<?= $campaign->id ?>)">Join
                    </button>
                <?php else:; ?>
                    <button class="btn btn-default" data-toggle="modal" data-target="#join-modal" disabled> you are already taking part</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="modal fade" id="join-modal" tabindex="-1" role="dialog" aria-labelledby="join-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="join-modal">Join campaign</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Reason"
                                          ng-model="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" ng-model="subscribing"> Subscribe for updates</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal" ng-click="description = ''">
                            Reset
                        </button>
                        <button type="button" class="btn btn-primary" ng-click="connect_to_campaign()">Join
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/js/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvFfZ-1M2tlDHE48IjXw5LnZ4EyVVxdT0&callback=initMap&language=uk"></script>
<script src="/js/campaignCTRL.js"></script>
