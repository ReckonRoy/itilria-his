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
    
    if(empty($current_pwd) || empty($new_pwd) || empty($confirm_pwd))
    {
        echo json_encode([false, "Please fill in all password related fields", "passwordform", "error"]);
        exit();
    }
    $user = new User();
    $user->getCredPassword($mysqli, $id);
    $user->setPasswordProps($current_pwd, $new_pwd, $confirm_pwd);
    $user->changePassword($mysqli, $id);
}else if(isset($_POST['update_id'])){
    $staff_id = $_POST['update_id'];
    $name = $_POST['fname'];
    $surname = $_POST['lname'];
    $nationality = $_POST['nationality'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    
    $user = new User();
    $user->setUser($staff_id, $name, $surname, $nationality, $contact, $address);
    $user->updateAjax($mysqli);
}else if(isset($_POST['username_id'])){
    $staff_id = $_POST["username_id"];
    $username = $_POST['username'];
    if(empty($username))
    {
        echo json_encode([false, "Please fill in the username field", "username_form", "error"]);
        exit();
    }
    $user = new User();
    $user->setUsername($username);
    $user->setID($staff_id);
    $user->updateUsername($mysqli);
}
?>
