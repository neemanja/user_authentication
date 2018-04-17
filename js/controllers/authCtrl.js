angular.module('controllers').controller('authCtrl', function($scope, $rootScope, $state, $http, userService){
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (user){
        userService.loginUser({user: user}).then(function(results){
            userService.toast(results);
            if(results.status == "success"){
                $state.go('dashboard');
            }
        });
    };

    $scope.signup = {email:'', password:'', name:'',phone:'',address:''};
    $scope.signUp = function (user){
        userService.signupUser({user:user}).then(function(results){
            userService.toast(results);
            if(results.status == "success"){
                $state.go('dashboard');
            }
        });
    };

    $scope.logout = function (){
        userService.logoutUser().then(function(results){
            userService.toast(results);
            $state.go('login');
        });
    }
});