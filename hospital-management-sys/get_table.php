<?php
header('Access-Controll-Allowed-Origin:*');
include("connection.php");
$query = $mysqli -> prepare('Select r.*,l.city_name,rt.type
from restaurants r
join restaurants_types rt on r.reataurant_type = rt.id_restaurant_type
join location l on r.location_id = l.id_location');
$query -> execute();
$array = $query -> get_result();
$response = [];

while ($restaurant = $array -> fetch_assoc()) {
    $response[] = $restaurant;
}
echo json_encode($respond);