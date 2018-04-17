angular.module('services').factory('userService', function($http, toaster, config){
    var userService ={
        toast : function(data){
            toaster.pop(data.status, '', data.message, 10000, 'trustedHtml');
        },
        isUserLogin : function(){
            return $http({
                method: 'GET',
                url: config.PROTOCOL + config.HOST + ':' + config.PORT + config.IS_USER_LOGIN
            }).then(function(results){
                return results.data;
            });
        },
        logoutUser : function(){
            return $http({
                method: 'GET',
                url: config.PROTOCOL + config.HOST + ':' + config.PORT + config.LOGOUT
            }).then(function(results){
                return results.data;
            });
        },
        loginUser :function(user){
            return $http({
                method: 'POST',
                url: config.PROTOCOL + config.HOST + ':' + config.PORT + config.LOGIN,
                data: user
            }).then(function(results){
                return results.data;
            });

        },
        signupUser : function(object){
            return $http({
                method: 'POST',
                url: config.PROTOCOL + config.HOST + ':' + config.PORT + config.SIGNUP,
                data: object
            }).then(function(results){
                return results.data;
            });
        }

    };

    return userService;
})