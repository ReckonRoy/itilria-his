<?php
/**
 * @author Le-Roy S. Jongwe
 * @desc This class returns User credentials of current user and that of the user
 * who is being queried in the database.
 * 
 */
class UserCredentials{
    private $companyID = null;
    private $id = null;
    private $roleID = null;
    private $password = null;
    private $email = null;
    private $username = null;
    private $boolean_status = false;
    private $message = null;
    
    function __construct($mysqli, $email){
        $query = "SELECT * FROM credentials WHERE email='".$email."' LIMIT 1";
        $result = $mysqli->query($query);
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->id = $row['id'];
            $this->companyID = $row['co_id'];
            $this->roleID = $row['role_id'];
            $this->email = $row['email'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->boolean_status = true;
        }else{
            $this->boolean_status = false;
            $this->message = "Sorry this email address does not exist!<br> please try again with the correct email address";
            
        }
    }
    function getMessage(){
        return $this->message;
    }
    function getStatus(){
        return $this->boolean_status;
    }
    function getID(){
        return $this->id;
    }
    
    function getCompanyID(){
        return $this->companyID;
    }
    
    function getRoleID(){
        return $this->roleID;
    }
        
    function getUsername(){
        return $this->username;
    }
    
    function setUsername($u)
    {
        $this->username = $u;
    }
    
    function getEmail(){
        return $this->email;    
    }
    
    function setNewPassword($password) {
        $this->password = $password;
    }
}
    
?>