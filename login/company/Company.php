<?php
class Company{
    
    private $co_name;
    private $co_id;
    
    function __construct($mysqli, $user_id){
        $query = "SELECT id, co_name FROM company WHERE staff_id = '".$user_id."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->co_id = $row['id'];
            $this->co_name = $row['co_name'];
        }else{
            echo "Company says: ".$mysqli->error;
        }
    }
    
    function getCompanyName()
    {
        return $this->name; 
    }

    function getCompanyID()
    {
        return $this->co_id;
    }
}
?>