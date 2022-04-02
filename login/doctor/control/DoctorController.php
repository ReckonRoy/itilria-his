<?php 
session_start();
require '../../../config/config.php';
require '../model/Doctor.php';
require '../model/Vitals.php';
if(isset($_POST['patient_id']))
{
    $patient_id = $_POST['patient_id'];
    if(!empty($patient_id))
    {
        $doctor = new Doctor();
        $doctor->searchPatientID($mysqli, $patient_id);
    }
}else if(isset($_POST['p_id'])){
    
    $patient_id = $_POST['p_id'];
    $temp = $_POST['temperature'];
    $glu = $_POST['blood_glu'];
    $pres = $_POST['blood_pre'];
    $w = $_POST['weight'];
    $h = $_POST['height'];
    $pul = $_POST['pulse'];
    if(!empty($patient_id))
    {
        $vitals = new Vitals();
        $vitals->setVitals($patient_id, $_SESSION['user_id'], $temp, $glu, $pres, $w, $h, $pul);
        $vitals->saveVitals($mysqli, $patient_id);
        echo "data saved";
    }else{
        echo "Please fill in all fields";        
    }
}else if(isset($_POST['vitals_pid']))
{
    $patient_id = $_POST['vitals_pid'];
    if(!empty($patient_id))
    {
        $vitals = new Vitals();
        $vitals->getVitals($mysqli, $patient_id);
    }else{
        echo json_encode([false, "Data will appear when patient has been selected"]);
    }
}else if(isset($_POST['notes_pid']))
{
    $patient_id = $_POST['notes_pid'];
    $notes = $_POST['doctors_notes'];
    if(!empty($patient_id)){
        $doctor = new Doctor();
        $doctor->saveNotes($mysqli, $patient_id, $_SESSION['user_id'], $notes);
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}else if(isset($_POST['asses_pid'])){
    $asses_pid = $_POST['asses_pid'];
    $symptoms = $_POST['symptoms'];
    $signs = $_POST['signs'];
    
    if(!empty($asses_pid)){
        $doctor = new Doctor();
        $doctor->saveAssesment($mysqli, $asses_pid, $_SESSION['user_id'], $symptoms, $signs);
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}else if(isset($_POST['injections_pid'])){
    $injections_pid = $_POST['injections_pid'];
    $injections = $_POST['injections'];
    
    if(!empty($injections_pid)){
        $doctor = new Doctor();
        $doctor->saveInjections($mysqli, $injections_pid, $_SESSION['user_id'], $injections);
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}else if(isset($_POST['proc_pid'])){
    $proc_pid = $_POST['proc_pid'];
    $investigation = $_POST['investigation'];
    $procedures = $_POST['procedures'];
    
    if(!empty($proc_pid)){
        $doctor = new Doctor();
        $doctor->saveProcedures($mysqli, $proc_pid, $_SESSION['user_id'], $procedures, $investigation, );
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}else if(isset($_POST['presc_pid'])){
    $presc_pid = $_POST['presc_pid'];
    $prescription = $_POST['prescription'];
    
    if(!empty($presc_pid)){
        $doctor = new Doctor();
        $doctor->savePrescription($mysqli, $presc_pid, $_SESSION['user_id'], $prescription);
    }else{
        echo json_encode(['false', "please select a patient", "error"]);
    }
}
?>