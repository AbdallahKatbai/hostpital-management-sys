<?php

function decode_jwt($jwt_token, $secret_key){
    $token_parts = explode(".", $jwt_token);
    $token_payload = json_decode(base64_decode($token_parts[1]), true);

    //veruify the signature
    $signature = base64UrlEncode($token_parts[2]);
    $expect_signature = hash_hmac("sha256", "$token_parts[0].$token_parts[1]", $secret_key, true);

    if (hash_equals($expect_signature, $signature)){
        return $token_payload;
    } else {
        return false;
    }
}

function base64UrlDecode($data){
    $base64 = strtr($data, '-_', '_/');
    $base64_padded = str_pad($base64, strlen($data) % 4,'-', STR_PAD_RIGHT);
    return base64_decode($base64_padded);
}