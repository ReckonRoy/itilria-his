<?php 
/*
 * @author Le-Roy S. Jongwe
 * @desc This class is a model fo managing the vitals data and other related processing functionalities
 * 
 */
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
    private $saturation = null;
    private $bmi = null;
    private $history = null;
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
    
    function getSaturation()
    {
        return $this->saturation;
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
    
    function getBMI(){
        return $this->bmi;
    }
    
    function getHistory(){
        return $this->history;
    }
    
    function getSuccessMsg()
    {
        return $this->success_msg;
    }
    
    function getErrorMsg(){
        return $this->error_msg;
    }
    
    //search patient by patient id
    //if patient exist display patient results
    //return patient name, surname and patient id
    function searchPatientID($mysqli, $p_id){
        $query = "SELECT patient_id, name, surname FROM patient WHERE patient_id LIKE '".$p_id.'%'."' LIMIT 6";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $all_rows[] = $row;
            }
            echo json_encode([true, $all_rows]);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->getErrorMsg()]);
        }
    }
    
    //save patient vitals into appropriate patient id
    function saveVitals($mysqli, $p_id){
        $query = "INSERT INTO vitals(patient_id, staff_id, temperature, blood_glucose, blood_pressure, weight, height, pulse, saturation, bmi, history, time, date) VALUES('".$this->getPatientID()."', '".$this->getStaffID()."', '".$this->getTemp()."', '".$this->getGlucose()."', '".$this->getPressure()."', '".$this->getWeight()."', '".$this->getHeight()."', '".$this->getPulse()."', '".$this->getSaturation()."', '".$this->getBMI()."', '".$this->getHistory()."', CURTIME(), CURDATE())";
        $result = $mysqli->query($query);
        if($result)
        {
            $this->success_msg = "Vitals for patient {$this->getPatientName()} {$this->getPatientSurname()} have been succesfuly saved!";
            echo json_encode([true, $this->getSuccessMsg(), "success_class"]);
        }else{
            $this->error_msg .= "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error;
            echo json_encode([false, $this->getErrorMsg(), "error_class"]);
        }
    }
    /**
     * @param id patient_id staff_id temp glucose pressure weight height pulse
     * glucose pressure -> are preceded by blood_ in database
     * temp -> is temperature in database
     */
    function setVitals($p_id, $s_id, $temp, $glu, $pres, $w, $h, $pul, $saturation, $bmi, $history){
        $this->patient_id = $p_id;
        $this->staff_id = $s_id;
        $this->temp = $temp;
        $this->glucose = $glu;
        $this->pressure = $pres;
        $this->weight = $w;
        $this->height = $h;
        $this->pulse = $pul;
        $this->saturation = $saturation;
        $this->bmi = $bmi;
        $this->history = $history;
    }
}
?>