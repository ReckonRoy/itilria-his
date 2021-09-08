<?php 
session_start();
if((!isset($_SESSION['user_level'])) or ($_SESSION['user_level'] !=1))
{
    header('Location: '."../../login.php");
}
require '../../config/config.php';
require '../company/Company.php';
require '../RolesPermissions.php';

if(isset($_POST['name_field'])){
    $name = $_POST['name_field'];
    $surname = htmlentities(strip_tags($_POST['surname']));
    $email = htmlentities(strip_tags($_POST['email']));
    $contact = htmlentities(strip_tags($_POST['contact']));
    $profession = htmlentities(strip_tags($_POST['profession']));
    $practice_number = $_POST['practice_number'];
    $account_type = htmlentities(strip_tags($_POST['account_type']));
    $nationality = htmlentities(strip_tags($_POST['nationality']));
    $originalDate = $_POST['start_date'];
    $formatedHireDate = date('Y-m-d', strtotime($originalDate));
    $address = htmlentities(strip_tags($_POST['address']));
    $password = "12345678";
    if(!empty($name)){
    
            $company = new Company($mysqli, $_SESSION['user_id']);
            $rolespermissions = new RolesPermissions($account_type); 
            $rolespermissions->getRoleFromDB($mysqli);
            $register = new Register($email, $account_type, $password, $rolespermissions->getRoleID(), $company->getCompanyID());
            $register->setUser($name, $surname, $contact, $nationality, $address);
            $register->setEmployeeDetails($profession, $practice_number, $formatedHireDate);
            $register->processQuery($mysqli);
    }else{
        echo json_encode([false, "Please fill in all required fields denoted by a *"]);
    }
}else{
    echo json_encode([false, "Please fill in all required fields denoted by a *"]);
}

class Register{
    private $name = null;
    private $surname = null;
    private $password = null;
    private $nationality = null;
    private $contact = null;
    private $email = null;
    private $address = null;
    private $profession = null;
    private $practice_number = null;
    private $user_id = null;
    private $status_boolean = false;
    private $start_date = false;
    private $success = null;
    private $error = null;
    private $message = null;
    private $role_id = null;
    private $co_id = null;
    private $account_type = null;
    
    /*--------------------------------------------------------------------------------------------------------------
     Constructor intitializes with Credential information values
     --------------------------------------------------------------------------------------------------------------*/
    function __construct($email, $account, $password, $role_id, $co_id){
        $this->email = $email;
        $this->password = $password;
        $this->account_type = $account;
        $this->role_id = $role_id;
        $this->co_id = $co_id;
    }
    
    function getMessage(){
        if($this->status_boolean == false)
        {
            $this->message = $this->error;
        }else if($this->status_boolean == true){
            $this->message = $this->success;
        }
        
        return $this->message;
    }
    function getEmail(){
        return $this->email;
    }
    function getRoleID(){
        return $this->role_id;
    }
    
    function getAccountType(){
        return $this->account_type;
    }
    
    function getCompanyID(){
        return $this->co_id;
    }
    function securePassword(){
        return md5($this->getPassword());
    }
    
    function getPassword(){
        return $this->password;
    }
    
    /***********************************************************************************************************************/
    function getUserID(){
        return $this->user_id;
    }
    function getName(){
        return $this->name;
    }
    function getSurname(){
        return $this->surname;
    }
    
    function getNationality(){
        return $this->nationality;
    }
    
    function getProfession(){
        return $this->profession;
    }
    
    function getPracticeNumber(){
        return $this->practice_number;
    }

    function getStartDate(){
        return $this->start_date;
    }
    function getContact(){
        return $this->contact;
    }
    
    function getAddress(){
        return $this->address;
    }
    
    function escapeString($arg1, $arg2)
    {
        return mysqli_real_escape_string($arg1, $arg2);
    }
    
