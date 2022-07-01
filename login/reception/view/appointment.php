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
	<link rel="stylesheet" type="text/css" href="../../../assets/css/reception/appointment.css">
</head>
<body>
<?php
	require './header.php';
?>
<?php
	require './aside.php';
?>


<main>
	<!-- 
	*button tabs to switch betwwen different containers
	-->
	<div id="app-nav-bar">
		<button id="appointment-tab">Appointments</button><button id="schedule-tab">Schedule An Appointment</button>
	</div>

	<!-- 
	*this div act as a container for appointments
	-->
	<div id="appointments-div">
		<div id="id-filter">
			<input type="text" class="filter-field" placeholder="search by patient id" id="pid-searchfield">
			<input type="button" value="search" id="search-pid-btn">
		</div>
		<div id="date-filter">
			<input type="text" class="filter-field" placeholder="serch date">
			<input type="button" value="search">
		</div>
		<div id="app-list">
			<table>
				<tr>
					<th>Patient Name</th><th>Visit Time</th><th>Contact</th><th>Check In</th>
				</tr>

			</table>
		</div>
	</div>

	<!-- 
	*this div acts as a container for scheduling patients next visit
	-->
	<div id="schedule-div">
		<!-- This section is removed when an ID has been selected -->
		<div id="schedule-search-div">
			<input type="text" id="schedule-search-field" placeholder="Enter patient id to begin search...">
			<div id="schedule-box-results">
				<ol>
					<li>Dummy Id 1</li>
					<li>Dummy Id 2</li>
					<li>Dummy Id 3</li>
					<li>Dummy Id 4</li>
					<li>Dummy Id 5</li>
				</ol>

			</div>
		</div>
		<!-- Div lets user continue with booking a patient -->
		
		<div id="sch-date-control">
			<!-- Heading; Instruction and how to proceed -->
			<h2 id="schedule-bs-h2">Please choose the Year, Month and then click proceed to continue booking patient</h2>
			<div id="sch-bs-year">
				<ul>
					<li>january 2022</li>
					<li>febuary 2022</li>
					<li>march 2022</li>
					<li>april 2022</li>
				</ul>
			</div>
			<div>
				<input type="text" id="sch-month-field" placeholder="Select month">
			</div>
		</div>
		
		<div id="sch-schedule-parent">

			<div id="sch-schedule">
				<table>
					<tr><th>DAY</th><th>NUMBER OF BOOKINGS</th><th>SELECT TO BOOK</th></tr>
				</table>
			</div>

			<div id="sch-right-pane">
				<h2>STATS</h2>
				<div>
					<p>Patient Name: <label>Diana Wikilson</label></p>
					<sp>future visits:  None</sp>
				</div>
				<!-- Number of bookings left-->
				<div>
					Number of booking allocations left // No more bookings allocations left
				</div>
				<!-- Free time slots div -->
				<div>
					<table>
						<thead>Appointment Time Allocation</thead>
						<tr><th>Time</th><th>Assign</th></tr>
					</table>
				</div>
			</div>
		</div>
		<div id="purpose-section">
			<hr/>
			<h2>Please select one or more reasons for appointment</h2>
			<ul>
				<li>
					<label>See Doctor</label>
					<input type="checkbox" value="see doctor">
				</li>
				<li>
					<label>Papsmear</label>
					<input type="checkbox" value="Papsmear">
				</li>
			</ul>
		</div>

		<div id="sch-btn-div"><button id="sch-btn">Schedule an appointment</button></div>
	</div>
</main>

<?php
	//$prev_location = $_SERVER['HTTP_REFERER'];
	//$prev_location = substr($prev_location, stripos($prev_location, "doctor"), strlen("doctor"));
	//$prev_location;
	//$current_page = $_SERVER['SCRIPT_NAME'];
	$current_page = $_SERVER['SCRIPT_NAME'];
?>
<input type="hidden" id="curr_page" value="<?php substr($current_page, stripos($current_page, "reception")); ?>">


<script type="text/javascript" src="../../../assets/js/reception/main.js"></script>
<script type="text/javascript" src="../../../assets/js/reception/schedule.js"></script>	
</body>
</html>