<?php
require_once('config.php');
$response = array();

$http_origin = $_SERVER['HTTP_ORIGIN'];

http_response_code(400);
if ($http_origin == $config->{'serverphp'}) {  
    header("Access-Control-Allow-Origin: $http_origin");
}
header('Content-Type: application/json;charset=utf-8');


function destroySession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
};

$session = destroySession();
$response["status"] = "info";
$response["message"] = $session;//"Logged out successfully";

http_response_code(200);
echo json_encode($response);

?>