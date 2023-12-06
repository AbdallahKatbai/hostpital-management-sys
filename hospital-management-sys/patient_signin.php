<?php
header('Access-Control-Allow-Origin:*');
header('Access-control-Allow-Methods:GET,POST,OPTIONS');
header('Access-control-Allow-Headers:*');
include("connection.php");
$personal_id = $_POST['personal_id'];
$password = $_POST['password'];
$query = $mysqli -> prepare('Select enlisted_id, first_ name, last_name, password, role, illness, date_of_birth, gender, room_number, arrival_date, _departure_date from enlisted where email = ?');
$query -> bind_param('s', $personal_id);
$query -> execute();
$query -> store_result();


if ($query -> num_rows > 0) {
    
    $query -> bind_result($enlisted_id, $first_name, $hashed_password);
    $query -> fetch();

    if (password_verify($password, $hashed_password)){

        $token_payload = [
            'enlisted_id' => $enlisted_id,
            "role" => $role
        ];

        $secret_key = "hosp_pat";
        $jwt_token = jwt_encode($token_payload, $secret_key);
        $response = ['status' => 'true', 'token' => $jwt_token];

    }else{
        $response = ['status'=> 'false','message'=> 'incorrect credentials'];
    }
}else{
    $response = ['status'=> 'false','message'=> 'incorrect credentials'];
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