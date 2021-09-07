let search = {
	xhr: null,
	url: null,
	
	form: document.getElementById("u-search-f"),
	delete_form: document.getElementById("delete-form"),
	search_btn: document.getElementById("search_btn"),
	update_form: document.getElementById("update-form"),
	delete_searchBox: document.getElementById("delete-searchBox"),
	searchBox: document.getElementById("s-r-b"),
	delete_s_form: document.getElementById("delete-s-form"),
	delete_search_btn: document.getElementById("d-s-btn"),
	
	createXHR: function()
	{
		search.xhr = null;
		try{
			search.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				search.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(search.xhr)
		{
			try{
				search.url = "../user/SearchEmployee.php";
				search.xhr.open("POST", search.url, true);
				search.xhr.onreadystatechange = search.response;
				search.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				search.xhr.send("email=" + search.form.email.value);

				document.body.style.cursor = "wait";
			}catch(e){
				alert("Can't connect to server: " + e.toString());
				document.body.style.cursor = "default";
			}
		}
	},
	requestDS: function()
	{
		if(search.xhr)
		{
			try{
				search.url = "../user/SearchEmployee.php";
				search.xhr.open("POST", search.url, true);
				search.xhr.onreadystatechange = search.responseDS;
				search.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				search.xhr.send("email=" + search.delete_form.email.value);

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
		if(search.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(search.xhr.status == 200){
				try{
					let result = JSON.parse(search.xhr.responseText);
					if(result[0] == false)
					{
						search.searchBox.innerHTML = result[1];

					}else if(result[0] == true){

						search.searchBox.innerHTML = "";

						var user = result[1][search.form.email.value];
						search.getResults(search.searchBox, user.user_id, user.email, user.name, user.surname, user.nationality, user.contact, user.address, user.profession);


					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(search.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	responseDS: function()
	{
		//check if request is complete
		if(search.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(search.xhr.status == 200){
				try{
					let result = JSON.parse(search.xhr.responseText);
					if(result[0] == false)
					{

						search.delete_searchBox.innerHTML = result[1];

					}else if(result[0] == true){

						search.delete_searchBox.innerHTML = "";

						var user = result[1][search.delete_form.email.value];
						search.getSDResults(search.delete_searchBox, user.user_id, user.email, user.name, user.surname);

					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(search.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},
	search_func: function(){
		search.search_btn.addEventListener("click", function(){
			search.createXHR();
			search.request();
		});

		search.delete_search_btn.addEventListener("click", function(){
			search.createXHR();
			search.requestDS();
		});
	},


	getResults: function(container, user_id, email, name, surname, nationality, contact, address, profession)
	{
		var ul = document.createElement(ul);
		ul.setAttribute("id", "rul-list");

		var li = document.createElement("li");
		li.setAttribute("id", "rlist");
		
		li.appendChild(document.createTextNode(name +" "+surname+" - "+email));
		ul.appendChild(li);
		container.appendChild(ul);

		li.addEventListener("click", function(){
			search.update_form.id_field.value = user_id;
			search.update_form.name.value = name;
			search.update_form.surname.value = surname;
			search.update_form.profession.value = profession;
			search.update_form.nationality.value = nationality;
			search.update_form.contact.value = contact;
			search.update_form.address.value = address;
		});
	},

	getSDResults: function(container, user_id, email, name, surname)
	{
		var ul = document.createElement(ul);
		ul.setAttribute("id", "rul-list");

		var li = document.createElement("li");
		li.setAttribute("id", "rlist");
		
		li.appendChild(document.createTextNode(name +" "+surname+" - "+email));
		ul.appendChild(li);
		container.appendChild(ul);
		var fn = document.getElementById("d-fn");
		li.addEventListener("click", function(){
			search.delete_s_form.id_field.value = user_id;
			fn.textContent = name + " " + surname;
			
		});
	}
}
/**********************************************************************************************************************************/

/**********************************************************************************************************************************/
let update = {
	xhr: null,
	url: null,
	search_btn: document.getElementById("search_btn"),
	update_form: document.getElementById("update-form"),

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
search.search_func();