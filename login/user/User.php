<?php 
    class User{
    private $id = null;
    private $password = null;
    private $current_pwd = null;
    private $new_pwd = null;
    private $confirm_pwd = null;
    private $name = null;
    private $surname = null;
    private $nationality = null;
    private $contact = null;
    private $address = null;
    private $message = null;
    private $username = null;
    
    /*This class serves a purpose of getting the currently logged person general details or the person who is being search from the database */ 
    function getUserResults($mysqli, $id)
    {
        $query = "SELECT * FROM credentials AS c INNER JOIN user AS u ON c.id=u.credential_id WHERE c.id='".$id."'";
        //INNER JOIN employee_details AS e ON c.id=e.credential_id
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->id = $row['id'];
            $this->password = $row['password'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->nationality = $row['nationality'];
            $this->contact = $row['contact'];
            $this->address = $row['address'];
        }
    }
    
    function getEmployeeDetails($mysqli, $id)
    {
        $query = "SELECT * FROM credentials AS c INNER JOIN user AS u ON c.id=u.credential_id INNER JOIN employee_details AS e ON c.id=e.credential_id WHERE c.id='".$id."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo json_encode([true, $row, "userform"]);
        }
    }
    
    /*This class serves a purpose of getting the currently logged person general details or the person who is being search from the database */
    function getCredPassword($mysqli, $id)
    {
        $query = "SELECT password FROM credentials WHERE id='".$id."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->password = $row['password'];
        }
    }

    function isPasswordValid()
    {
        //check if old password match
        $current_pwd = md5($this->current_pwd);
        if($this->password == $current_pwd)
        {
            return true;
        }else{
           return false;
        }
    }
    
    function confirmPassword()
    {
        if($this->new_pwd == $this->confirm_pwd)
        {
            return true;
        }else{
            return false;
        }
    }
    
    function setPasswordProps($current_pwd, $new_pwd, $confirm_pwd)
    {
        $this->current_pwd = $current_pwd;
        $this->new_pwd = $new_pwd;
        $this->confirm_pwd = $confirm_pwd;
    }
    function changePassword($mysqli, $id)
    {
        //check if old password match
        if($this->isPasswordValid() == true)
        {
       
            //confirm if new_pwd == confirm_pwd
            if ($this->confirmPassword() == true) {
                //update password field
                $this->password = md5($this->new_pwd);
                $query = "UPDATE credentials SET password='".$this->password."' WHERE id='".$id."'";
                $result = $mysqli->query($query);
                if($result){
                    echo json_encode([true, "Password has been successfuly changed.", "passwordform", "success"]);
                }else {
                    echo json_encode([false, "Sorry! Failed to change password.", "passwordform", "error"]);
                }
                
            }else{
                //passwords do not match
                echo json_encode([false, "Sorry! passwords do not match.", "passwordform", "error"]);
            }
        }else{
            //old password does not match
            echo json_encode([false, "Sorry! passwords do not match", "passwordform", "error"]);
        }
    }
    function setUser($id, $name, $s, $n, $c, $a){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $s;
        $this->nationality = $n;
        $this->contact = $c;
        $this->address = $a; 
    }
    function getPassword(){
        return $this->password;
    }
    function getName(){
      return $this->name;
    }
    
    function getUsername(){
        return $this->username;
    }
    
    function setUsername($username){
        $this->username = $username;
    }
    
    function getID(){
        return $this->id;    
    }
    function setID($id)
    {
        $this->id = $id;
    }
    
    function getSurname(){
        return $this->surname;
    }
    
    function getNationality(){
        return $this->nationality;
    }
    
    function getContact(){
        return $this->contact;
    }
    
    function getAddress(){
        return $this->address;
    }
    
    function getMessage()
    {
        return $this->message;
    }
    function getInitials(){
        
        $nameInitial = substr($this->getName(), 0, 1);
        
        return $nameInitial;
    }
    
    function update($mysqli, $search_arg){
        $query = "UPDATE user SET name='".$this->getName()."', surname='".$this->getSurname()."', nationality='".$this->getNationality()."', contact='".$this->getContact()."', address='".$this->getAddress()."' WHERE credential_id='".$this->getID()."'";
        $result = $mysqli->query($query);
        if($result)
        {
            $this->message = "User has been successfully updated";
        }else{
            $this->message = "Technical error. Please contact support at support@itilria.co.za"."<br>".$mysqli->error; 
        }
    }
    
    function updateAjax($mysqli){
        $query = "UPDATE user SET name='".$this->getName()."', surname='".$this->getSurname()."', nationality='".$this->getNationality()."', contact='".$this->getContact()."', address='".$this->getAddress()."' WHERE credential_id='".$this->getID()."'";
        $result = $mysqli->query($query);
        if($result)
        {
            echo json_encode([true, 'Your details have been successfully updated', 'updateform', 'success']);
           
        }else{
            echo json_encode([true, 'Technical error. Please contact support at support@itilria.co.za'.$mysqli->error.$mysqli->errno, 'updateform', 'error']);
        }
    }
    
    function updateUsername($mysqli){
        $query = "UPDATE credentials SET username='".$this->getUsername()."' WHERE id='".$this->getID()."'";
        $result = $mysqli->query($query);
        if($result)
        {
            echo json_encode([true, 'Your details have been successfully updated', 'username_form', 'success']);
            
        }else{
            echo json_encode([true, 'Technical error. Please contact support at support@itilria.co.za'.$mysqli->error, 'username_form', 'error']);
        }
    }
    
    function delete($mysqli, $search_arg){
        $query = "DELETE FROM user WHERE credential_id='".$search_arg."'";
        $result = $mysqli->query($query);
        
        $query = "DELETE FROM employee_details WHERE credential_id='".$search_arg."'";
        $result = $mysqli->query($query);
        
        $query = "DELETE FROM credentials WHERE id='".$search_arg."'";
        $result = $mysqli->query($query);
        
    }
}
?>