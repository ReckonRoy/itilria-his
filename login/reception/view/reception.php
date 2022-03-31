<?php 
    session_start();
    if((!isset($_SESSION['user_level'])) or ($_SESSION['user_level'] !=4))
    {
        header('Location: '."../../../login.php");
    }
    require '../../../config/config.php';
    require '../../user/User.php';
    $user = new User();
    $user->getUserResults($mysqli, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		require './head.php';
	?>
	<link rel="stylesheet" type="text/css" href="../../../assets/css/reception/patientreg.css">
</head>
<body>

	<div id="overlay"></div>
	<div id="server-message-response">
		<input type="button" id="close-btn" value="close">
		<div class="clear_float"></div>
		<p id="message"></p>
	</div>

<?php
	require './header.php';
?>
<?php
	require './aside.php';
?>

<main id="">
	<h2 id="main-header">Patient Profile Registration Form</h2>
	<div id="form_div">
		<form name="addPatient_form" id="add-patient-form">
			<fieldset id="basic-det">
				<label for="patient_name">Name</label>
				<input type="text" name="patient_name" id="patient_name" class="fields" placeholder="Please enter patient's name">
				<label for="lastname">Last name</label>
				<input type="text" name="surname" id="lastname" class="fields" placeholder="Please enter patient's surname">
				<div id="gender_div">
					<label for="female">Female</label>
					<input type="radio" name="gender" value="female" id="female">
					<label for="male">Male</label>
					<input type="radio" name="gender" value="male" id="male">
				</div>
				<label for="patient_dob">Date of birth</label>
				<input type="date" class="fields" id="patient_dob" name="dob">
				<label for="patient-cont">contact</label>
				<input type="text" class="fields" name="contact" id="patient-cont" placeholder="Phone details">
				<label for="nationality">Nationality</label>
				<input type="text" class="fields" name="nationality" id="nationality">
				<label for="citizen-id">National ID</label>
				<input type="text" name="citizen_id" class="fields" id="citizen-id">
				<label for="occupation">Occupation</label>
				<input class="fields" type="text" name="occupation" id="occupation" placeholder="Occupation">
				<label for="address">Address</label>
				<textarea rows="3" cols="40" name="address" placeholder="Enter patients address here"></textarea>
			</fieldset>
			<!--
			<fieldset id="marital_status">
				<legend>Marital status</legend>
				<label for="single">Single</label><input type="radio" name="marital_status" value="single">
				<label for="married">Married</label><input type="radio" name="marital_status" value="married">
				<label for="devorced">Devorced</label><input type="radio" name="marital_status" value="devorced">
				<label for="widow">Widow</label><input type="radio" name="marital_status" value="widow">
			</fieldset>
			-->
			<fieldset id="medical-cond">
				<legend>Medical Conditions</legend>
				<label for="pec">Pre existing conditions</label>
				<textarea rows="3" cols="40" id="pec" name="pec" id=""></textarea>
				<label for="allergies">Allergies</label>
				<input type="text" class="fields" name="allergies" id="allergies">
			</fieldset>
			<!--
			<fieldset id="m-o-p">
				<legend>Mode Of Payment</legend> 
				<label for="ecocash">Ecocash</label><input type="radio" value="Ecocash" name="modeofpayment">
				<label for="ecocash">Ecocash</label><input type="radio" value="OneMoney" name="modeofpayment">
				<label for="ecocash">Ecocash</label><input type="radio" value="Telecash" name="modeofpayment">
				<label for="ecocash">Cash</label><input type="radio" value="Cash" name="modeofpayment">
				<label for="ecocash">Debit</label><input type="radio" value="Debit" name="modeofpayment">
			</fieldset>
			-->
			<fieldset id="nok">
				<legend>Next of kin</legend>
				<label for="nok-name">Name</label>
				<input type="text" name="nok_name" id="nok-name" class="fields">
				<label for="nok-lname">Last name</label>
				<input type="text" name="nok_lname" id="nok-lname" class="fields">
				<label id="nok-contact">Contact number</label>
				<input type="text" name="nok_contact" id="nok-contact" class="fields">
				<label for="nok-id">Identity Number</label>
				<input type="text" name="nok_id" id="nok-id" class="fields">
				<label for="nok-rel">Relationship</label>
				<div id="nd-parent">
					<input type="text" name="nok_rel" id="nok-rel" class="fields">
				<div id="nok-dropdown">
					<ol id="rel-ol">
						<li>Brother</li>
						<li>Sister</li>
						<li>Mother</li>
						<li>Father</li>
						<li>Uncle</li>
						<li>Auntie</li>
						<li>Grandmother</li>
						<li>Grandfather</li>
					</ol>
				</div>
				</div>
				<label>Address</label>
				<textarea name="nok_address" id="nok-address" rows="3" cols="40"></textarea>
			</fieldset>
			<!--
			<fieldset id="employer-det">
				<label for="employer">Employer's name</label>
				<input type="text" class="fields" name="employer_name" id="employer">
				<label for="employer-contact">Employer's contact Number</label>
				<input type="text" class="fields" name="employer_contact" class="contact" id="employer-contact">
				<label>Employer Address</label>
				<textarea name="employers_address" id="emp_addr" rows="3" cols="40"></textarea>
			</fieldset>
			-->
			<input type="button" id="reg_btn" value="Register Patient">
		</form>
	</div>
</main>

<script type="text/javascript" src="../../../assets/js/reception/main.js"></script>
<script type="text/javascript" src="../../../assets/js/reception/reception.js"></script>	
</body>
</html>