<?php 
/*
 * @author Le-Roy S. Jongwe
 * @desc This class is a model fo managing the vitals data and other related processing functionalities
 * 
 */
class Doctor{
    private $id = null;
    private $patient_id = null;
    private $doctor_id = null;
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
    private $doctor_notes = null;
    private $assement_array = array();
    private $injections_array = array();
    private $procedures_array = array();
    private $prescription_array = array();
    private $allresults_array = array();
    private $patient_array = array();
    private $vitals_array = array();
    private $nurse_array = array();
    private $doctor_array = array();
    private  $dates_array = array();
    private $employee_details_array = array();
    function getPatientName(){
        return $this->patient_name;
    }
    
    function getPatientSurname(){
        return $this->patient_surname;
    }
    function getID(){
        return $this->id;
    }
    
    function getDoctorID(){
        return $this->doctor_id;
    }
    
    function getMergedArrays(){
        return $this->allresults_array = array_merge($this->patient_array, $this->nurse_array, $this->vitals_array, $this->employee_details_array, $this->doctor_array, $this->assement_array, $this->injections_array, $this->procedures_array, $this->prescription_array);
    }
    
    function getPatientID(){
        return $this->patient_id;
    }
    
    function getStaffID(){
        return $this->staff_id;
    }
    
    function setStaffID($staff_id)
    {
        $this->staff_id = $staff_id;
    }
    
    function getTemp(){
        return $this->temp;
    }
    
    function getGlucose(){
        return $this->glucose;
    }
    function getDates()
    {
        return $this->dates_array;
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
    
    function getDoctorNotes(){
        return $this->doctor_notes;
    }
    
    function getChargeSheet($mysqli, $p_id)
    {
        $query = "SELECT file_name FROM images WHERE patient_id='".$p_id."' ORDER BY uploaded_on DESC LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows > 0){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $imageUrl = $row['file_name'];
            echo json_encode([true, $imageUrl]);
        }else{
            echo json_encode([false, "Please Select Patient".$mysqli->error]);
        }
    }
    
    //get dates from vitals
    function querySelectDate($mysqli, $p_id){
        $query = "SELECT date FROM vitals WHERE patient_id='".$p_id."'";
        $result = $mysqli->query($query);
        if($result->num_rows != 0){
           
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $this->dates_array[] = $row;
            }
            
        }else{
            echo json_encode([true, "no dates to show"]);
        }
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
            echo json_encode([false, $this->error_msg]);
        }
    }
