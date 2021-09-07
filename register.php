<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register - Create an account</title>
	<style>
		main aside nav article section footer{
			display: block;
		}

		html body{
			width: 100%;
		}
		/*-------------------------------------------------------------------------------------------------------------
		*Nav section
		-------------------------------------------------------------------------------------------------------------*/
		nav{
			border: 1px solid red;
			text-align: center;
			background-color: red;
			padding: 5px, 0;
			border-radius: 10px;
		}
		nav > a{
			color: white;
			text-shadow: lightblue;
		}

		/*-------------------------------------------------------------------------------------------------------------
		*Main Section
		-------------------------------------------------------------------------------------------------------------*/
		main{
			width: 100%;
		}

		#form-div{
			width: 50%;
			margin-left: 25%;
		}

		#form-header{
			font-weight: bold;
			font-size: 30px;
			text-align: center;			
		}

		.reg-form{
			border: 1px solid maroon;
			display: grid;
			padding-top: 15px;
			grid-template-columns: 30% 70%;
			grid-row-gap: 1em;
			border-radius: 10px;
		}

		.reg-form textarea{
			border-radius: 10px;
		}

		.field{
			padding: 8px;
			border: 1px solid black;
			border-radius: 10px;
		}
		#dep-sel{
			display: grid;
			grid-template-columns: 50% 50%;
		}
		#co-fieldset{
			margin-top: 20px;
		}

		#btn-div{
			margin-top:  30px;
			display:  grid;
			grid-template-columns: 1fr;
			grid-row-gap: 2em;
		}

		#btn-div button{
			border: 1px solid gray;
			border-radius: 10px;
			width: 80%;
			font-weight: bold;
			padding: 10px 0;
		}

		#reg-btn{
			background-color: blue;
			border: 1px solid blue;
			color: white;
			/*remove below code when ajax is enabled*/
			border: 1px solid gray;
			border-radius: 10px;
			width: 80%;
			font-weight: bold;
			padding: 10px 0;
		}
		#login-btn{
			border: 1px solid gray;
			border-radius: 10px;
			width: 80%;
			font-weight: bold;
			padding: 10px 0;
			background-color: grey;
			color: white;
		}

	</style>
</head>
<body>
	<div>
		<header>
			<nav>
				<a href="home.php">Home</a> | <a href="services.html">Services</a> | <a href="about-us.html">About us</a>
			</nav>
		</header>

		<!-- Main section of this webpage -->
		<main>
			<div id="form-div">
				<h2 id="form-header">Register - Create an account with us</h2>

				<form method="POST" action="./process/processRegistration/process_reg.php" name="reg_form">
					<fieldset class="reg-form">
						<legend>General information</legend>
						<label>Name</label>
						<input type="text" class="field" name="name">
						<label>Last name</label>
						<input type="text" class="field" name="surname">
						<label>Password</label>
						<input type="Password" class="field" name="password">
						<label>Account Type</label>
						<select name="account_type" class="field">
							<option value="admin">admin</option>
						</select>
						<label>Phone number</label>
						<input type="text" name="contact" class="field">
						<label>Email</label>
						<input type="email" name="email" class="field">
						<label>Nationality</label>
						<input type="text" name="nationality" class="field">
						<label>Address</label>
						<textarea cols="30" rows="3" name="address"></textarea>

						
					</fieldset>

					<fieldset class="reg-form" id="co-fieldset">
						<legend>Health Care Information</legend>
						<label>Company Name</label>
						<input type="text" name="co_name" class="field">
						<label>Medical Department</label>
						<div id="dep-sel">
							<label>Pharmacy</label>
							<input type="checkbox" name="med_dep[]" value="pharmacy">
							<label>Hospital</label>
							<input type="checkbox" name="med_dep[]" value="hospital">
							<label>Clinic</label>
							<input type="checkbox" name="med_dep[]" value="clinic">
							<label>Surgery</label>
							<input type="checkbox" name="med_dep[]" value="surgery">
							<label>Laboratory</label>
							<input type="checkbox" name="med_dep[]" value="laboratory">
							<label>Radiology</label>
							<input type="checkbox" name="med_dep[]" value="radiology">
						</div>
						<label>Phone number</label>
						<input type="text" name="co_contact_a" class="field">
						<label>Landline</sub></label>
						<input type="text" name="co_contact_b" class="field">
						<label>Email</label>
						<input type="email" name="co_email" class="field">
						<label>Country</label>
						<input type="text" name="country" class="field">
						<label>State/City</label>
						<input type="text" name="state" class="field">
						<label>Zip code</label>
						<input type="text" name="zip_code" class="field">
						<label>Address</label>
						<textarea cols="30" rows="3" name="co_address"></textarea>
					</fieldset>
					<div id="btn-div">
						<center>
							<input type="submit" id="reg-btn" value="Register"> 
						</center>
						<center>
							<input type="button" id="login-btn" value="Sign In">
						</center>
					</div>
				</form> 
			</div>
		</main>
	</div>
	<script type="text/javascript">
		let login_btn = document.getElementById("login-btn");
		login_btn.addEventListener("click", function(){
			window.location.href = "./login.php";
		});
	</script>
</body>
</html>