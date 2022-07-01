 <?php 
session_start();
if((!isset($_SESSION['user_level'])) or ($_SESSION['user_level'] !=1))
{
    header('Location: '."../../login.php");
}
require '../../config/config.php';
require '../user/User.php';

$user = new User();
$user->getUserResults($mysqli, $_SESSION['user_id']);

?>
<!doctype html>
<html lang="en">
	<?php	
		require "./head.php";
	?>	
	<body>

		<div id="container">
		<?php	
			require "./header.php";
		?>
		<main>
			<h2>Dashboard</h2>
			<div id="dashboard">
				<!-- Doctor Card-->
				<div class="f-dc-cl">
					<div>Doctor(s)</div>
					<div id="doctor-count"></div><!-- Figures taken from database-->
				</div>

				<!-- Patient Card-->
				<div class="f-dc-cl">
					<div id="patient-id">Patient(s)</div>
					<div id="patient-count"></div><!-- Figures taken from database-->
				</div>

				<!-- Nurse Card-->
				<div class="f-dc-cl">
					<div>Nurse(s)</div>
					<div id="nurse-count"></div><!-- Figures taken from database-->
				</div>

				<!-- Receptionist Card-->
				<div class="f-dc-cl">
					<div>Receptionist</div>
					<div id="receptionist-count"></div><!-- Figures taken from database-->
				</div>
			</div>
		</main>
		<?php	
			require "./aside.php";
		?>
		<footer></footer>
	</div>
	<?php
	//$prev_location = $_SERVER['HTTP_REFERER'];
	//$prev_location = substr($prev_location, stripos($prev_location, "doctor"), strlen("doctor"));
	//$prev_location;
	//$current_page = $_SERVER['SCRIPT_NAME'];
	$current_page = $_SERVER['SCRIPT_NAME'];
	?>
	<input type="hidden" id="curr_page" value="<?php substr($current_page, stripos($current_page, "doctor")); ?>">

<script type="text/javascript" src="../../assets/js/admin/main.js"></script>
<script type="text/javascript" src="../../assets/js/admin/dashboard.js"></script>
</body>
</html>