/*************************************************************************************************************************************************
* get user id from a particular vitals related to a particular patient
*/
    function querySelectDoctor($mysqli, $s_id){
        $query = "SELECT name, surname FROM user WHERE credential_id='".$s_id."' LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->doctor_array = array('doctor_name'=>$row['name'], 'doctor_surname'=>$row['surname']);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }
/*************************************************************************************************************************************************
 * /*************************************************************************************************************************************************
* get staff profession
*/
    function querySelectStaffProfession($mysqli, $s_id){
        $query = "SELECT profession FROM employee_details WHERE credential_id='".$s_id."' LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->employee_details_array = array('profession'=>$row['profession']);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }
/*************************************************************************************************************************************************
* get user id from a particular vitals related to a particular patient
*/
    function querySelectStaffVitals($mysqli, $s_id){
        $query = "SELECT name, surname FROM user WHERE credential_id='".$s_id."' LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->nurse_array = array('nurse_name'=>$row['name'], 'nurse_surname'=>$row['surname']);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }
/*************************************************************************************************************************************************
 * get user id from a particular vitals related to a particular patient
 */ 
    function querySelectVitals($mysqli, $p_id){
        $query = "SELECT * FROM vitals WHERE patient_id='".$p_id."' ORDER BY date DESC LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $this->setStaffID($row['staff_id']);
                $this->vitals_array = array('temp'=>$row['temperature'], 'glucose'=>$row['blood_glucose'], 'pressure'=>$row['blood_pressure'],'weight'=>$row['weight'],'height'=>$row['height'],'pulse'=>$row['pulse'], 'saturation'=>$row['saturation'], 'bmi'=>$row['bmi'],  'history'=>$row['history'], 'vitals_time'=>$row['time'], 'vitals_date'=>$row['date']);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }

/**************************************************************************************************************************************************
 *query patient table for patient records 
 */   
    function querySelectPatient($mysqli, $p_id){
        $query = "SELECT name, surname, gender, contact, registered_date FROM patient WHERE patient_id='".$p_id."' ORDER BY registered_date DESC LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            $this->patient_array = $row;
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }
    
    /***********************************************************************************************************************************************/
    //get Assesment values
    function querySelectAssesment($mysqli, $p_id)
    {
        $query = "SELECT * FROM assesment WHERE patient_id='".$p_id."' ORDER BY date DESC";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->doctor_id = $row['staff_id'];
            $this->assement_array = array('symptoms' => $row['symptoms'], 'signs'=>$row['signs'], 'doctor_time'=>$row['time']);
            //$staff_id = $row['staff_id'];
            //$symptoms = $row['symptoms'];
            //$signs = $row['signs'];
            //$time = $row['time'];
            //$date = $row['date'];
            
            //if there is processing needed create an array that will save the processed in put
            //echo json_encode([true], $staff_id, $symptoms, $signs, $time, $date);
        }else{
            echo joson_encode([false, "No record of symptoms and signs found"], "assesment");
        }
    }
    
    /***********************************************************************************************************************************************/
  
    /***********************************************************************************************************************************************/
    /***********************************************************************************************************************************************/
    
    function querySelectInjections($mysqli, $p_id)
    {
        $query = "SELECT * FROM plan WHERE patient_id='".$p_id."' ORDER BY date DESC";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->injections_array = $row;
            //$injections = $row['injections'];
            //$staff_id = $row['staff_id'];
            //$time = $row['time'];
            //$date = $row['date'];
            
            //if there is processing needed create an array that will save the processed in put
            //echo json_encode([true], $injections, $staff_id, $time, $date);
        }else{
            echo joson_encode([false, "No record of symptoms and signs found"], "injections");
        }
    }
    /***********************************************************************************************************************************************/
    //get Procedures values
    function querySelectProcedures($mysqli, $p_id)
    {
        $query = "SELECT * FROM investigations WHERE patient_id='".$p_id."' ORDER BY date DESC";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->procedures_array = $row;
            /*$staff_id = $row['staff_id'];
            $investigation = $row['investigation'];
            $procedures = $row['procedures'];
            $time = $row['time'];
            $date = $row['date'];
            
            //if there is processing needed create an array that will save the processed in put
            echo json_encode([true], $staff_id, $investigation, $procedures, $time, $date);
            */
        }else{
            echo json_encode([false, "No record of symptoms and signs found", "procedures"]);
        }
    }
    
    /*************************************************************************************************************************************************/
    /***********************************************************************************************************************************************/
    //get Prescription values
    function querySelectPrescription($mysqli, $p_id)
    {
        $query = "SELECT * FROM prescription WHERE patient_id='".$p_id."' ORDER BY date DESC";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->prescription_array = $row;
            /*$staff_id = $row['staff_id'];
            $prescription = $row['prescription'];
            $time = $row['time'];
            $date = $row['date'];
            
            //if there is processing needed create an array that will save the processed in put
            echo json_encode([true], $staff_id, $prescription, $time, $date);
            */
        }else{
            echo joson_encode([false, "No record of symptoms and signs found"], "prescription");
        }
    }
    /***********************************************************************************************************************************************/
    /**************************************************************************************************************************************************/
    //save patient vitals into appropriate patient id
    function saveVitals($mysqli, $p_id){
        $query = "INSERT INTO vitals(patient_id, staff_id, temperature, blood_glucose, blood_pressure, weight, height, pulse) VALUES('".$this->getPatientID()."', '".$this->getStaffID()."', '".$this->getTemp()."', '".$this->getGlucose()."', '".$this->getPressure()."', '".$this->getWeight()."', '".$this->getHeight()."', '".$this->getPulse()."')";
        $result = $mysqli->query($query);
        if($result)
        {
            $this->success_msg = "Vitals for patient {$this->getPatientName()} {$this->getPatientSurname()} have been succesfuly saved!";
            echo json_encode([true, $this->getSuccessMsg()]);
        }else{
            $this->error_msg .= "Something went terribly wrong! please contact support at support@itilria.co.za";
            echo json_encode([false, $this->getErrorMsg()]);
        }
    }
    /**
     * @param id patient_id staff_id temp glucose pressure weight height pulse
     * glucose pressure -> are preceded by blood_ in database
     * temp -> is temperature in database
     */
    function setVitals($p_id, $s_id, $temp, $glu, $pres, $w, $h, $pul){
        $this->patient_id = $p_id;
        $this->staff_id = $s_id;
        $this->temp = $temp;
        $this->glucose = $glu;
        $this->pressure = $pres;
        $this->weight = $w;
        $this->height = $h;
        $this->pulse = $pul;
    }
    
    function saveNotes($mysqli, $p_id, $s_id, $notes)
    {
        $query = "INSERT INTO doctorsnotes(patient_id, staff_id, doctor_notes, date, time) VALUES('".$p_id."', '".$s_id."','".$notes."', CURDATE(), CURTIME())";
        $result = $mysqli->query($query);
        if($result){
            echo json_encode([true, "saved successfuly", "success", "notes"]);
        }else{
            echo json_encode([false, "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error, "error"]);
        }
    }
    /**********************************************************************************************************************************************/
    function saveAssesment($mysqli, $p_id, $s_id, $symptoms, $signs)
    {
        $query = "INSERT INTO assesment(patient_id, staff_id, symptoms, signs, date, time) VALUES('".$p_id."', '".$s_id."','".$symptoms."', '".$signs."', CURDATE(), CURTIME())";
        $result = $mysqli->query($query);
        if($result){
            echo json_encode([true, "saved successfuly", "success", "assesment"]);
        }else{
            echo json_encode([false, "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error, "error"]);
        }
    }
    /************************************************************************************************************************************************/
    
    /************************************************************************************************************************************************/
    function saveInjections($mysqli, $p_id, $s_id, $injections)
    {
        $query = "INSERT INTO plan(patient_id, staff_id, injections, date, time) VALUES('".$p_id."', '".$s_id."','".$injections."', CURDATE(), CURTIME())";
        $result = $mysqli->query($query);
        if($result){
            echo json_encode([true, "saved successfuly", "success", "injections"]);
        }else{
            echo json_encode([false, "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error, "error"]);
        }
    }
    /************************************************************************************************************************************************/
    function saveProcedures($mysqli, $p_id, $s_id, $procedure, $investigation)
    {
        $query = "INSERT INTO investigations(patient_id, staff_id, investigation, procedures, time, date) VALUES('".$p_id."', '".$s_id."', '".$investigation."', '".$procedure."', CURTIME(), CURDATE())";
        $result = $mysqli->query($query);
        if($result){
            echo json_encode([true, "saved successfuly", "success", "procedures"]);
        }else{
            echo json_encode([false, "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error, "error"]);
        }
    }
    /************************************************************************************************************************************************/
    function savePrescription($mysqli, $p_id, $s_id, $prescription)
    {
        $query = "INSERT INTO prescription(patient_id, staff_id, prescription, time, date) VALUES('".$p_id."', '".$s_id."', '".$prescription."', CURTIME(), CURDATE())";
        $result = $mysqli->query($query);
        if($result){
            echo json_encode([true, "saved successfuly", "success", "prescription"]);
        }else{
            echo json_encode([false, "Something went terribly wrong! please contact support at support@itilria.co.za".$mysqli->error, "error"]);
        }
    }
}
?>