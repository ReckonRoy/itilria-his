let profileObject = {
	profile_m_div: document.getElementById("profile-menu-div"),
	avatar: document.getElementById("avatar-div"),
	logout_btn: document.getElementById("logout-btn"),
	profile_btn: document.getElementById('profile-btn'),
	page_state: document.getElementById('page-state'),
	
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
			window.location.href = "../../logout.php";
		};

		profileObject.profile_btn.onclick = function()
		{
			window.location.href = "../../commonviews/profile.php";
		};
	}
}


let asideObject = {
	appointment_tab: null,
	consultation_tab: null,
	common_aside_consultation: null,
	current_page: document.getElementById('curr_page'),
	clickAction: function(){
			
		if(asideObject.current_page.value == "profile.php")
		{
			asideObject.common_aside_appointment = document.getElementById('consultation-btn-profile-view');			
			asideObject.common_aside_appointment.addEventListener("click", function(){
			window.location.href = "../doctor/view/consultation.php";
			});
		}else{
			asideObject.appointment_tab = document.getElementById("appointment-btn");
			asideObject.appointment_tab.addEventListener("click", function(){
			window.location.href = "./appointment.php";
			});
		
			asideObject.consultation_tab = document.getElementById("consultation-btn");
			asideObject.consultation_tab.addEventListener("click", function(){
			window.location.href = "./consultation.php";
			});
		}
	} 
}

asideObject.clickAction(); 
profileObject.profile_m();