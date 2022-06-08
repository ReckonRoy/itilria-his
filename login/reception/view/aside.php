<aside>
	<div id="co-nldiv">
		<?php
			$file_name = $_SERVER['SCRIPT_NAME'];
		if($file_name=='/cliniccare/login/commonviews/profile.php')
			{?>
			<img src="../../assets/img/favicon-128.png">	
			<?php
		}else{?>
			<img src="../../../assets/img/favicon-128.png">	
		<?php
		}
		?>
		<span id="company-name">ITilria</span>
	</div>
	<hr>
	<ul>
		<li><input type="button" value="Appointments" id="appointment-btn" class="aside-btn"></li>
		<li><input type="button" value="Add Patient" id="add-patient-btn" class="aside-btn"></li>
	</ul>
</aside>