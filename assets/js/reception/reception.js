let addPatientObject = {
	xhr: null,
	url: null,
	addPatient_btn: document.getElementById("reg_btn"),
	patient_form: document.getElementById("add-patient-form"),
	//notification_div: document.getElementById("notification-div"),

	close_btn: document.getElementById("close-btn"),
	register_div: document.getElementById("form_div"),
	p_tag: document.getElementById("message"),
	smp_div: document.getElementById("server-message-response"),
	createXHR: function()
	{
		addPatientObject.xhr = null;
		try{
			addPatientObject.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				addPatientObject.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(addPatientObject.xhr)
		{
			try{
				addPatientObject.url = "../processes/register_patient.php";
				addPatientObject.xhr.open("POST", addPatientObject.url, true);
				addPatientObject.xhr.onreadystatechange = addPatientObject.response;
				addPatientObject.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
				var p_name = addPatientObject.patient_form.patient_name;
				var surname = addPatientObject.patient_form.surname;
				var gender = addPatientObject.patient_form.gender;
				var dob = addPatientObject.patient_form.dob;
				var contact = addPatientObject.patient_form.contact;
				var nationality = addPatientObject.patient_form.nationality;
				var citizen_id = addPatientObject.patient_form.citizen_id;
				var occupation = addPatientObject.patient_form.occupation;
				var address = addPatientObject.patient_form.address;
				var pec = addPatientObject.patient_form.pec;

				var allergies = addPatientObject.patient_form.allergies;
				var nok_name = addPatientObject.patient_form.nok_name;
				var nok_lname = addPatientObject.patient_form.nok_lname;
				var nok_contact = addPatientObject.patient_form.nok_contact;
				var nok_id = addPatientObject.patient_form.nok_id;
				var nok_rel = addPatientObject.patient_form.nok_rel;
				var nok_address = addPatientObject.patient_form.nok_address;
				addPatientObject.xhr.send(
					+"&"+p_name.name+"="+p_name.value
					+"&"+surname.name+"="+surname.value
					+"&"+gender.name+"="+gender.value
					+"&"+dob.name+"="+dob.value
					+"&"+contact.name+"="+contact.value
					+"&"+nationality.name+"="+nationality.value
					+"&"+citizen_id.name+"="+citizen_id.value
					+"&"+occupation.name+"="+occupation.value
					+"&"+address.name+"="+address.value
					+"&"+pec.name+"="+pec.value
					+"&"+allergies.name+"="+allergies.value
					+"&"+nok_name.name+"="+nok_name.value
					+"&"+nok_lname.name+"="+nok_lname.value
					+"&"+nok_contact.name+"="+nok_contact.value
					+"&"+nok_id.name+"="+nok_id.value
					+"&"+nok_rel.name+"="+nok_rel.value
					+"&"+nok_address.name+"="+nok_address.value
					);

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
		if(addPatientObject.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(addPatientObject.xhr.status == 200){
				try{
					let result = JSON.parse(addPatientObject.xhr.responseText);
					if(result[0] == false)
					{
						addPatientObject.container(addPatientObject.p_tag, result[1], result[2]);
					}else if(result[0] == true){					
						addPatientObject.container(addPatientObject.p_tag, result[1], result[2]);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(addPatientObject.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	runAddPatient: function(){
		//addPatientObject.notification_div.style.display = "none";
		addPatientObject.createXHR();
		addPatientObject.addPatient_btn.addEventListener("click", function(){
			addPatientObject.request();
		});
	},

	container: function(p_tag, message, class_state){
		var overlay = document.getElementById("overlay");
		p_tag.innerHTML = "";
		
		addPatientObject.smp_div.className = class_state;
		addPatientObject.smp_div.style.display = "none";
		overlay.style.display = "none";
		if (addPatientObject.smp_div.style.display == "none"){
			overlay.style.display = "block";
			addPatientObject.smp_div.style.display = "block";
		}
		//position pop-up in appropriate place in relation to the meeting divs 
        var calcDiv1_geom = addPatientObject.register_div.clientHeight / 2;
        var calcDiv2_geom = addPatientObject.smp_div.clientHeight / 2;
      	var process_geom = ((addPatientObject.register_div.offsetTop + addPatientObject.register_div.clientHeight) - (calcDiv1_geom + calcDiv2_geom) - 500);
        addPatientObject.smp_div.style.top = process_geom + "px";
		window.scrollTo(0, addPatientObject.register_div.offsetTop);
		
		p_tag.appendChild(document.createTextNode(message));
		addPatientObject.close_btn.addEventListener("click", function(){
			overlay.style.display = "none";
			addPatientObject.smp_div.style.display = "none";
		});
	},
	
}


let nokObject = {
	nok_dropdown: document.getElementById("nok-dropdown"),
	nok_rel: document.getElementById("nok-rel"),
	list: document.getElementById("rel-ol"),

	nok_m: function()
	{
		nokObject.nok_rel.addEventListener("click", function(){
			if(nokObject.nok_dropdown.style.display == ""){
				nokObject.nok_dropdown.style.display = "block";
				for(var i = 0; i < nokObject.list.childElementCount; i++){
					nokObject.list.children[i].addEventListener("click", function(){
						nokObject.nok_rel.value = this.innerText;
						nokObject.nok_dropdown.style.display = "";
					});
				}
			}else{
				nokObject.nok_dropdown.style.display = "";
			}
		});
	},
}

nokObject.nok_m();
addPatientObject.runAddPatient();