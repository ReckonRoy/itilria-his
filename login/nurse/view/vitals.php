<?php 
session_start();
if((!isset($_SESSION['user_level'])) or ($_SESSION['user_level'] !=3))
{
    header('Location: '."../../../login.php");
}
require '../../../config/config.php';
require '../../user/User.php';

$user = new User();
$user->getUserResults($mysqli, $_SESSION['user_id']);

?>
<!doctype html>
<html lang="en">
<head>
<?php	
	require "./head.php";
?>	
<link rel="stylesheet" href="../../../assets/css/vitals/vitals.css" type="text/css">
</head>
<body>
	<!--NOTIFICATIONS
	<div id="notification-div">
		<div id="n-c-d"></div>
	</div>
	<div id="container">
	-->

	<div id="overlay"></div>
	<div id="server-message-response">
		<input type="button" id="close-btn" value="close">
		<div class="clear_float"></div>
		<p id="message"></p>
	</div>
	
	<?php	
		require "./header.php";
	?>
<main>
	<div id="search-container">
		<form name="nurse_search_form" id="search-form">
			<input type="text" id="search-field" name="search_field" placeholder="type patient id to begin search...">
		</form>
		<div id="search-results"></div>
	</div>
	<div id="patient-details"></div>

	<div id="vitals-div">
		<h2 class="form-header">Examinations</h2>
		<form id="vitals-form" name="vitals_form">
				<input type="hidden" name="p_id" id="patientID-field">
				<label>Temperature</label>
				<input type="text" class="fields" id="temperature" name="temperature">
				<label>degrees celceus</label>
				<!------------------------------------------------------------------------------------>
				<label>Blood glucose</label>
				<input type="text" class="fields" id="blood-glu" name="blood_glu">
				<label>mmol/L</label>
				<!------------------------------------------------------------------------------------>
				<label>Blood pressure</label>
				<input type="text" name="blood_pre" class="fields" id="blood-pre">
				<label>mmHg</label>
				<!------------------------------------------------------------------------------------>
				<label>Weight</label>
				<input type="text" name="weight" id="weight" class="fields">
				<label>kg</label>
				<!------------------------------------------------------------------------------------>
				<label>Height</label>
				<input type="text" name="height" id="height" class="fields">
				<label>m</label>
				<!------------------------------------------------------------------------------------>
				<label>Pulse</label>
				<input type="text" name="pulse" id="pulse" class="fields">
				<label>b/min</label>
				<!------------------------------------------------------------------------------------>
				<!------------------------------------------------------------------------------------>
				<label><sup>%sp0</sup><sub>2</sub></label>
				<input type="text" name="saturation" id="saturation" class="fields">
				<label>%</label>
				<!------------------------------------------------------------------------------------>
				<label>BMI</label>
				<input type="text" name="bmi" id="bmi" class="fields"><label></label>
				<!------------------------------------------------------------------------------------>
				<!------------------------------------------------------------------------------------>
				<label>Time</label>
				<input type="time" name="vitals_time" id="vitals-time" class="fields"><label></label>
				<!------------------------------------------------------------------------------------>
				<!------------------------------------------------------------------------------------>
				<label>Date</label>
				<input type="date" name="vitals_date" id="vitals-date" class="fields"><label></label>
				<!------------------------------------------------------------------------------------>
				<label>Patient History</label>
				<textarea id="history-textarea" name="history" rows="5"></textarea>
				<input type="button" id="vitals-btn" value="Save">
		</form>
	</div>
</main>
<?php	
	require "./aside.php";
?>
	<footer></footer>
</div>
<script type="text/javascript" src="../../../assets/js/search.js"></script>	
<script type="text/javascript" src="../../../assets/js/nurse/nurse.js"></script>
<script type="text/javascript" src="../../../assets/js/nurse/main.js"></script>		
<script type="text/javascript">
	var profile_m_div = document.getElementById("profile-menu-div");
	var avatar = document.getElementById("avatar-div");
	var logout_btn = document.getElementById("logout-btn");
	profile_m_div.style.display = "none";
	
	avatar.addEventListener("click", function(){
		if(profile_m_div.style.display == "none")
		{
			profile_m_div.style.display = "block";
		}else{
			profile_m_div.style.display = "none";
		}
	});
	
	logout_btn.onclick = function()
	{
		window.location.href = "../../logout.php";
	};
</script>
</body>
</html>