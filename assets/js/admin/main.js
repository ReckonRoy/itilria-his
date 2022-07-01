let profileObject = {
	profile_m_div: document.getElementById("profile-menu-div"),
	avatar: document.getElementById("avatar-div"),
	logout_btn: document.getElementById("logout-btn"),
	profile_btn: document.getElementById('profile-btn'),
	current_page: document.getElementById('curr_page'),

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
			if(profileObject.current_page.value == "profile.php")
			{
				window.location.href = "../logout.php";	
			}else{
				window.location.href = "../logout.php";
			}
		};

		profileObject.profile_btn.onclick = function()
		{
			if(profileObject.current_page.value == "profile.php")
			{
				window.location.href = "./profile.php";	
			}else{
				window.location.href = "../commonviews/profile.php";
			}	
		}
	}
}

let asideObject = {
	dashboard_tab: document.getElementById("db-btn"),
	staff_tab: document.getElementById("sm-btn"),
	current_page: document.getElementById('curr_page'),

	clickAction: function(){


		this.dashboard_tab.addEventListener("click", function(){
			//determine the page we are currently executing this script from and choose the appropriate action to take
			if(asideObject.current_page.value == "profile.php")
			{
				window.location.href = "../admin/admin.php";	
			}else{
				window.location.href = "./admin.php";
			}
		});

		this.staff_tab.addEventListener("click", function(){
			//determine the page we are currently executing this script from and choose the appropriate action to take
			if(asideObject.current_page.value == "profile.php")
			{
				window.location.href = "../admin/staff.php";	
			}else{
				window.location.href = "./staff.php";
			}
			
		});
	} 
}

asideObject.clickAction(); 
profileObject.profile_m();