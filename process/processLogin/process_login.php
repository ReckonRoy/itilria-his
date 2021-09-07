<?php
    require "../../config/config.php";
    if(isset($_POST['email']) && isset($_POST['password']))
    {
        $email = htmlentities(strip_tags($_POST['email']));
        $password = htmlentities(strip_tags($_POST['password']));
        if(!empty($email) && !empty($password))
        {
            $login = new Login();
            $login->setEmail($email);
            $login->setPassword($password);
            $login->setUsername($email);
            $login->queryDatabase($mysqli);
        }else{
            echo json_encode([false, "Please fill in all fields"]);
        }
    }
    
    //Class class processes all user authentication 
    class Login{
        private $email = null;
        private $password = null;
        private $username = null;
        
        function setEmail($email){
            $this->email = $email;
        }
        
        function setPassword($password){
            $this->password = $password;
        }
        
        function setUsername($username){
            $this->username = $username;
        }
        
        function getEmail()
        {
            return $this->email;
        }
        
        function getPassword()
        {
            return md5($this->password);
        }
        
        function getUsername(){
            return $this->username;
        }
        function queryDatabase($mysqli)
        {
            $query = "SELECT id, role_id FROM credentials WHERE email='".$this->getEmail()."' OR username='".$this->getUsername()."' AND password = '".$this->getPassword()."'";
            $result = $mysqli->query($query);
            {
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $id = $row['id'];
                    "<br>";
                    $role_id = $row['role_id'];
                    $query = "SELECT roles, level FROM roles_permissions WHERE id = '".$role_id."'";
                    $result = $mysqli->query($query);
                    if($result->num_rows == 1)
                    {
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        $user_level = $row['level'];
                        $user_role = $row['roles'];
                        session_start();
                        $_SESSION['user_id'] = $id;
                        $_SESSION['user_level'] = (int)$user_level;
                        $url = "";
                        if($_SESSION['user_level'] == 1){
                            $url = "./login/admin/admin.php";
                            echo json_encode([true, $url]);
                        }else if($_SESSION['user_level'] == 2){
                            $url = "./login/doctor/view/consultation.php";
                            echo json_encode([true, $url]);
                        }else if($_SESSION['user_level'] == 3){
                            $url = "./login/nurse/view/vitals.php";
                            echo json_encode([true, $url]);
                        }else if($_SESSION['user_level'] == 4){
                            $url = "./login/reception/view/reception.php";
                            echo json_encode([true, $url]);
                        }
                        //header('Location: '.$url);
                        $result->close();
                        exit();
                    }
                   
                    //header('Location: '."../../index.php");
                    
                }else{
                    echo $mysqli->error; 
                    echo json_encode([false, "email and password do not match. Please provide correct details and try again!"]);
                    $result->close();
                }
            }
        }
    }
?>