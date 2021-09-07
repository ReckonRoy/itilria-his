<header>
	<nav id="main-nav"><div><a href="./appointments.php">Appointments</a> &nbsp; <a href="./consultation.php">Consultation</a></div>
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