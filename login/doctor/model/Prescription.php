<?php
namespace login\doctor\model;

class Prescription
{
    private $name = null;
    private $surname = null;
    private $address = null;
    private $age = null;
    private $dob = null;
    private $gender = null;
    private $prescription = null;
    private $doctors_name = null;
    private $patient_id = null;
    private $doctor_id = null;
    private $prescription_date = null;
    
    function __construct($p_id){
        $this->patient_id = $p_id;
    }
    
    function getName() {
        return $this->name;
    }
    
    function getSurname()
    {
        return $this->surname;
    }
    
    function getFullName()
    {
        return $this->getName()." ".$this->getSurname();
    }
    
    function getAddress(){
        return $this->address;
    }
    
    function getDOB()
    {
        return date("Y", strtotime($this->dob));
    }
    
    function getAge(){
        $this->age = date("Y") - $this->getDOB();
        return $this->age;
    }
    
    function getGender(){
        return $this->gender;
    }
    
    function getPrescription(){
        return $this->prescription;
    }

    function getDoctorName(){
        return $this->doctors_name;
    }
    
    function getDate(){
        return $this->prescription_date;
    }
    
    function getPatientID()
    {
        return $this->patient_id;
    }
    
    function getDoctorID()
    {
        return $this->doctor_id;
    }
    
    function selectPrescriptionQuery($mysqli){
        $query = "SELECT p.name, p.surname, p.gender, p.dob, p.address, pre.staff_id, pre.prescription, pre.date FROM patient AS p INNER JOIN prescription AS pre ON p.patient_id=pre.patient_id WHERE p.patient_id='".$this->getPatientID()."' ORDER BY pre.date DESC LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->gender = $row['gender'];
            $this->dob = $row['dob'];
            $this->address = $row['address'];
            $this->doctor_id = $row['staff_id'];
            $this->prescription = $row['prescription'];
            $this->prescription_date = $row['date'];
            $first_array = array(
                'name'=>$this->getFullName(),
                'gender'=>$this->getGender(),
                'age'=>$this->getAge(),
                'address'=>$this->getAddress(),
                'prescription'=>$this->getPrescription(),
                'prescription_date'=>$this->getDate()
            );
            
            $query = "SELECT name FROM user WHERE credential_id='".$this->getDoctorID()."'";
            $result = $mysqli->query($query);
            if($result->num_rows > 0)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $this->doctors_name = $row['name'];
                $second_array = array('doctor'=>$this->doctors_name);
                echo json_encode([true, $first_array, $second_array]);
            }else{
                //no doctor returned
            }
        }else{
            //retun no prescription available
        }
    }
}

