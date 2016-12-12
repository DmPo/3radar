var app = angular.module('AuthApp', []);
var enableBtn = function () {
    document.getElementById("signupbutton").disabled = false;
};
app.controller('AuthCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.signup_error = '';
    $scope.signip_error = '';
    document.getElementById("signupbutton").disabled = true;
    $scope.signup = function () {

        var user = $scope.user;
        if ($scope.signUpForm.$invalid)
            return $scope.signup_error = 'Please check if the form is filled out correctly.';
        if (user.email && user.first_name && user.last_name && user.password )
            $http.get('/api/check_email?email=' + user.email).then(function (r) {
                if (r.data.free) {
                    $('form[name=signUpForm]').submit();
                    $scope.signup_error = '';
                }
                else  $scope.signup_error = 'This email is already used, please try to log in.'

            }, function () {

            })
        else  $scope.signup_error = 'Please fill out all fields of the form.'
    }

}]);
