<?php
require "../../../config/config.php";
require "../User.php";

if(isset($_POST['employee_id']))
{
    $employee_id = $_POST['employee_id'];
    if(!empty($employee_id) && is_numeric($employee_id))
    {
        $user = new User();
        $user->getEmployeeDetails($mysqli, $employee_id);
    }else{
        echo json_encode([false, "invalid parameter passed. Please contact us at support@itilria.co.za or call +27 81 262 4772"]);
    }
}elseif(isset($_POST['staff_pwd_id']) && isset($_POST['current_pwd']) && isset($_POST['new_pwd']) && isset($_POST['confirm_pwd'])){
    $id = $_POST['staff_pwd_id'];
    $current_pwd = $_POST['current_pwd'];
    $new_pwd = $_POST['new_pwd'];
    $confirm_pwd = $_POST['confirm_pwd'];
    
    $user = new User();
    $user->getCredPassword($mysqli, $id);
    $user->setPasswordProps($current_pwd, $new_pwd, $confirm_pwd);
    $user->changePassword($mysqli, $id);
}
?>