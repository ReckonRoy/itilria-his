<?php 
require '../../config/config.php';
require './UserCredentials.php';
require './User.php';
require './EmployeeClass.php';
    if(isset($_POST['email']))
    {
        $email = $_POST['email'];
        if(!empty($email)){
            //Query user credentials to get user_id
            $user_cre = new UserCredentials($mysqli, $email);
            if($user_cre->getStatus() == false)
            {
                echo json_encode([false, $user_cre->getMessage()]);
                exit();
            }
            $user = new User();
            $user->getUserResults($mysqli, $user_cre->getID());
            $employee = new EmployeeClass();
            $employee->getEmployeeDetails($mysqli, $user_cre->getID());
            $user_array = array($user_cre->getEmail() => array('user_id'=>$user_cre->getID(), 'email' => $user_cre->getEmail(), 'name' => $user->getName(), 'surname'=>$user->getSurname(), 'nationality'=>$user->getNationality(), 'contact'=>$user->getContact(), 'address'=>$user->getAddress(), 'profession'=>$employee->getProfession()));
            
            echo json_encode([true, $user_array]);
        }else{
            echo "Please fill in search field with employee email address";
        }
    }
?>