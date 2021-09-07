<?php 
require '../config/config.php';
require './user/User.php';
if(isset($_POST['id_field']))
{
    $user_id = $_POST['id_field'];
    if(!empty($user_id))
    {
        $user = new User();
        $user->delete($mysqli, $user_id);
        echo "User has been succesfuly deleted";
        header('Location: '.'./admin/staff.php');
    }
}
?>