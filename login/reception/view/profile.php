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

		<form id="user-form">
			<h3 class="ps-form-header">General details about you</h3>
			<label>Name</label>
			<input type="text" name="fname" class="field">
			<label>Surname</label>
			<input type="text" name="lname" class="field">
			<label>Email</label>
			<input type="email" name="email_addr" class="field">
			<label>Contact</label>
			<input type="text" name="contact" class="field">
			<label>Profession</label>
			<input type="text" name="profession" class="field">
			<label>Address</label>
			<textarea cols="5" rows="3"></textarea>			
			<input type="button" value="update">
		</form>

		<form id="username-form">
			<h3 class="ps-form-header">create a user name for your account or change your old one</h3>
			<label>Username</label>
			<input type="text" name="username">
			<input type="button" name="" value="submit">
		</form>

		<form id="password-form">
			<h3 class="ps-form-header">Secure your password</h3>
			<label>Enter old password</label>
			<input type="password" name="old_pwd">
			<label>New password</label>
			<input type="password" name="new_pwd">
			<label>Confirm password</label>
			<input type="password" name="confirm_pwd">
			<input type="button" name="" value="Change password">
		</form>
	</div>
</main>
<script type="text/javascript" src="../../../assets/js/reception/main.js"></script>
</body>
</html>