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
            $doctor->querySelectInjections($mysqli, $patient_id);
            $doctor->querySelectProcedures($mysqli, $patient_id);
            $doctor->querySelectPrescription($mysqli, $patient_id);
            
            echo json_encode([true, $doctor->getMergedArrays(), $doctor->getDates(), "emr_access" ]);
        }else{
            echo json_encode([false, "Please select patient File to view"]);
        }
    }else if(isset($_POST['p_id']) && isset($_POST['record_date'])){
        $patient_id = $_POST['p_id'];
        $record_date = $_POST['record_date'];
        if(!empty($patient_id)){
            $doctor = new Doctor();
            $doctor->setRecordDate($record_date);
            
            $doctor->querySelectVitals($mysqli, $patient_id);
            $doctor->querySelectDate($mysqli, $patient_id);
            $doctor->querySelectStaffVitals($mysqli, $doctor->getStaffID());
            $doctor->querySelectStaffProfession($mysqli, $doctor->getStaffID());
            $doctor->querySelectPatient($mysqli, $patient_id);
            $doctor->querySelectAssesment($mysqli, $patient_id);
            $doctor->querySelectDoctor($mysqli, $doctor->getDoctorID());
            $doctor->querySelectInjections($mysqli, $patient_id);
            $doctor->querySelectProcedures($mysqli, $patient_id);
            $doctor->querySelectPrescription($mysqli, $patient_id);
            
            echo json_encode([true, $doctor->getMergedArrays(), "emr_access_date" ]);
        }
    }
?>