let search = {
	xhr: null,
	url: null,
	search_form: document.getElementById("search-form"),
	search_field: document.getElementById("search-field"),
	search_field_d: document.getElementById("d-search-field"),
	resultBox: document.getElementById("search-results"),
	patientID_field: document.getElementById("patientID-field"),
	patient_details: document.getElementById("patient-details"),
	chargesheet_pid: document.getElementById('chargesheet-pid'),
	img_pid: document.getElementById('img-pid'),

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
				
				search.xhr.open("POST", search.url, true);
				search.xhr.onreadystatechange = search.response;
				search.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				search.xhr.send("patient_id=" + search.search_field.value);

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
					search.resultBox.innerHTML = "";
					let result = JSON.parse(search.xhr.responseText);
					if(result[0] == false)
					{
						console.log(result[0]);
					}else if(result[0] == true){					
						for(var i = 0; i < result[1].length; i++)
						{
							var patient_id = result[1][i].patient_id;
							var name = result[1][i].name;
							var surname = result[1][i].surname;
							search.content(search.resultBox, patient_id, name, surname);

						}
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

	content: function(container, p_id, name, surname){
		var ul = document.createElement(ul);
		ul.setAttribute("id", "rul-list");
		ul.style.listStyle = "none";

		var li = document.createElement("li");
		li.setAttribute("id", "rlist");
		
		li.appendChild(document.createTextNode(name +" "+surname + "  -  " + p_id));
		ul.appendChild(li);
		container.appendChild(ul);

		var p_name = document.createElement("p");
		

		li.addEventListener("click", function(){
			if(search.patient_details.style.display == "none"){
				search.patient_details.style.display = "block";
			}
			search.patient_details.innerHTML = "";
			search.patientID_field.value = p_id;
			p_name.innerText = "";
			p_name.appendChild(document.createTextNode("Patient Name: " + name + " " + surname));
			search.patient_details.appendChild(p_name);
			if(search.search_form.name == "doctor_search_form")
			{
				var notes_form = document.getElementById("notes-form");
				notes_form.notes_pid.value = p_id;

				var assesment_form= document.getElementById("assesment-form");
				assesment_form.asses_pid.value = p_id;

				var injections_form = document.getElementById("injections-form");
				injections_form.injections_pid.value = p_id;

				var procedures_form = document.getElementById("procedures-form");
				procedures_form.proc_pid.value = p_id;

				var prescription_form = document.getElementById("prescription-form");
				prescription_form.presc_pid.value = p_id;

				search.chargesheet_pid.value = p_id;

				search.img_pid.value = p_id;
			}
		});
		
	},
	
	runSearch: function(){
		search.patient_details.style.display = "none";

		search.createXHR();
		search.search_form.search_field.addEventListener("click", function(){
			if(search.search_form.name == "nurse_search_form")
			{
				search.url = "../control/VitalsController.php";
			}else if(search.search_form.name == "doctor_search_form")
			{
				search.url = "../control/DoctorController.php";
			}
			
		});

		search.search_form.search_field.addEventListener("keyup", function(){
			if(search.search_form.search_field.value.length <= 2)
			{
				search.resultBox.innerHTML = "";
				search.resultBox.innerText = "Search returns results at 3 characters in length";
			}else{
				search.request();
			}
		});
		/*********************************************************************************************************************/
	},
}

search.runSearch();