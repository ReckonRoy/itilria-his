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
	<head>
		<link rel="stylesheet" type="text/css" href="../../assets/css/admin/staff.css">
	</head>
	
	<body>

		<div id="container">
		<?php	
			require "./header.php";
		?>	
		<main>
			<nav id="staff-nav">
				<button id="register-tab">Register</button> | <button id="update-tab">Update</button> | <button id="delete-tab">Delete</button> | <button id="assign-tab">Assign post</button>
			</nav>
			<div id="parent-div">
				<!---------------------------------------------------------------------------------------------------------- 
				Staff Registrion Containaer
				----------------------------------------------------------------------------------------------------------->
				<div id="reg-content-div">

					<h2>Register new staff member</h2>
					<form id="reg-form" action="../user/process_reg.php">
						<label>Name</label>
						<input type="text" class="field" name="name">
						<label>Last Name</label>
						<input type="text" name="surname" class="field">
						<label>Email</label>
						<input type="email" name="email" class="field">
						<label>Contact</label>
						<input type="text" name="contact" class="field">
						<label>Profession</label>						
						<input type="text" name="profession" class="field">
						<label>Account Type</label>
						<select name="account_type" id="a-t-s" class="field" >
							<option value="admin">Admin</option>
							<option value="doctor" selected>Doctor</option>
							<option value="nurse">Nurse</option>
							<option value="receptionist">Receptionist</option>
						</select>
						<label>Practice Number</label>						
						<input type="text" name="practice_number" class="field">
						<label>Nationality</label>
						<input type="text" name="nationality" class="field">
						<label>Start Date</label>
						<input type="date" name="start_date" class="field">
						<label>Address</label>
						<textarea name="address" rows="3" cols="40"></textarea>
						<input type="submit" value="Register" id="reg-btn">
					</form>
				</div>
				<!---------------------END staff registration container------------------------------------>

				<!-----------------------------------------------------------------------------------------
				Update staff information container
				------------------------------------------------------------------------------------------>
				<div id="update-content-div">

					<form class="staff-search" id="u-search-f" name="u-search-f">
						<input type="email" name="email" placeholder="Search employee by email address" id="search-email">
						<input type="button" value="search" id="search_btn">
						<div class="s-u-r-d" id="s-r-b">
							<div><p>search results will appear hear</p></div>
						</div>
					</form>
					<form id="update-form" name="update-form" method="post" action="../ProcessUpdate.php">
						<input type="hidden" name="id_field">
						<label>Name</label>
						<input type="text" name="name" class="field">
						<label>Last Name</label>
						<input type="text" name="surname" class="field">
						<label>Nationality</label>
						<input type="text" name="nationality" class="field">
						<label>Contact</label>
						<input type="text" name="contact" class="field">
						<label>Profession</label>
						<input type="text" name="profession" class="field">
						<label>Practice Number</label>
						<input type="text" name="practice_number" class="field">
						<label>Address</label>
						<textarea name="address" rows="3" cols="40"></textarea>
						<input type="submit" value="Update" id="update-btn">
					</form>
				</div>
				<!---------------------END staff registration container------------------------------------>

				<!-----------------------------------------------------------------------------------------
				Delete staff member
				------------------------------------------------------------------------------------------>
				<div id="delete-content-div">
					<form class="staff-search" name="delete-form" id="delete-form">
						<input type="email" name="email" placeholder="Search employee by email address" class="search-email">
						<input type="button"  id="d-s-btn" value="search">
						<div class="s-u-r-d" id="delete-searchBox">
							<p>search results will appear hear</p>
						</div>
					</form>
					

					<div id="del-div">
						<p>
							Delete this employee from your system
						</p>
						<p>Employee: <span id="d-fn">full name<span></p>
						<form method="post"  id="delete-s-form" action="../deleteProcess.php">
						<input type="hidden" name="id_field">
						<button>Yes, delete employee</button>
						</form>
						
					</div>
				</div>
				<!---------------------END delete staff container------------------------------------>
			</div>
		</main>
		<?php	
			require "./aside.php";
		?>
		<footer></footer>
		</div>	
<script type="text/javascript" src="../../assets/js/admin/searchUser.js"></script>
<script type="text/javascript" src="../../assets/js/admin/staff.js"></script>
<?php
	require "./footer.php";
?>
		