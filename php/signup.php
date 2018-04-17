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
    $customer = array();
    $customer = json_decode(file_get_contents("php://input"),false);
    $email = $customer->user->email;
    $password = $customer->user->password;
    $name = $customer->user->name;
    $phone = $customer->user->phone;
    $address = $customer->user->address;
    
    $sql = "SELECT name FROM userauthentication.users WHERE email='" . $email . "' OR phone='" . $phone . "'"; 
    $isUserExist = $conn->query($sql);

    if(!$isUserExist->num_rows){
        $pwd = passwordHash::hash($password);

        $sql = "INSERT INTO " . $dbname . ".users (name, email, phone, password, address) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', '" . $pwd . "','" . $address . "' );";
        $result = $conn->query($sql);

        if ($result !=NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $conn->insert_id;
            
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            http_response_code(200);
            echo json_encode($response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            http_response_code(201);
            echo json_encode($response);
        }            
    }
    else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        http_response_code(201);
        echo json_encode($response);
    }

    $conn->close();

?>