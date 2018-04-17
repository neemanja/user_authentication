angular.module('configs')
    .constant('config', {
        PROTOCOL: 'http://',
        HOST: 'localhost',
        PORT: '8000',
        SIGNUP: '/php/signup.php',
        LOGIN: '/php/login.php',
        LOGOUT: '/php/logout.php',
        IS_USER_LOGIN: '/php/isLogin.php'
    });
