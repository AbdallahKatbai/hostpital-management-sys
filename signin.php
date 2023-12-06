<?php
header('Access-Controll-Allow-Origin:*');
include("connection.php");
$email = $_POST['email'];
$password = $_POST['password'];
$query = $mysqli -> prepare('Select id_user, name, password from users where email = ?');
$query -> bind_param('s', $email);
$query -> execute();
$query -> store_result();
$num_rows=$query->num_rows;
$query -> bind_result($id, $name, $hashed_password);
$query -> fetch();

$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
    echo json_encode($response);
} else{
    if (password_verify($password, $hashed_password)) {
        $response['status'] = 'logged in';
        $response['user_id'] = $id;
        $response['name'] = $name;
        echo json_encode($response);
    } else {
        $response['status'] = 'wrong credentials';
        echo json_encode($response);
    }
};