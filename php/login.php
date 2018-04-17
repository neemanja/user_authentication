<?php
    require_once('config.php');
    require_once('passwordHash.php');
    $dbhost = $config->{'DB_HOST'};
    $dbname = $config->{'DB_NAME'};
    $dbusername = $config->{'DB_USERNAME'};
    $dbpassword = $config->{'DB_PASSWORD'};
    $http_origin = $_SERVER['HTTP_ORIGIN'];

    http_response_code(400);
    if ($http_origin == $config->{'serverphp'}) {  
        header("Access-Control-Allow-Origin: $http_origin");
    }
    header('Content-Type: application/json;charset=utf-8');

    //Create connection
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    //Chech connection
    if($conn->connect_error){
        die('Connection failed: ' . $conn->connect_error);
    }

    $response = array();
    $user = array();
    $user = json_decode(file_get_contents("php://input"),false);
    $email = $user->user->email;
    $password = $user->user->password;

    $sql = "SELECT iduser, name, phone, email, password FROM " . $dbname . ".users WHERE phone='". $email . "'or email='" . $email . "'"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $rows[]= $row;
        }
            
        if(passwordHash::check_password($rows[0]['password'],$password)){
            $response['status'] = 'success';
            $response['message'] = 'Logged in successfully';
            $response['name'] = $rows[0]['name'];
            $response['userid'] = $rows[0]['iduser'];
            $response['email'] = $rows[0]['email'];
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $rows[0]['iduser'];
            $_SESSION['email'] = $rows[0]['email'];
            $_SESSION['name'] = $rows[0]['name'];
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Login failed. Incorrect credentials';
        }      
    } 
    else {
       
        $response['status'] = "error";
        $response['message'] = 'No such user is registered';
    }

    http_response_code(200);
    echo json_encode($response);

    $conn->close();

?>