var app = angular.module('ZradarApp', []);
app.controller('campaignCtrl', ['$scope', '$http', function ($scope, $http) {
    var campaign_id;
    $scope.select_campaign = function (id) {
        campaign_id = id;
    };
    $scope.connect_to_campaign = function () {
        $http.post('/api/connect_to_campaign', {
            campaign_id: campaign_id,
            description: $scope.description,
            subscribing: $scope.subscribing
        }).then(function (r) {
            window.location = '/me';
        })
    };

}]);