<?php
session_start();
require '../../config/config.php';
require '../commonModel/SearchPatient.php';

if(isset($_POST['patient_id']))
{
    $patient_id = $_POST['patient_id'];
    if(!empty($patient_id))
    {
        $sp = new SearchPatient();
        $sp->searchPatientID($mysqli, $patient_id);
    }
}
?>