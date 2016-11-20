var app = angular.module('ZradarApp', []);
app.controller('NewCampaignCtrl', ['$scope', '$http', function ($scope, $http) {
    $http.get('/api/regions').then(function (r) {
        $scope.regions = r.data.regions;
    });
    $scope.load_districts = function () {
        if ($scope.campaign.region_id)
            $http.get('/api/districts?region_id=' + $scope.campaign.region_id).then(function (r) {
                $scope.districts = r.data.districts;
                $scope.councils = null;
                $scope.council_info = false;
            })
    };
    $scope.load_councils = function () {
        if ($scope.campaign.district_id)
            $http.get('/api/councils?district_id=' + $scope.campaign.district_id).then(function (r) {
                $scope.councils = r.data.councils;
                $scope.campaign.council_id = null;
                $scope.council_info = false;
                if (r.data.councils.length == 1) {
                    $scope.campaign.council_id = $scope.councils[0].id;
                    $scope.show_info()
                }
            })
    };
    $scope.show_info = function () {
        $scope.council_info = false;
        if ($scope.councils)
            for (var i = 0; i < $scope.councils.length; i++)
                if ($scope.councils[i].id == $scope.campaign.council_id)
                    return $scope.council_info = $scope.councils[i];
    };
    $scope.new_campaign = function () {
        $http.post('/api/new_campaign', $scope.campaign).then(function (r) {
            alert('Успішно!');
            window.location = '/campaigns/' + r.data.id;
        })
    };
}]);