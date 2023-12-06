<?php
header('Access-Controll-Allowed-Origin:*');
header('Access-control-Allow-Headers:*');

include("connection.php");
$query = $mysqli -> prepare('Select en.*, beds.room_number, beds.bed_number, beds.doctor_id, emr.room_number, emr.doctor_id, testr.test_name, testr.price, testr.test_date, opr.room_number, opr.doctor_id, opr.operation_name, opr.operation_began_at, opr.expected_duration, opr.operation_ended
from enlisted en
join beds on en.enlisted_id = beds.patient_id
join emergancy_rooms emr on en.enlisted_id = emr.patient_id
join test_results testr on en.enlisted_id = testr.patient_id
join operation_rooms opr on en.enlisted_id = opr.patient_name');
$query -> execute();
$array = $query -> get_result();
$response = [];

while ($enlisted = $array -> fetch_assoc()) {
    $response[] = $enlisted;
}
echo json_encode($respond);