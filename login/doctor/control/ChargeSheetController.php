<?php
session_start();
require '../../../config/config.php';
require '../model/Doctor.php';
if(isset($_POST['img_pid']) && !empty($_POST['img_pid']))
{
    $patient_id = $_POST['img_pid'];
   
    $doctor = new Doctor();
    $doctor->getChargeSheet($mysqli, $patient_id);
}else{
    echo json_encode([false, "Data will appear when patient has been selected"]);
}