    function setUser($name, $surname, $contact, $nationality, $address)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->nationality = $nationality;
        $this->contact = $contact;
        $this->address = $address;
    }
    
    function setEmployeeDetails($profession, $practice_number, $start_date){
        $this->profession = $profession;
        $this->practice_number = $practice_number;
        $this->start_date = $start_date;
    }
    
    //method inserts user details into the user table
    function processUserQuery($mysqli){
        $query = "INSERT INTO user(credential_id, name, surname, nationality, contact, address) VALUES('".$this->escapeString($mysqli, $this->getUserID())."', '".$this->escapeString($mysqli, $this->getName())."', '".$this->escapeString($mysqli, $this->getSurname())."', '".$this->escapeString($mysqli, $this->getNationality())."', '".$this->escapeString($mysqli, $this->getContact())."', '".$this->escapeString($mysqli, $this->getAddress())."')";
        
        $result = $mysqli->query($query);
        if($result){
            $this->status_boolean = true;
            $this->success .= $this->getName()." ".$this->getSurname()." has been successfuly registered.";
        }else{
            $this->status_boolean = false;
            $this->error .= "Technical error. Please contact support@itilria.co.za<br>".$mysqli->error."<br>processUserQuery() method";
        }
    }
    
    /******************************************************************************************************************************************/
    //query database for the credential id of the just registered user
    function getUserIDFromDB($mysqli){
        $query = "SELECT id FROM credentials WHERE email = '".$this->getEmail()."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1){
            $row =  $result->fetch_array(MYSQLI_ASSOC);
            $this->user_id = $row['id'];
        }
    }
    /******************************************************************************************************************************************/
    //method inserts employee details into the company table
    function processEmployeeQuery($mysqli){
        $query = "INSERT INTO employee_details(credential_id, profession, practice_number, start_date) VALUES('".$this->escapeString($mysqli, $this->getUserID())."', '".$this->escapeString($mysqli, $this->getProfession())."',  '".$this->escapeString($mysqli, $this->getPracticeNumber())."','".$this->escapeString($mysqli, $this->getStartDate())."')";
        
        $result = $mysqli->query($query);
        if($result){
            $this->status_boolean = true;
            $this->success .= "employee details has been successfuly registered.";
        }else{
            $this->status_boolean = false;
            $this->error .= "Technical error. Please contact support@itilria.co.za".$mysqli->error;
        }
    }
    /******************************************************************************************************************************************/
    //method inserts user credentials into database and further processes other queries
    function processQuery($mysqli)
    {
        //check if user does not already exist
        $query = "SELECT email, id FROM credentials WHERE email = '".$this->getEmail()."'";
        $result = $mysqli->query($query);
        if($result->num_rows != 0){
            $this->error = "Sorry this user account is already taken";
            echo $this->error;
            exit();
        }
        
        $query = "INSERT INTO credentials(co_id, role_id, email, account_type, password) VALUES('".$this->escapeString($mysqli, trim( $this->getCompanyID()) )."', '".$this->escapeString($mysqli, trim( $this->getRoleID()) )."', '".$this->escapeString($mysqli, trim( $this->getEmail()) )."', '".$this->escapeString($mysqli, trim( $this->getAccountType()) )."', '".$this->escapeString($mysqli, trim( $this->securePassword()) )."')";
        $result = $mysqli->query($query);
        if($result){
            
            /*------------------------------------------------------------------------------------------------------------*
             *Register user based on credentials id
             *------------------------------------------------------------------------------------------------------------*/
            $this->getUserIDFromDB($mysqli);
            //Run user general info insertion query
            $this->processUserQuery($mysqli);
            //Run emplyee details info insertion query
            $this->processEmployeeQuery($mysqli);
            
            $this->success = $this->getName()." ".$this->getSurname()." has been successfuly registered.";
            $class_success = "success";
            echo json_encode([true, $this->success, $class_success]);
            
        }else{
            $class_error = "error";
            $this->error .= "Technical error. Please contact support@itilria.co.za";
            echo json_encode([false, $this->error, $class_error]);
        }
    }
}

?>