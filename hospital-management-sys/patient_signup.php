<?php
header('Access-Controll-Allow-Origin:*');
header('Access-control-Allow-Methods:GET,POST,OPTIONS');
header('Access-control-Allow-Headers:*');
include("connection.php");

$email = $_POST['email'];
$personal_id = $_POST['personal_id'];
$personal_id_type = $_POST['personal_id_type'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$role = $_POST['role'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$illness = $_POST['illness'];
$arrival_date = $_POST['arrival_date'];
$departure_date = $_POST['departure_date'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli -> prepare('insert into enlisted(email, personal_id, personal_id_type, phone_number, password, role, first_name, last_name, illness, room_number, arrival_date, departure_date)
values(?,?,?,?,?,?,?,?,?,?,?,?)');
$query -> bind_param('sssss', $email, $personal_id, $hashed_password, $role, $first_name, $last_name);
$query -> execute();

if ($query -> affected_rows > 0){
    $token_payload = [
        'enlisted_id' => $enlisted_id,
        'role' => "patient"
    ];

    $secret_key = "hosp_pat";
    $jwt_token = jwt_encode($token_payload, $secret_key);
    $response = ['status' => 'true', 'token' => $jwt_token];
}else{
    $response = ['status'=> 'false','message'=> 'failed to create'];
}

echo json_encode($response);
function jwt_encode($payload, $secret_key) {
    // Base64Url encode the JWT header and payload
    $base64UrlHeader = base64UrlEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $base64UrlPayload = base64UrlEncode(json_encode($payload));

    // Creating the signature using HMAC-SHA256
    $signature = hash_hmac("sha256", "$base64UrlHeader.$base64UrlPayload", $secret_key, true);

    // Base64Url encode the signature
    $base64UrlSignature = base64UrlEncode($signature);

    // Concatenate the base64Url-encoded header, payload, and signature to form the JWT token
    return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
}

// Function to perform Base64Url encoding
function base64UrlEncode($data) {
    $base64 = base64_encode($data);
    $base64Url = strtr($base64, '+/', '-_');
    return rtrim($base64Url, '=');
}