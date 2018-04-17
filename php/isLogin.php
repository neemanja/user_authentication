<?php
require_once('config.php');
$response = array();

$http_origin = $_SERVER['HTTP_ORIGIN'];

http_response_code(400);
if ($http_origin == $config->{'serverphp'}) {  
    header("Access-Control-Allow-Origin: $http_origin");
}
header('Content-Type: application/json;charset=utf-8');


function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['uid']))
    {
        $sess["uid"] = $_SESSION['uid'];
        $sess["name"] = $_SESSION['name'];
        $sess["email"] = $_SESSION['email'];
    }
    else
    {
        $sess["uid"] = '';
        $sess["name"] = 'Guest';
        $sess["email"] = '';
    }
    return $sess;
}

$session = getSession();
$response["uid"] = $session['uid'];
$response["email"] = $session['email'];
$response["name"] = $session['name'];

http_response_code(200);
echo json_encode($response);

?>