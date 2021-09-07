<?php 
class EmployeeClass{
    private $profession = null;
    private $practice_number = null;
    private $id = null;
    private $message = null;
    
    function getEmployeeDetails($mysqli, $id)
    {
        $query = "SELECT * FROM employee_details WHERE credential_id='".$id."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->id = $row['id'];
            $this->profession = $row['profession'];
            $this->practice_number = $row['practice_number'];
        }else{
            echo "An error has occured please contact support at support@itilria.co.za";
        }
    }
    
    function getMessage(){
        return $this->message;
    }
    function getID(){
        return $this->id;
    }
    
    function getProfession() {
        return $this->profession;
    }
    
    function getPracticeNumber() {
        return $this->practice_number;
    }

    function setEmployee($id, $p, $pra_n){
        $this->id = $id;
        $this->profession = $p;
        $this->practice_number = $pra_n;
    }
    
    function update($mysqli){
        $query = "UPDATE employee_details SET profession='".$this->getProfession()."', practice_number='".$this->getPracticeNumber()."', WHERE credential_id = '".$this->getID()."'";
        $result = $mysqli->query($query);
        if($result){
            echo "field has been successfuly updated";
        }else{
            $this->message = "Technical error. Please contact support at support@itilria.co.za"."<br>".$mysqli->error;
        }
    }
}
?>