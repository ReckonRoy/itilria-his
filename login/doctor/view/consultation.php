<?php 
session_start();
if((!isset($_SESSION['user_level'])) or ($_SESSION['user_level'] !=2))
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
	<link rel="stylesheet" href="../../../assets/css/doctor/consultation.css" type="text/css">
	</head>
	<body>

		<div id="container">
		<?php	
			require "./header.php";
		?>
		<div id="emr-container">
			
			<div id="emr-record-div">
							
				</div>
				<div id="close">close</div>
			</div>
		<main>
			<!--********************************************************************************************************************* *div for patient details
			*search patient
			*patient history
			*patient vital results
			*patient notes
			*investigations and results
			*plan
			*********************************************************************************************************************-->
			
				<div id="search-container"><!-- form for searching patient -->
					<form id="search-form" name="doctor_search_form">
						<input type="text" id="search-field" placeholder="Type here to begin search..." name="search_field">
					</form>
					<div id="search-results"><!-- div for resulta of search -->
						<p>search results will appear hear</p>
					</div>
				</div>
				<div id="patient-details"></div>
				<div id="control-div">
					<!--EMR, Request -Controls- -->
					<button id="emr-btn">EMR</button>

				</div>
				<div id="c-container">
				<!-------------------------------------------------------------------------------------------------------------------->
				<div id="patient-history"><!--PATIENT HISTORY SECTION-->
					
				</div>
				<!--------------------------------------------------------------------------------------------------------------->
				<div id="patient-vitals"><!--PATIENT VITALS SECTION-->
					<button id="fetch-v-btn">Fetch Vitals Data</button>
					<form id="vitals-form" name="vitals_form">
						<input type="hidden" name="vitals_pid" id="patientID-field">
					</form>
					<div id="vitals-container">
						
					</div>
				</div>
				<!-------------------------------------------------------------------------------------------------------------->
				<div id="patient-notes"><!--PATIENT NOTES SECTION-->
					<form id="notes-form" name="notes_form" class="ops-form">
						<input type="hidden" name="notes_pid">
						<label>Doctor's Notes</label>
						<textarea name="doctors_notes" rows="5"></textarea>
						<input type="button" id="savenotes-btn" class="save_btn" value="Save">
					</form>
				</div>
				<!-------------------------------------------------------------------------------------------------------------->
				<div id="assesment"><!--PATIENT ASSESMENT SECTION-->
					<form id="assesment-form" name="assesment_form" class="ops-form">
						<input type="hidden" name="asses_pid">
						<label>Symptoms</label>
						<input type="text" name="symptoms" placeholder="enter symptoms as comma separated values">
						<label>Signs</label>
						<input type="text" name="signs" placeholder="enter signs as comma separated values">
						<input type="button" value="Save" class="save_btn" id="saveassesment-btn">
					</form>
				</div>
				<!------------------------------------------------------------------------------------------------------------->
				<!------------------------------------------------------------------------------------------------------------->
				<div id="procedures"><!--PATIENT INVESTIGATIONS AND PROCEDURES SECTION-->
					<form id="procedures-form" name="procedures_form" class="ops-form">
						<input type="hidden" name="proc_pid">
						<label>Investigation</label>
						<textarea name="investigation" rows="5"></textarea>
						<label>Procedures</label>
						<textarea name="procedures" rows="5"></textarea>
						<input type="button" id="save-proc-btn" class="save_btn" value="Save">
					</form>
				</div>
				<!------------------------------------------------------------------------------------------------------------>
				<!------------------------------------------------------------------------------------------------------------->
				<div id="prescription"><!--PATIENT Prescription SECTION-->
					<form id="prescription-form" name="prescription_form" class="ops-form">
						<input type="hidden" name="presc_pid">
						<label>Prescription</label>
						<textarea name="prescription" rows="5"></textarea>
						<input type="button" id="save-presc-btn" class="save_btn" value="Save">
					</form>
				</div>
				<!------------------------------------------------------------------------------------------------------------>
				<!------------------------------------------------------------------------------------------------------------->
				<div id="plans"><!--PATIENT PLANS SECTION-->
					<form id="plan-form" name="plan_form" class="ops-form">
						<input type="hidden" name="plan_pid">
						<label>Plan</label>
						<textarea name="plan" rows="5"></textarea>
						<input type="button" id="save-plan-btn" class="save_btn" value="Save">
					</form>
				</div>
				<!------------------------------------------------------------------------------------------------------------->
			</div>
		</main>
		<?php	
			require "./aside.php";
		?>
			<footer></footer>
		</div>		
		
		<script type="text/javascript" src="../../../assets/js/search.js"></script>
		<script type="text/javascript" src="../../../assets/js/vitals.js"></script>
		<script type="text/javascript" src="../../../assets/js/doctor/doctor.js"></script>
		<script type="text/javascript" src="../../../assets/js/emr.js"></script>
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