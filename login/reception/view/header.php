<header>
	<nav id="main-nav"><div><a href="./reception.php">Add Patient</a> | <a href="appointment.php">Appointment</a></div>
		<div id="avatar-pdiv">
			<div id="avatar-div">
				<?php echo $user->getInitials() ;?>
			</div>	
			<div id="profile-menu-div">
				<ul>
					<li>Profile</li>
					<li>Settings</li>
					<li id="logout-btn">Log out</li>
				</ul>	
			</div>
		</div>
	</nav>
</header>