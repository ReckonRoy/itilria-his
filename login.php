<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	<div id="overlay"></div>
	<div id="container">

		<main>

			<div id="server-error-response">
				<input type="button" id="close-btn" value="close">
				<div class="clear_float"></div>
				<p id="message">
				</p>
			</div>

			<div id="form-div">
				<h2>Log In</h2>
				<form name="login_form" id="login-form">
					<label>Email</label>
					<input type="email" name="email">
					<label>Password</label>
					<input type="password" name="password">
					<input class="form-buttons" id="login-btn" type="button" value="Sign In">
					<input class="form-buttons" id="register-btn" type="button" value="Register">
				</form>
			</div>
		</main>
	</div>
	<script type="text/javascript" src="./assets/js/login.js"></script>
	<script type="text/javascript">
		let register_btn = document.getElementById("register-btn");
		register_btn.addEventListener("click", function(){
			window.location.href = "./register.php";
		});
	</script>
</body>
</html> 