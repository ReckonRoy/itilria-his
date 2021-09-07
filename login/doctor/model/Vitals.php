<?php
class Vitals{
    private $id = null;
    private $patient_id = null;
    private $staff_id = null;
    private $temp = null;
    private $glucose = null;
    private $pressure = null;
    private $weight = null;
    private $height= null;
    private $pulse = null;
    private $success_msg = null;
    private $error_msg = null;
    private $patient_name = null;
    private $patient_surname = null;
    
    function getPatientName(){
        return $this->patient_name;
    }
    
    function getPatientSurname(){
        return $this->patient_surname;
    }
    function getID(){
        return $this->id;
    }
    
    function getPatientID(){
        return $this->patient_id;
    }
    
    function getStaffID(){
        return $this->staff_id;
    }
    
    function getTemp(){
        return $this->temp;
    }
    
    function getGlucose(){
        return $this->glucose;
    }
    
    function getPressure(){
        return $this->pressure;
    }
    
    function getWeight(){
        return $this->weight;
    }
    
    function getHeight(){
        return $this->height;
    }
    
    function getPulse(){
        return $this->pulse;
    }
    
    function getSuccessMsg()
    {
        return $this->success_msg;
    }
    
    function getErrorMsg(){
        return $this->error_msg;
    }
    
    function getVitals($mysqli, $patient_id){
        $query = "SELECT * FROM vitals WHERE patient_id='".$patient_id."' ORDER BY date DESC LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $vitals[] = $row;
            
            
            echo json_encode([true, $vitals]);
        }else{
            $this->error_msg = "Some thing went wrong. Please contact support@itilria.co.za for help.";
            echo json_encode([false, $this->error_msg]);
        }
    }
}
?>