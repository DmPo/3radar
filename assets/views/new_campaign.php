<?php include 'layout.php'; ?>

<div class="container" ng-app="ZradarApp" ng-controller="NewCampaignCtrl" ng-cloak="">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h3 class="h3 text-center">Створення нової кампанії</h3>
            <form action="" name="campaign_form">
                <div class="form-group">
                    <label>Вибіріть область:</label>
                    <select class="form-control" ng-model="campaign.region_id" name="region"
                            ng-change="load_districts()"
                            ng-options="region.id as region.name for region in regions">
                        <option value="null" disabled selected> ---</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Виберіть район / міську раду</label>
                    <select class="form-control" ng-model="campaign.district_id" name="district"
                            ng-change="load_councils()"
                            ng-options="district.id as district.name for district in districts">
                        <option value="null" disabled selected> ---</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Рада</label>
                    <select class="form-control" ng-model="campaign.council_id" name="council" ng-change="show_info() "
                            ng-options="council.id as council.name for council in councils">
                        <option value="null" disabled selected> ---</option>
                    </select>
                </div>
                <div class="panel" ng-if="council_info">
                    <div class="panel-body">
                        <ul>
                            <li ng-if="council_info.major_name"><strong>Мер / Сільський голова: </strong> <span
                                    ng-bind="council_info.major_name"></span></li>
                            <li ng-if="council_info.major_bio"><strong>Біографія: </strong> <span
                                    ng-bind="council_info.major_bio"> </span></li>
                            <li><strong>Дата вибору: </strong> <span
                                    ng-bind="council_info.selection_date | date:'dd.MM.yyyy' "> </span></li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label>Причина</label>
                    <textarea ng-model="campaign.reason" name="reason" rows="5" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Додаткова інформація</label>
                    <textarea ng-model="campaign.description" name="description" rows="5"
                              class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" ng-model="campaign.literature">
                        Мені потрібна література
                    </label>
                </div>
                <div class="form-group" ng-model="campaign.literature">
                    <label>
                        <input type="checkbox" ng-model="campaign.training">
                        Мені потрібні треніги
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" ng-model="campaign.subscribing">
                        Підписатися на оновлення
                    </label>
                </div>
                <div class="text-center">
                    <button class="btn btn-default" type="button" ng-click="new_campaign()">Відкликати</button>
                </div>
        </div>
    </div>
    </form>
</div>
<script src="/js/new_campaignCTRL.js"></script>
