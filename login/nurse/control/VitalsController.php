<?php 
session_start();
require '../../../config/config.php';
require '../model/Vitals.php';
if(isset($_POST['patient_id']))
{
    $patient_id = $_POST['patient_id'];
    if(!empty($patient_id))
    {
        $vitals = new Vitals();
        $vitals->searchPatientID($mysqli, $patient_id);
    }
}else if(isset($_POST['p_id'])){
    
    $patient_id = $_POST['p_id'];
    $temp = $_POST['temperature'];
    $glu = $_POST['blood_glu'];
    $pres = $_POST['blood_pre'];
    $w = $_POST['weight'];
    $h = $_POST['height'];
    $pul = $_POST['pulse'];
    $saturation = $_POST['saturation'];
    $bmi = $_POST['bmi'];
    $history = $_POST['history'];
    if(!empty($patient_id))
    {
        $vitals = new Vitals();
        $vitals->setVitals($patient_id, $_SESSION['user_id'], $temp, $glu, $pres, $w, $h, $pul, $saturation, $bmi, $history);
        $vitals->saveVitals($mysqli, $patient_id);
        
    }else{
        echo json_encode([false, "Please fill in all fields", "error"]);        
    }
}
?>