let loginObject = {
	xhr: null,
	url: null,
	login_btn: document.getElementById("login-btn"),
	login_form: document.getElementById("login-form"),
	search_btn: document.getElementById("search_btn"),
	close_btn: document.getElementById("close-btn"),
	p_tag: document.getElementById("message"),
	errorm_div: document.getElementById("server-error-response"),
	createXHR: function()
	{
		loginObject.xhr = null;
		try{
			loginObject.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				loginObject.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(loginObject.xhr)
		{
			try{
				loginObject.url = "./process/processLogin/process_login.php";
				loginObject.xhr.open("POST", loginObject.url, true);
				loginObject.xhr.onreadystatechange = loginObject.response;
				loginObject.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				var email_field = loginObject.login_form.email;
				var password_field = loginObject.login_form.password;
				loginObject.xhr.send(email_field.name+"="+email_field.value+"&"+password_field.name+"="+password_field.value);
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
		if(loginObject.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(loginObject.xhr.status == 200){
				try{
					let result = JSON.parse(loginObject.xhr.responseText);
					if(result[0] == false)
					{
						loginObject.container(loginObject.p_tag, result[1]);
					}else if(result[0] == true)
					{
						window.location.href = result[1];
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(loginObject.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	container: function(p_tag, message){
		var overlay = document.getElementById("overlay");
		p_tag.innerHTML = "";
		overlay.style.display = "block";
		loginObject.errorm_div.style.display = "none";
		if (loginObject.errorm_div.style.display == "none"){

			loginObject.errorm_div.style.display = "block";
		}
		
		p_tag.appendChild(document.createTextNode(message));
		loginObject.close_btn.addEventListener("click", function(){
			overlay.style.display = "none";
			loginObject.errorm_div.style.display = "none";
		});
	},
		
	login: function(){
		this.createXHR();
		this.login_btn.addEventListener("click", function(){
			loginObject.request();
		});
	},
}

loginObject.login();