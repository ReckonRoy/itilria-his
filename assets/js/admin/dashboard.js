class Dashboard{

	patient_id = document.getElementById('patient-id');
	doctor_count = document.getElementById('doctor-count');
	patient_count = document.getElementById('patient-count');
	nurse_count = document.getElementById('nurse-count');
	receptionist_count = document.getElementById('receptionist-count');
	url = null;
	xhr = null;
	createXHR()
	{
		try{
			this.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				this.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	}

	request()
	{
		if(this.xhr)
		{
			try{
				this.url = "./controller/dashboardcontroller.php";
				this.xhr.open("POST", this.url, true);
				dashboard.xhr.onreadystatechange = dashboard.response;
				this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				//send request
				this.xhr.send(
					"patient_id=" + "patient_id"	
					);

				/**if(emr.access_option == "emr_default_access")
				{
					this.xhr.send(
					"patient_id=" + emr.patient_id.value	
					);

				}else if(emr.access_option == "emr_access_date")//access the emr record when the date is selected
				{
					emr.xhr.send(
					"p_id=" + emr.patient_id.value
					+"&"+"record_date"+"="+emr.record_date	
					);					

				}
				*/	
				document.body.style.cursor = "wait";
				
			}catch(e){
				alert("Can't connect to server: " + e.toString());
				document.body.style.cursor = "default";
			}
		}
	}

	response()
	{
		//check if request is complete
		if(dashboard.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(dashboard.xhr.status == 200){
				//get JSON results
				let result = JSON.parse(dashboard.xhr.responseText);
				if(result[0] == false)
				{
					console.log(result[1]);
				}else if(result[0] == true){	
			
					dashboard.doctor_count.innerText = result[1].doctors;
					dashboard.patient_count.innerText = result[1].patients;
					dashboard.nurse_count.innerText = result[1].nurses;
					dashboard.receptionist_count.innerText = result[1].receptionist;
				}

				/*try{
					emr.emr_e_d.innerHTML = "";
					let result = JSON.parse(emr.xhr.responseText);
					if(result[0] == false)
					{

					}else if((result[0] == true) && (result[3] == "emr_access")){	
				
						emr.content(emr.emr_e_d, result[1]);
						emr.prd_container(emr.emr_date, result[2]);
					}else if((result[0] == true) && (result[2] == "emr_access_date"))
					{
						emr.content(emr.emr_e_d, result[1]);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}*/
			}else{
				alert(dashboard.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	}

	getPatientStats()
	{

	}
}
let dashboard = new Dashboard();
dashboard.createXHR();
dashboard.request();
