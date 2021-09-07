<?php
class RolesPermissions{
    private $role = null;
    private $role_id = null;
    function __construct($role){
        $this->role = $role;
    }
    
    function getRole(){
        return $this->role;
    }
    
    function getRoleID(){
        return $this->role_id;
    }
    
    function setRoleID($role_id)
    {
        $this->role_id = $role_id;
    }
    
    function getRoleFromDB($mysqli){
        $query = "SELECT id FROM roles_permissions WHERE roles='".$this->getRole()."'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $this->setRoleID($row['id']);
        }else{
            echo "RolesPermissions says: ".$mysqli->error;
        }
    }
}
?>