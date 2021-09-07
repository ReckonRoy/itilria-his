<?php
	if(isset($_POST['entry']))
	{
		if(!empty($_POST['entry'])){
			$_POST['entry'];

			function sanitizeData($value, $key)
			{
				strip_tags($value);
			}	

			array_walk($_POST['entry'], "sanitizeData");
		}
	}
?>

<html>
<head>
	<title>TEST Code</title>
</head>
<body>
	<form method="POST" action="testcode.php">
		<input type="text" name="entry[]">
		<input type="text" name="entry[]">
		<input type="text" name="entry[]">
		<input type="text" name="entry[]">
		<input type="submit" value="submit">
	</form>
</body>
</html>