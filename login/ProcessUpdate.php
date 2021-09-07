<?php 
require '../config/config.php';
require './user/User.php';
require './user/EmployeeClass.php';
    if(isset($_POST['id_field']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['nationality']) && isset($_POST['contact']) && isset($_POST['profession']) && isset($_POST['practice_number']) && isset($_POST['address']))
    {
        $user_id = $_POST['id_field'];
        $name = $_POST['name'];
        $sur = $_POST['surname'];
        $nat = $_POST['nationality'];
        $con = $_POST['contact'];
        $pro = $_POST['profession'];
        $pra_n = $_POST['practice_number'];
        $addr = $_POST['address'];
        
        
        if(!empty($name) && !empty($sur) && !empty($nat) && !empty($con) && !empty($pro) && !empty($pra_n) && !empty($addr))
        {
            $user = new User();
            $user->setUser($user_id, $name, $sur, $nat, $con, $addr);
            $user->update($mysqli, $user_id);
            
            $e = new EmployeeClass();
            $e->setEmployee($user_id, $pro, $pra_n);
            $e->update($mysqli);
        }else{
            echo "Please fill in all fields!";
        }
        
    }
?>