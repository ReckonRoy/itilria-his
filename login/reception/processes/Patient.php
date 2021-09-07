<?php 
class Patient{
    private $id = null;
    private $patient_id = null;//patient unique id
    private $staff_id = null;
    private $name = null;
    private $surname = null;
    private $gender = null;
    private $dob = null;
    private $age = null;
    private $contact = null;
    private $nationality = null;
    private $citizenID = null;
    private $occupation = null;
    private $address = null;
    
    private $nok_name = null;
    private $nok_surname = null;
    private $nok_contact = null;
    private $nok_id = null;
    private $nok_rel = null;
    private $nok_address = null;
    
    private $pec = null;
    private $allergies = null;
    private $error_msg = null;
    
    /***********************************************GETTERS & SETTERS*************************************************************/
    function getError(){
        return $this->error_msg;
    }
    
    function getID(){
        return $this->id;
    }
    
    function getPatientID(){//get patient unique id
        return $this->patient_id;
    }
    
    function getStaffID()
    {
        return $this->staff_id;
    }
    
    function getName(){
        return $this->name;
    }
    
    function getSurname(){
        return $this->surname;
    }
    
    function getGender()
    {
        return $this->gender;
    }
    
    function getDOB()
    {
        return $this->dob;
    }
    
    //calculate date to get age
    function getAge(){
        return $this->age;
    }
    
    function getContact(){
        return $this->contact;
    }
    
    function getNationality(){
        return $this->nationality;
    }
    
    function getCitizenID(){
        return $this->citizenID;
    }
    
    function getOccupation()
    {
        return $this->occupation;
    }
    
    function getAddress(){
        return $this->address;
    }
    
    function getInitials()
    {
        $fname = substr($this->getName(), 0, 1);
        $lname = substr($this->getSurname(), 0, 1);
        
        return $fname.$lname;
    }
    
    function setPatientID()
    {
        $this->patient_id = "#".$this->getInitials().$this->getID();
    }
    //set patient params method
    function setPatient($s_id, $n, $s, $g, $dob, $con, $nat, $c_id, $occ, $addr){
        $this->staff_id = $s_id;
        $this->name = $n;
        $this->surname = $s;
        $this->gender = $g;
        $this->dob = $dob;
        $this->contact = $con;
        $this->nationality = $nat;
        $this->citizenID = $c_id;
        $this->occupation = $occ;
        $this->address = $addr;
    }
    
    //set nok params method
    function setNok($n, $s, $con, $c_id, $rel, $addr){
        $this->nok_name = $n;
        $this->nok_surname = $s;
        $this->nok_contact = $con;
        $this->nok_id = $c_id;
        $this->nok_rel = $rel;
        $this->nok_address = $addr;
    }
    /*******************************************************************************************************************************************/
    //NOK
    /*******************************************************************************************************************************************/
    function getNokName(){
        return $this->nok_name;
    }
    function getNokSurname(){
        return $this->nok_surname;
    }
    function getNokContact(){
        return $this->nok_contact;
    }
    function getNokCitizenID(){
        return $this->nok_id;
    }
    function getNokRelationship(){
        return $this->nok_rel;
    }
    function getNokAddress(){
        return $this->nok_address;
    }
    
    //register nok
    function registerNok($mysqli, $pat_id){
     
        //proceed with insert query
        $query = "INSERT INTO next_of_kin(patient_id, name, surname, contact, citizen_id, relationship, address) VALUES('".$pat_id."', '".$this->getNokName()."', '".$this->getNokSurname()."', '".$this->getNokContact()."', '".$this->getNokCitizenID()."', '".$this->getNokRelationship()."', '".$this->getNokAddress()."')";
        $result = $mysqli->query($query);
        if(!$result)
        {
            $this->error_msg .= "error while trying to save data, Please contact support@itilria.co.za for assistance".$mysqli->error;
            echo $this->error_msg;
        }
    }
    /*****************************************************************************************************************************/
    //Pre Existing Conditions
    function getPEC()
    {
        return $this->pec;
    }
    
    function getAllergies()
    {
        return $this->allergies;
    }
    
    function setPEC($pec, $allergies)
    {
        $this->pec = $pec;
        $this->allergies = $allergies;
    }
    
    function insertPec($mysqli, $pat_id)
    {
        $query = "INSERT INTO medical_conditions(patient_id, pec, allergies) VALUES('".$pat_id."','".$this->getPEC()."','".$this->getAllergies()."')";
        $result = $mysqli->query($query);
        if(!$result)
        {
            $this->error_msg .= "error while trying to save data, Please contact support@itilria.co.za for assistance".$mysqli->error;
            echo $this->error_msg;
        }
    }
    /****************************************************************************************************************************/
    
    /*****************************************************************************************************************************/
    //register patient
    function register($mysqli){
        $query = "INSERT INTO patient(staff_id, name, surname, gender, dob, contact, nationality, citizen_id, occupation, address) VALUES('".$this->getStaffID()."', '".$this->getName()."', '".$this->getSurname()."', '".$this->getGender()."', '".date('Y-m-d', strtotime($this->getDOB()))."', '".$this->getContact()."', '".$this->getNationality()."', '".$this->getCitizenID()."', '".$this->getOccupation()."', '".$this->getAddress()."')";
        $result = $mysqli->query($query);
        
        if($result)
        {
            //insert patient id into the database
            $query = "SELECT id FROM patient WHERE name='".$this->getName()."' AND surname='".$this->getSurname()."' LIMIT 1";
            $result = $mysqli->query($query);
            if($result->num_rows == 1)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $this->id = $row['id'];
                $this->setPatientID();
                $query = "UPDATE patient SET patient_id='".$this->getPatientID()."' WHERE name='".$this->getName()."' AND surname='".$this->getSurname()."'";
                $result = $mysqli->query($query);
                if(!$result){
                    echo  $this->error_msg .= "error while trying to save data, Please contact support@itilria.co.za for assistance".$mysqli->error;
                }
                //run other mysql insertions
                $this->registerNok($mysqli, $this->getPatientID());
                $this->insertPec($mysqli, $this->getPatientID());
            }else {
                echo $this->error_msg .= "error while trying to save data, Please contact support@itilria.co.za for assistance".$mysqli->error;
            }
            echo "success";
        }else{
            $this->error_msg .= "error while trying to save data, Please contact support@itilria.co.za for assistance".$mysqli->error;
            echo $this->error_msg;
        }
    }
    
    
    //update patient
    function update()
    {
        
    }
    
    function makeAppointment()
    {
        
    }
    
    function viewAppointments()
    {
        
    }
  
}
?>