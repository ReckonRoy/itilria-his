<?php
    require '../../../config/config.php';
    require '../../doctor/model/Doctor.php';
    
    if(isset($_POST['patient_id']))
    {
        $patient_id = $_POST['patient_id'];
        if(!empty($patient_id)){
            $doctor = new Doctor();
           
            $doctor->querySelectVitals($mysqli, $patient_id);
            $doctor->querySelectDate($mysqli, $patient_id);
            $doctor->querySelectStaffVitals($mysqli, $doctor->getStaffID());
            $doctor->querySelectStaffProfession($mysqli, $doctor->getStaffID());
            $doctor->querySelectPatient($mysqli, $patient_id);
            $doctor->querySelectAssesment($mysqli, $patient_id);
            $doctor->querySelectDoctor($mysqli, $doctor->getDoctorID());
            $doctor->querySelectPlan($mysqli, $patient_id);
            $doctor->querySelectProcedures($mysqli, $patient_id);
            $doctor->querySelectPrescription($mysqli, $patient_id);
            
            echo json_encode([true, $doctor->getMergedArrays(), $doctor->getDates()]);
        }else{
            echo json_encode([false, "Please select patient File to view"]);
        }
    }
?>