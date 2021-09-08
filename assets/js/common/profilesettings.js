let profileSettingsObject = {
	xhr: null,
	url: null,
	userform: document.getElementById('user-form'),
	passwordform: document.getElementById('password-form'),
	update_btn: document.getElementById('update-btn'),
	change_pwd_btn: document.getElementById('cpwd-btn'),
	close_btn: document.getElementById("close-btn"),
	p_tag: document.getElementById("message"),
	smp_div: document.getElementById("server-message-response"),

	createXHR: function()
	{
		profileSettingsObject.xhr = null;
		try{
			profileSettingsObject.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				profileSettingsObject.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(profileSettingsObject.xhr)
		{
			try{
				profileSettingsObject.url = "../../user/control/UserController.php";
				profileSettingsObject.xhr.open("POST", profileSettingsObject.url, true);
				profileSettingsObject.xhr.onreadystatechange = profileSettingsObject.response;
				profileSettingsObject.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				if(this.userform.name == "userform")
				{
					profileSettingsObject.xhr.send("employee_id=" + this.userform.staff_id.value);					
				}else if(this.passwordform.name == "passwordform"){
					var user_id = profileSettingsObject.passwordform.staff_pwd_id;
					var curr_pwd = profileSettingsObject.passwordform.current_pwd;
					var new_pwd = profileSettingsObject.passwordform.new_pwd;
					var confirm_pwd = profileSettingsObject.passwordform.confirm_pwd;

					profileSettingsObject.xhr.send(
						user_id.name+"="+user_id.value
						+"&"+curr_pwd.name+"="+curr_pwd.value
						+"&"+new_pwd.name+"="+new_pwd.value
						+"&"+confirm_pwd.name+"="+confirm_pwd.value
						);	
				}
				

				document.body.style.cursor = "wait";
			}catch(e){
				alert("Can't connect to server: " + e.toString());
				document.body.style.cursor = "default";
			}
		}
	},

	response: function()
	{
		//check if request is complete
		if(profileSettingsObject.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(profileSettingsObject.xhr.status == 200){
				try{
					let result = JSON.parse(profileSettingsObject.xhr.responseText);
					if(result[0] == false)
					{
						if(result[2] == "passwordform")
						{
							profileSettingsObject.container(profileSettingsObject.p_tag, result[1], result[3]);
						}
					}else if(result[0] == true){	
						if(result[2] == "userform")
						{
							profileSettingsObject.userform.fname.value = result[1].name;
							profileSettingsObject.userform.lname.value = result[1].surname;
							profileSettingsObject.userform.contact.value = result[1].contact;
							profileSettingsObject.userform.email_addr.value = result[1].email;
							profileSettingsObject.userform.profession.value = result[1].profession;
							profileSettingsObject.userform.address.value = result[1].address;
						}else if(result[2] == "passwordform")
						{
							profileSettingsObject.container(profileSettingsObject.p_tag, result[1], result[3]);
						}				
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(profileSettingsObject.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	container: function(p_tag, message, class_state){
		var overlay = document.getElementById("overlay");
		p_tag.innerHTML = "";
		
		profileSettingsObject.smp_div.className = class_state;
		profileSettingsObject.smp_div.style.display = "none";
		overlay.style.display = "none";
		if (profileSettingsObject.smp_div.style.display == "none"){
			overlay.style.display = "block";
			profileSettingsObject.smp_div.style.display = "block";
		}
		p_tag.appendChild(document.createTextNode(message));
		profileSettingsObject.close_btn.addEventListener("click", function(){
			overlay.style.display = "none";
			profileSettingsObject.smp_div.style.display = "none";
		});
	},

	getUserData: function()
	{
		profileSettingsObject.createXHR();
		profileSettingsObject.passwordform.name = "";
		profileSettingsObject.request();
		
		this.update_btn.addEventListener("click", function(){
			
			profileSettingsObject.passwordform.name = "updateform";
			if(profileSettingsObject.passwordform.name == "updateform")
			{
				profileSettingsObject.passwordform.name = "";
			}
		});
		this.change_pwd_btn.addEventListener("click", function(){
			
			profileSettingsObject.passwordform.name = "passwordform";
			if(profileSettingsObject.passwordform.name == "passwordform")
			{
				profileSettingsObject.userform.name = "";
				profileSettingsObject.request();
			}
		});
		
	}
	
}

profileSettingsObject.getUserData();