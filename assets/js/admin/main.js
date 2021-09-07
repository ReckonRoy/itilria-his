let profileObject = {
profile_m_div: document.getElementById("profile-menu-div"),
avatar: document.getElementById("avatar-div"),
logout_btn: document.getElementById("logout-btn"),


	clickAction: function(){
		this.profile_m_div.style.display = "none";
		this.avatar.addEventListener("click", function(){
			
			if(profileObject.profile_m_div.style.display == "none")
			{
				profileObject.profile_m_div.style.display = "block";
			}else{
				profileObject.profile_m_div.style.display = "none";
			}
		});


		this.logout_btn.onclick = function()
		{
			window.location.href = "../logout.php";
		};
	}
}

let asideObject = {
	dashboard_tab: document.getElementById("db-btn"),
	staff_tab: document.getElementById("sm-btn"),

	clickAction: function(){
		this.dashboard_tab.addEventListener("click", function(){
			window.location.href = "./admin.php";
		});

		this.staff_tab.addEventListener("click", function(){
			window.location.href = "./staff.php";
		});
	} 
}

asideObject.clickAction(); 
profileObject.clickAction();