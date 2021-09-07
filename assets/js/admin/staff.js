let tabs = {
	register_tab : document.getElementById("register-tab"),
	update_tab : document.getElementById("update-tab"),
	delete_tab : document.getElementById("delete-tab"),
	assign_tab : document.getElementById("assign-tab"),
	reg_container: document.getElementById("reg-content-div"),
	update_container: document.getElementById("update-content-div"),
	delete_container: document.getElementById("delete-content-div"),
	reg_div: document.getElementById("reg-content-div"),
	close_btn: document.getElementById("close-btn"),
	p_tag: document.getElementById("message"),
	smp_div: document.getElementById("server-message-response"),
	register_form: document.getElementById("reg-form"),
	xhr: null,
	register_btn: document.getElementById("reg-btn"),
	url: null,

	manageTabs: function()
	{
		/*-----------------------------------------------------------------------------------------------------------------
		*Register tab
		-----------------------------------------------------------------------------------------------------------------*/
		this.register_tab.addEventListener("click", function()
		{
			tabs.reg_container.style.display = "block";

			if(tabs.reg_container.style.display == "none")
			{
				tabs.reg_container.style.display = "block";
			}else{
				tabs.update_container.style.display = "none";
				tabs.delete_container.style.display = "none";
			}
		});
		 /*-----------------------------------------------------------------------------------------------------------------
		*Update tab
		-----------------------------------------------------------------------------------------------------------------*/
		this.update_tab.addEventListener("click", function()
		{
			tabs.update_container.style.display = "block";
			if(tabs.update_container.style.display == "none")
			{
				tabs.update_container.style.display = "block";
			}
				tabs.reg_container.style.display = "none";
				tabs.delete_container.style.display = "none";
			
		});

		/*-----------------------------------------------------------------------------------------------------------------
		* Delete tab
		-----------------------------------------------------------------------------------------------------------------*/
		this.delete_tab.addEventListener("click", function()
		{
			tabs.delete_container.style.display = "block";
			if(tabs.delete_container.style.display == "none")
			{
				tabs.delete_container.style.display = "block";
			}
				tabs.reg_container.style.display = "none";
				tabs.update_container.style.display = "none";
			
		});
	},

	/******************************************************************************************************************
	*ajax - staff management
	******************************************************************************************************************/

	createXHR: function()
	{
		tabs.xhr = null;
		try{
			tabs.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				tabs.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(tabs.xhr)
		{
			try{
				
				tabs.xhr.open("POST", tabs.url, true);
				tabs.xhr.onreadystatechange = tabs.response;
				tabs.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				if(tabs.register_form.name == "register_form"){
					var n = tabs.register_form.name_field;
					var s = tabs.register_form.surname;
					var e = tabs.register_form.email;
					var con = tabs.register_form.contact;
					var prof = tabs.register_form.profession;
					var acc_type = tabs.register_form.account_type;
					var pr_n = tabs.register_form.practice_number;
					var nat = tabs.register_form.nationality;
					var s_d = tabs.register_form.start_date;
					var addr = tabs.register_form.address;
					tabs.xhr.send(
						n.name+"="+n.value
						+"&"+s.name+"="+s.value
						+"&"+e.name+"="+e.value
						+"&"+con.name+"="+con.value
						+"&"+prof.name+"="+prof.value
						+"&"+acc_type.name+"="+acc_type.value
						+"&"+pr_n.name+"="+pr_n.value
						+"&"+nat.name+"="+nat.value
						+"&"+s_d.name+"="+s_d.value
						+"&"+addr.name+"="+addr.value
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
		if(tabs.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(tabs.xhr.status == 200){
				try{
					let result = JSON.parse(tabs.xhr.responseText);
					if(result[0] == false)
					{
						tabs.container(tabs.p_tag, result[1], result[2]);
					}else if(result[0] == true){					
						tabs.container(tabs.p_tag, result[1], result[2]);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(tabs.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	run: function(){
		this.createXHR();
		tabs.register_btn.addEventListener("click", function(){
			//re-assign url
			tabs.url = "../user/process_reg.php";
			//initialise register form and set all other forms to empty
			if(tabs.register_form.name == "register_form"){
				tabs.request();
			}
		});
	},

	container: function(p_tag, message, class_state){
		var overlay = document.getElementById("overlay");
		p_tag.innerHTML = "";
		
		tabs.smp_div.className = class_state;
		tabs.smp_div.style.display = "none";
		overlay.style.display = "none";
		if (tabs.smp_div.style.display == "none"){
			overlay.style.display = "block";
			tabs.smp_div.style.display = "block";
		}
		//position pop-up in appropriate place in relation to the meeting divs 
        var calcDiv1_geom = tabs.reg_div.clientHeight / 2;
        var calcDiv2_geom = tabs.smp_div.clientHeight / 2;
      	var process_geom = ((tabs.reg_div.offsetTop + tabs.reg_div.clientHeight) - (calcDiv1_geom + calcDiv2_geom) - 300);
        tabs.smp_div.style.top = process_geom + "px";
		window.scrollTo(0, tabs.reg_div.offsetTop);
		
		p_tag.appendChild(document.createTextNode(message));
		tabs.close_btn.addEventListener("click", function(){
			overlay.style.display = "none";
			tabs.smp_div.style.display = "none";
		});
	},
	
}

let searchEmail_field = document.getElementById("search-email");
searchEmail_field.addEventListener("focus", function(){
	this.style.border = "2px solid blue";
});

tabs.manageTabs();
tabs.run();