<?php 
    class User{
    private $id = null;
    private $name = null;
    private $surname = null;
    private $nationality = null;
    private $contact = null;
    private $address = null;
    private $message = null;
    
    /*This class serves a purpose of getting the currently logged person general details or the person who is being search from the database */ 
    function getUserResults($mysqli, $id)
    {
        $query = "SELECT * FROM user WHERE credential_id='".$id."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->id =$row['id'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->nationality = $row['nationality'];
            $this->contact = $row['contact'];
            $this->address = $row['address'];
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
    
    function getName(){
      return $this->name;
    }
    function getID(){
        return $this->id;    
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
        $surnameInitial = substr($this->getSurname(), 0, 1);
        
        return $nameInitial." ".$surnameInitial; 
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