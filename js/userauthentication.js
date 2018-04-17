angular.module('directives',[]);
angular.module('services',['configs']);
angular.module('controllers',['services']);
angular.module('configs', []);
angular.module('userauthenticationApp',['services','controllers','directives', 'configs','ui.router','toaster'])

.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
    $stateProvider
        .state('login',{
            url: '/login',
            title:'Login',
            templateUrl: '/html/login.html',
            controller: 'authCtrl'
        })
        .state('signup', {
            title: 'Signup',
            url: '/signup',
            templateUrl: 'html/signup.html',
            controller: 'authCtrl'
        })
        .state('dashboard', {
            title: 'Dashboard',
            url: '/dashboard',
            templateUrl: 'html/dashboard.html',
            controller: 'authCtrl'
        })
        .state('/', {
            title: 'Login',
            url: '/login',
            templateUrl: 'html/login.html',
            controller: 'authCtrl',
            role: '0'
        });

        $urlRouterProvider.otherwise('login');
}])

.run(function($rootScope, $state, userService, $location){
    $rootScope.$on('$locationChangeSuccess', function(event, next, current, fromState, fromParams) {
        $rootScope.authenticated = false;
        userService.isUserLogin().then(function(results){
            if(results.uid){
                $rootScope.authenticated = true;
                $rootScope.idUser = results.uid;
                $rootScope.name = results.name;
                $rootScope.email = results.email;
                $state.go('dashboard');
            }
            else{
                var nextUrl = $location.path();
                if(nextUrl == '/signup' || nextUrl == '/login'){

                }
                else{
                    $state.go('login');
                }
            }
        });
      });
});