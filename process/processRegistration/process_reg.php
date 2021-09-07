<?php
	require("../../config/config.php");

	if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['password']) && isset($_POST['contact']) && isset($_POST['email']) && isset($_POST['nationality']) && isset($_POST['address']) && isset($_POST['co_name']) && isset($_POST['med_dep']) && isset($_POST['co_contact_a']) && isset($_POST['co_contact_b'])&& isset($_POST['co_email']) && isset($_POST['co_address'])){
		$name = htmlentities(strip_tags($_POST['name']));
		$surname = htmlentities(strip_tags($_POST['surname']));
		$password = htmlentities(strip_tags($_POST['password']));
		$account_type = htmlentities(strip_tags($_POST['account_type']));
		$contact = htmlentities(strip_tags($_POST['contact']));
		$email = htmlentities(strip_tags($_POST['email']));
		$address = htmlentities(strip_tags($_POST['address']));
		$national = htmlentities(strip_tags($_POST['nationality']));
		$co_name = htmlentities(strip_tags($_POST['co_name']));
		$med_dep = $_POST['med_dep'];
		$co_contact_a = htmlentities(strip_tags($_POST['co_contact_a']));
		$co_contact_b = htmlentities(strip_tags($_POST['co_contact_b']));
		$co_email = htmlentities(strip_tags($_POST['co_email']));
		$country = htmlentities(strip_tags($_POST['country']));
		$state = htmlentities(strip_tags($_POST['state']));
		$zip = htmlentities(strip_tags($_POST['zip_code']));
		$co_address = htmlentities(strip_tags($_POST['co_address']));

		if(!empty($name) && !empty($surname) && !empty($password) && !empty($contact)
		    && !empty($email) && !empty($address) && !empty($account_type) && !empty($country)
		    && !empty($state) && !empty($zip)){
		    if(strlen($password) < 8){
		        echo "password has to be 8 or more characters long in length";
		        exit();
		    }
		    
		    $facilities = "";
		    foreach($med_dep as $val)
		    {
		        $facilities .= $val.",";
		    }
		    
		    $register = new Register($email, $password, $account_type);
			
            /**************************************Set Input To Setters******************************************************/
			$register->setUser($name, $surname, $national, $contact, $address);
			$register->setHealthFacility($co_name, $facilities, $co_contact_a, $co_contact_b, $co_email, $country, $state, $zip, $co_address, date('d-m-Y'));
			
			/******************************************************************************************************************/
			//Run the process query method to process all mysql queries
			$register->processQuery($mysqli);
            
			//process second batch of data
			//get superadmin id
			$register->setSuperAdminID($mysqli);
			$register->processUserQuery($mysqli);
			$register->createMedDep($mysqli);
			echo $register->getMessage();
		}else{
			echo "Please fill in all fields";
		}
	}else{
		echo "data not set";


	}

	class Register{
		private $name = null;
		private $surname = null;
		private $password = null;
		private $national = null;
		private $contact = null;
		private $email = null;
		private $address = null;
		private $co_name = null;
		private $med_dep = null;
		private $co_contact_a = null;
		private $co_contact_b = null;
		private $co_email = null;
		private $co_country = null;
		private $co_state = null;
		private $co_zip = null;
		private $co_address = null;
		private $superadmin_id = null;
		private $status_boolean = false;
		private $success = null;
		private $error = null;
		private $message = null;
		private $account_type = null;

		/*--------------------------------------------------------------------------------------------------------------
		Constructor intitializes with Credential information values
		--------------------------------------------------------------------------------------------------------------*/
		function __construct($email, $password, $account_type){
			$this->email = $email;
			$this->password = $password;
			$this->account_type = $account_type;
		}
		function getMessage(){
		    if($this->status_boolean == false)
		    {
		        $this->message = $this->error;
		    }else if($this->status_boolean == true){
		        $this->message = $this->success;
		    }
		    
		    return $this->message;
		}
		function getEmail(){
		    return $this->email;
		}
		
		function securePassword(){
		    return md5($this->getPassword());
		}
		
		function getPassword(){
		    return $this->password;
		}
		
		function getSuperAdminID(){
		    return $this->superadmin_id;
		}
		
		function escapeString($arg1, $arg2)
		{
		    return mysqli_real_escape_string($arg1, $arg2);
		}
		
		/***********************************************************************************************************************/
		function getName(){
		    return $this->name;
		}
		function getSurname(){
		    return $this->surname;
		}
		
		function getNational(){
		    return $this->national;
		}
		function getAccountType(){
		    return $this->account_type;
		}
		function getContact(){
		    return $this->contact;
		}
		
		function getAddress(){
		    return $this->address;
		}
		
		function setUser($name, $surname, $nationality, $contact, $address)
		{
		    $this->name = $name;
		    $this->surname = $surname;
		    $this->national = $nationality;
		    $this->contact = $contact;
		    $this->address = $address;
		}
		
		//method inserts user details into the user table
		function processUserQuery($mysqli){
		    $query = "INSERT INTO user(credential_id, name, surname, nationality, contact, address) VALUES('".$this->escapeString($mysqli, $this->getSuperAdminID())."', '".$this->escapeString($mysqli, $this->getName())."', '".$this->escapeString($mysqli, $this->getSurname())."', '".$this->escapeString($mysqli, $this->getNational())."', '".$this->escapeString($mysqli, $this->getContact())."', '".$this->escapeString($mysqli, $this->getAddress())."')";
		    
		    $result = $mysqli->query($query);
		    if($result){
		        $this->status_boolean = true;
		        $this->success = $this->getName()." ".$this->getSurname()." has been successfuly registered.";
		        
		    }else{
		        $this->status_boolean = false;
		        $this->error .= "Technical error. Please contact support@itilria.co.za";
		    }
		}
		/******************************************************************************************************************************************/
		//method creates user credentials for superadmin
		function processQuery($mysqli)
		{
		    //check if user does not already exist
		    $query = "SELECT email, id FROM credentials WHERE email = '".$this->getEmail()."'";
		    $result = $mysqli->query($query);
		    if($result->num_rows != 0){
		        $this->error = "Sorry this user account is already taken";
		        echo $this->error;
		        exit();
		    }
		   
		    //get role_id belonging to the account type
            $query = "SELECT id FROM roles_permissions WHERE roles='".$this->getAccountType()."'";
            $result = $mysqli->query($query);
            if($result){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $role_id = $row['id'];
                
                $query = "INSERT INTO credentials(role_id, email, password, account_type) VALUES('".$role_id."', '".$this->escapeString($mysqli, trim( $this->getEmail()) )."', '".$this->escapeString($mysqli, trim( $this->securePassword()))."', '".$this->getAccountType()."')";
                $result = $mysqli->query($query);
                if($result){
                    
                    /*------------------------------------------------------------------------------------------------------------*
                     *Register user based on credentials id
                     *------------------------------------------------------------------------------------------------------------*/
                    $this->status_boolean = true;
                    $this->success = $this->getName()." ".$this->getSurname()." has been successfuly registered.";
                    
                }else{
                    $this->status_boolean = false;
                    $this->error .= "Technical error. Please contact support@itilria.co.za".$mysqli->error;
                }
            }
		 }
	/*----------------------------------------------------------------------------------------------------------------------------*/
  	    
  	    /*Getters and Setter for health care information*/
		function getCompanyName(){
			return $this->co_name;
		}
		function getDepartments(){
			return $this->med_dep;
		}
		function getCompanyCountry(){
		    return $this->co_country;
		}
		function getCompanyState(){
		    return $this->co_state;
		}
		function getCompanyZip(){
		    return $this->co_zip;
		}
		function getCompanyContactA(){
		  return $this->co_contact_a;
		}
		function getCompanyContactB(){
		    return $this->co_contact_b;
		}
		function getCompanyEmail(){
		  return $this->co_email;
		}
		function getCompanyAddress(){
		  return $this->co_address;
		}
		function setHealthFacility($name, $departments, $contact_a, $contact_b, $email, $country, $state, $zip, $address)
		{
			$this->co_name = $name;
			$this->med_dep = $departments;
			$this->co_contact_a = $contact_a;
			$this->co_contact_b = $contact_b;
			$this->co_email = $email;
			$this->co_country = $country;
			$this->co_state = $state;
			$this->co_zip = $zip;
			$this->co_address = $address;
		}

		//query database for superadmin id
		function setSuperAdminID($mysqli){
			$query = "SELECT id FROM credentials WHERE email = '".$this->getEmail()."'";
			$result = $mysqli->query($query);
			if($result->num_rows == 1){
			    $row =  $result->fetch_array(MYSQLI_ASSOC);
			    $this->superadmin_id = (int)$row['id'];
			}
		}
		
	  	function createMedDep($mysqli)
	  	{
	  	    $query = "INSERT INTO company(staff_id, co_name, departments, co_contact_a, co_contact_b, co_email, co_country, co_state, co_zipCode, co_address, date_registered) VALUES('".$this->escapeString($mysqli, $this->getSuperAdminID())."', '".$this->escapeString($mysqli, $this->getCompanyName())."','".$this->escapeString($mysqli, $this->getDepartments())."','".$this->escapeString($mysqli, $this->getCompanyContactA())."','".$this->escapeString($mysqli, $this->getCompanyContactB())."','".$this->escapeString($mysqli, $this->getCompanyEmail())."', '".$this->escapeString($mysqli, $this->getCompanyCountry())."','".$this->escapeString($mysqli, $this->getCompanyState())."','".$this->escapeString($mysqli, $this->getCompanyZip())."','".$this->escapeString($mysqli, $this->getCompanyAddress())."', CURDATE())";
	  	    
	  		/*Open a new database connection and proceed with next batch of queries*/
	        $result = $mysqli->query($query);
	      	if($result){
	      		//success message
	      		$this->status_boolean = true;
	      		$this->success .= "<br> Company: ".$this->getCompanyName().", has been successfuly registered.";
	      	}else{
	      		//error message
	      		$this->status_boolean = false;
	      		$this->error .= "Failed to save data".$mysqli->error;
	      	}

	      	//close database connection
			
			$mysqli->close();
	  	}
}
?>