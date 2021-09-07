let tabs = {
	register_tab : document.getElementById("register-tab"),
	update_tab : document.getElementById("update-tab"),
	delete_tab : document.getElementById("delete-tab"),
	assign_tab : document.getElementById("assign-tab"),
	reg_container: document.getElementById("reg-content-div"),
	update_container: document.getElementById("update-content-div"),
	delete_container: document.getElementById("delete-content-div"),
	xhr: null,
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
		update.xhr = null;
		try{
			update.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				update.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(update.xhr)
		{
			try{
				update.url = "";
				update.xhr.open("POST", update.url, true);
				update.xhr.onreadystatechange = update.response;
				update.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				var register_form = document.getElementById("");
				var n = ;
				var s;
				var e;
				var con;
				var prof;
				var acc_type;
				var pr_n;
				var nat;
				var s_d;
				var addr;

				update.xhr.send("email=" + update.form.email.value);

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
		if(update.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(update.xhr.status == 200){
				try{
					let result = JSON.parse(update.xhr.responseText);
					if(result[0] == false)
					{

					}else if(result[0] == true){					

					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(update.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},
	
}

let searchEmail_field = document.getElementById("search-email");
searchEmail_field.addEventListener("focus", function(){
	this.style.border = "2px solid blue";
});

tabs.manageTabs();