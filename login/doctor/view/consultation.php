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

		<!-- Overlay -->
		<div id="overlay"></div>
<!--/**********************************************************************************************************
TABLE CONTAINING PRESCRIPTION DETAILS
************************************************************************************************************/-->
		<!--Pass staff id to server -->
		<input type="hidden" name="staff_id" value="<?php echo $_SESSION['user_id']?>" id="staff-id">
		<input type="button" value="Close" id="close-print-btn">
		<input type="button" value="Print" id="print-btn">
		<div id="enlarged-img-div">
			<input type="button" class="close" id="close-eid" value="X">
			<img src="" alt="placeholder+image" id="enlarged-img">
		</div>
			<div id="print-prescription-div">
				<center>
				<table class="print_prescription_table" borderColor="black" border="1px"
				 width="600" cellpadding="2" cellspacing="2">
				<thead>
					<tr>
						<th colspan="3" class="prescription_thead">Countryside Pharmacy</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="3" id="td-pat-name" class="prescription_tdata">Patient's Name:</td>
					</tr>
					<tr>
						<td colspan="3" id="td-pat-addr" class="prescription_tdata">Address:</td>
					</tr>
					<tr>
						<td class="prescription_tdata" id="td-pat-age">Age:</td>
						<td class="prescription_tdata" id="td-pat-gender">Sex:</td>
					</tr>
					<!-- Body -->
					<tr>
						<th colspan="3" class="theadClass">Drugs Prescribed</th>
					</tr>
					<tr>
						<td colspan="3" height="300" id="td-pat-presc" style="white-space: pre-line;" valign="top" class="drugs_prescribed">
							
						</td>
					</tr>
					<!-- Footer-->
					<tr>
						<td colspan="3" id="td-doc-name" class="prescription_tdata">Practitioner's Name and Qulifications:</td>
					</tr>
					<tr>
							<td class="prescription_tdata">Signature</td>
							<td class="prescription_tdata">AFOZ No, 049830</td>
					</tr>
					<tr>
						<td colspan="3" id="td-presc-date" class="prescription_tdata">Date:</td>
					</tr>
				</tbody>
			</table>
			</center>
		</div>

<!--/***************************************************************************************************************************/-->
		<div id="container">
		<?php	
			require "./header.php";
		?>
<!----------------------------------------------------PATIENT EMR SECTION-------------------------------------------------------->
		<div id="emr-container">
			<!-- Patient Medical Record-->
			<div id="emr-record-div"></div>

			<!-- Patient Record List By dates -->
			<div id="emr-rd-div">
			</div>

			<div id="emr-chargesheet">
			<img src="" alt="placeholder+image" id="chargesheet-image">
			<form>
				<input type="hidden" name="img_pid" id="img-pid">
				<input type="button" value="Get chargesheet" id="chargesheet-btn">
			</form>
			</div>
			<input type="button" id="close" value="X">
		</div>
	<main>
<!--******************************************************************************************************************************* *div for patient details
*search patient
*patient history
*patient vital results
*patient notes
*investigations and results
*injections
*********************************************************************************************************************-->
			
				<div id="search-container"><!-- form for searching patient -->
					<form id="search-form" name="doctor_search_form">
						<input type="text" id="search-field" placeholder="Please enter patient clinical ID" name="search_field">
					</form>
					<div id="search-results"><!-- div for resulta of search -->
						<p>search results will appear hear</p>
					</div>
				</div>
				<div id="patient-details"></div>
				<div id="control-div">
					<!--EMR, Request -Controls- -->
					<button id="emr-btn">EMR</button>
					<div>
					<form method="POST" action="../model/upload.php" enctype="multipart/form-data">
					<input type="hidden" name="chargesheet_pid" id="chargesheet-pid">
					<input type="file" name="image">
					<input type="date" name="upload_date">
					<input type="submit" value="Upload chargesheet" id="chargesheet-btn">
					</form>
					</div>
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
						<textarea name="doctors_notes" style="white-space: pre-wrap;" rows="5"></textarea>
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
				<div id="injections"><!--Injections SECTION-->
					<form id="injections-form" name="injections_form" class="ops-form">
						<input type="hidden" name="injections_pid">
						<label>Injections</label>
						<textarea name="injections" rows="5"></textarea>
						<input type="button" id="save-injections-btn" class="save_btn" value="Save">
					</form>
				</div>
				<!------------------------------------------------------------------------------------------------------------->
				<!------------------------------------------------------------------------------------------------------------->

				<div id="prescription"><!--PATIENT Prescription SECTION-->
					<form id="prescription-form" name="prescription_form" class="ops-form">
						<input type="hidden" name="presc_pid">
						<label>Prescription</label>
						<textarea name="prescription" style="white-space: pre-wrap;"rows="5"></textarea>
						<div id="prescription-control">
						<input type="button" id="save-presc-btn" class="save_btn" value="Save">
						<input type="button" id="print-prescription-btn" class="print_prescription" value="Print prescription">
						<div class="clear_float"></div>
						</div>
					</form>
				</div>
				<!--
				Notes:
				usage -
				stylye -> pre-wrap vs pre-line
				pre-line-> sequence of whitespace will collapse. Text will 
				wrap when necessary, and on line breaks
				-->
				<!------------------------------------------------------------------------------------------------------------>
				
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
		<script type="text/javascript" src="../../../assets/js/doctor/prescription.js"></script>
		<script type="text/javascript" src="../../../assets/js/doctor/main.js"></script>
		<script type="text/javascript" src="../../../assets/js/emr.js"></script>
		<script type="text/javascript" src="../../../assets/js/doctor/chargesheet.js"></script>
	</body>
</html>