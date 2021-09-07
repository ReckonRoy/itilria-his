<?php
session_start();
require '../../../config/config.php';
require '../processes/Patient.php';

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gender = $_POST['sex'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $nationality = $_POST['nationality'];
    $citizen_id = $_POST['citizen_id'];
    $occupation = $_POST['occupation'];
    $address = $_POST['address'];
    
    //Get Pre-existing conditions field 
    $pec = $_POST['pec'];
    $allergies = $_POST['allergies'];
    
    //Get nok fields
    $nok_name = $_POST['nok_name'];
    $nok_surname = $_POST['nok_lname'];
    $nok_contact = $_POST['nok_contact'];
    $nok_id = $_POST['nok_id'];
    $nok_rel = $_POST['nok_rel'];
    $nok_address = $_POST['nok_address'];
    
    if(!empty($name) && !empty($surname) && !empty($gender) && !empty($dob) && !empty($contact) && !empty($nationality) && !empty($citizen_id) 
        && !empty($occupation) && !empty($address) && !empty($pec) && !empty($allergies) && !empty($nok_name) && !empty($nok_surname)
        && !empty($nok_contact) && !empty($nok_rel) && !empty($nok_address)){
        
        $patient = new Patient();
        $patient->setPatient($_SESSION['user_id'], $name, $surname, $gender, $dob, $contact, $nationality, $citizen_id, $occupation, $address);
        $patient->setNok($nok_name, $nok_surname, $nok_contact, $nok_id, $nok_rel, $nok_address);
        $patient->setPEC($pec, $allergies);
        $patient->register($mysqli);
        $patient->getError();
    }
}else{
    echo "some fields are not set";
}