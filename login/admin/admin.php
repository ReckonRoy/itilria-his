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
	<body>

		<div id="container">
		<?php	
			require "./header.php";
		?>
		<main>
			<h1>content coming soon</h1>
		</main>
		<?php	
			require "./aside.php";
		?>
		<footer></footer>
	</div>
		<?php
			require "./footer.php";
		?>