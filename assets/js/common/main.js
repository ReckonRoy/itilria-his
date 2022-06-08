let profileObject = {
	profile_m_div: document.getElementById("profile-menu-div"),
	avatar: document.getElementById("avatar-div"),
	logout_btn: document.getElementById("logout-btn"),
	profile_btn: document.getElementById('profile-btn'),
	
	
	profile_m: function()
	{
		profileObject.profile_m_div.style.display = "none";
		profileObject.avatar.addEventListener("click", function(){
			if(profileObject.profile_m_div.style.display == "none")
			{
				profileObject.profile_m_div.style.display = "block";
			}else{
				profileObject.profile_m_div.style.display = "none";
			}
		});
		
		profileObject.logout_btn.onclick = function()
		{
			window.location.href = "../logout.php";
		};

		profileObject.profile_btn.onclick = function()
		{
			window.location.href = "./profile.php";
		};		
	}
}

let asideObject = {
	appointment_tab: document.getElementById("appointment-btn"),
	addPatient_tab: document.getElementById("add-patient-btn"),

	clickAction: function(){
		asideObject.appointment_tab.addEventListener("click", function(){
			window.location.href = "./appointment.php";
		});

		asideObject.addPatient_tab.addEventListener("click", function(){
			window.location.href = "./reception.php";
		});
	} 
}

asideObject.clickAction(); 
profileObject.profile_m();