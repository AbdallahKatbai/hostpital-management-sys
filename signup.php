<?php
header('Access-Controll-Allow-Origin:*');
include("connection.php");

$email = $_POST['email'];
$password = $_POST['password'];
$id_usertype = 0;
$name = $_POST['name'];
$last_name = $_POST['last_name'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli -> prepare('insert into users(email, password, id_usertype, name, last_name)
values(?,?,?,?,?)');
$query -> bind_param('ssiss', $email, $hashed_password, $id_usertype, $name, $last_name);
$query -> execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);