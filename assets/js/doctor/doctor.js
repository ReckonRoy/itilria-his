let patient = {
	xhr: null,
	url: null,
	save_presc_btn: document.getElementById("save-presc-btn"),
	save_proc_btn: document.getElementById("save-proc-btn"),
	save_injections_btn: document.getElementById("save-injections-btn"),
	savenotes_btn: document.getElementById("savenotes-btn"),
	save_ass_btn: document.getElementById("saveassesment-btn"),
	notes_form: document.getElementById("notes-form"),
	assesment_form: document.getElementById("assesment-form"),
	injections_form: document.getElementById("injections-form"),
	procedures_form: document.getElementById("procedures-form"),
	prescription_form: document.getElementById("prescription-form"),
	staff_id: document.getElementById('staff-id'),


	patient_id: null,
	createXHR: function()
	{
		patient.xhr = null;
		try{
			patient.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				patient.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(patient.xhr)
		{
			try{
				patient.url = "../control/DoctorController.php";
				patient.xhr.open("POST", patient.url, true);
				patient.xhr.onreadystatechange = patient.response;
				patient.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				if(patient.notes_form.name == "notes_form")
				{
					patient.xhr.send(
						patient.patient_id+"=" + patient.notes_form.notes_pid.value
						+"&"+patient.staff_id.name+"="+patient.staff_id.value
						+"&"+patient.notes_form.doctors_notes.name+"="+patient.notes_form.doctors_notes.value);
				}else if(patient.assesment_form.name == "assesment_form")
				{
					var signs_name = patient.assesment_form.signs.name;
					var signs_value = patient.assesment_form.signs.value;
					patient.xhr.send(
						patient.patient_id+"="+patient.assesment_form.asses_pid.value
						+"&"+patient.staff_id.name+"="+patient.staff_id.value
						+"&"+patient.assesment_form.symptoms.name+"="+patient.assesment_form.symptoms.value
						+"&"+signs_name+"="+signs_value
						);
				}else if(patient.injections_form.name == "injections_form"){
					var injections_name = patient.injections_form.injections.name;
					var injections_value = patient.injections_form.injections.value;
					patient.xhr.send(
						patient.patient_id+"="+patient.injections_form.injections_pid.value
						+"&"+patient.staff_id.name+"="+patient.staff_id.value
						+"&"+injections_name+"="+injections_value
						);
				}else if(patient.procedures_form.name == "procedures_form"){
					var investigation_name = patient.procedures_form.investigation.name;
					var investigation_value = patient.procedures_form.investigation.value;
					var procedures_name = patient.procedures_form.procedures.name;
					var procedures_value = patient.procedures_form.procedures.value;
					patient.xhr.send(
						patient.patient_id+"="+patient.procedures_form.proc_pid.value
						+"&"+patient.staff_id.name+"="+patient.staff_id.value
						+"&"+investigation_name+"="+investigation_value
						+"&"+procedures_name+"="+procedures_value
						);
				}else if(patient.prescription_form.name == "prescription_form"){
					var prescription_name = patient.prescription_form.prescription.name;
					var prescription_value = patient.prescription_form.prescription.value;
		
					patient.xhr.send(
						patient.patient_id+"="+patient.prescription_form.presc_pid.value
						+"&"+patient.staff_id.name+"="+patient.staff_id.value
						+"&"+prescription_name+"="+prescription_value
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
		if(patient.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(patient.xhr.status == 200){
				try{
					
					let result = JSON.parse(patient.xhr.responseText);
					if(result[0] == false)
					{
						console.log(result[1]);
					}else if(result[0] == true){	
						if(result[3] == "notes")
						{
							patient.content(patient.savenotes_btn, result[1]);
						}else if(result[3] == "assesment")
						{
							patient.content(patient.save_ass_btn, result[1]);
						}else if(result[3] == "injections")
						{
							patient.content(patient.save_injections_btn, result[1]);
						}else if(result[3] == "procedures")
						{
							patient.content(patient.save_proc_btn, result[1]);
						}else if(result[3] == "prescription")
						{
							patient.content(patient.save_presc_btn, result[1]);
						}				
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(patient.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	content: function(btn, message){
		btn.value = message;
		btn.style.backgroundColor = "green";
	},
	
	runSavePatientData: function(){
		patient.createXHR();
		patient.savenotes_btn.addEventListener("click", function()
		{	
			patient.notes_form.name = "notes_form";
			if(patient.notes_form.name == "notes_form")
			{
				patient.assesment_form.name = "";
				patient.injections_form.name = "";
				patient.procedures_form.name = "";
				patient.prescription_form.name = "";
				patient.patient_id = patient.notes_form.notes_pid.name;
				patient.request();
			}
		});

		//assesment button
		patient.save_ass_btn.addEventListener("click", function()
		{	
			patient.assesment_form.name = "assesment_form";
			if(patient.assesment_form.name == "assesment_form")
			{
				patient.notes_form.name = "";
				patient.injections_form.name = "";
				patient.procedures_form.name = "";
				patient.prescription_form.name = "";
				patient.patient_id = patient.assesment_form.asses_pid.name;
				patient.request();
			}
		});
		
		//injections btn
		patient.save_injections_btn.addEventListener("click", function()
		{	
			patient.injections_form.name = "injections_form";
			if(patient.injections_form.name == "injections_form")
			{
				patient.notes_form.name = "";
				patient.assesment_form.name = "";
				patient.procedures_form.name = "";
				patient.prescription_form.name = "";
				patient.patient_id = patient.injections_form.injections_pid.name;
				patient.request();
			}
		});
		//procedures btn
		patient.save_proc_btn.addEventListener("click", function()
		{	
			patient.procedures_form.name = "procedures_form";
			if(patient.procedures_form.name == "procedures_form")
			{
				patient.notes_form.name = "";
				patient.assesment_form.name = "";
				patient.injections_form.name = "";
				patient.prescription_form.name = "";
				patient.patient_id = patient.procedures_form.proc_pid.name;
				patient.request();
			}
		});

		//prescription btn
		patient.save_presc_btn.addEventListener("click", function()
		{	
			patient.prescription_form.name = "prescription_form";
			if(patient.prescription_form.name == "prescription_form")
			{
				patient.notes_form.name = "";
				patient.assesment_form.name = "";
				patient.injections_form.name = "";
				patient.procedures_form.name = "";
				patient.patient_id = patient.prescription_form.presc_pid.name;
				patient.request();
			}
		});
		/*********************************************************************************************************************/
	},
}

patient.runSavePatientData();