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
	<link rel="stylesheet" type="text/css" href="../../../assets/css/reception/profilesettings.css">
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
	<h2 id="main-header">Profile Settings</h2>
	<div id="ps-div">

		<form id="user-form" name="userform">
			<h3 class="ps-form-header">
			General details about you
			<hr>
			</h3>
			<input type="hidden" name="staff_id" id="staff-id" value="<?php echo $_SESSION['user_id']; ?>">
			<label>Name</label>
			<input type="text" name="fname" id="fname" class="fields">
			<label>Surname</label>
			<input type="text" name="lname" id="lname" class="fields">
			<label>Email</label>
			<input type="email" name="email_addr" id="email_addr" class="fields" >
			<label>Contact</label>
			<input type="text" name="contact" id="contact" class="fields">
			<label>Profession</label>
			<input type="text" name="profession" id="profession" class="fields">
			<label>Nationality</label>
			<input type="text" name="nationality" id="nationality" class="fields">
			<label>Address</label>
			<textarea id="address-field" name="address" class="textarea" cols="5" rows="3"></textarea>			
			<input type="button" value="update" class="button-class" id="update-btn">
		</form>

		<form id="username-form">
			<h3 class="ps-form-header">
				create a user name for your account or change your old one
			<hr>
			</h3>
			<label>Username</label>
			<input type="text" name="username" class="fields"> 
			<input type="button" value="save" class="button-class" id="username-btn">
		</form>

		<form id="password-form" name="passwordform">
			<h3 class="ps-form-header">Secure your password<hr></h3>
			<input type="hidden" name="staff_pwd_id" value="<?php echo $_SESSION['user_id']; ?>">
			<label>Enter old password</label>
			<input type="password" name="current_pwd" class="fields">
			<label>New password</label>
			<input type="password" name="new_pwd" class="fields">
			<label>Confirm password</label>
			<input type="password" name="confirm_pwd" class="fields">
			<input type="button" value="Change password" class="button-class" id="cpwd-btn">
		</form>
	</div>
</main>
<script type="text/javascript" src="../../../assets/js/reception/main.js"></script>
<script type="text/javascript" src="../../../assets/js/common/profilesettings.js"></script>
</body>
</html>