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
		<?php
		if($file_name=='/cliniccare/login/commonviews/profile.php')
		{?>
			<input type="hidden" id="page-state" value="<?php echo $file_name; ?>">
			<li><input type="button" value="Appointments" id="appointment-btn-profile-view" class="aside-btn"></li>
			<li><input type="button" value="Consultation" id ="consultation-btn-profile-view" class="aside-btn"></li>	
		<?php
		}else{
		?>	
			<input type="hidden" id="page-state" value="<?php echo $file_name; ?>">
			<li><input type="button" value="Appointments" id="appointment-btn" class="aside-btn"></li>
			<li><input type="button" value="Consultation" id ="consultation-btn" class="aside-btn"></li>	
		<?php
			}
		?>
		
	</ul>
</aside>