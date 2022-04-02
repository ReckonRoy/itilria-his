<?php
session_start();

use login\doctor\model\Prescription;
require '../model/Prescription.php';
require '../../../config/config.php';

if(isset($_POST['presc_pid'])){
    $patient_id = $_POST['presc_pid'];
    
    if(!empty($patient_id)){
        $prescription = new Prescription($patient_id);
        $prescription->selectPrescriptionQuery($mysqli);
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}
?>