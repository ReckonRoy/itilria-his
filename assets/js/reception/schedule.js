tabs = {
	appointment_tab: document.getElementById("appointment-tab"),
	schedule_tab: document.getElementById("schedule-tab"),
	app_container: document.getElementById("appointments-div"),
	sch_container: document.getElementById("schedule-div"),

	change_tab: function(){
		//by default schedule container is set to display none
		tabs.sch_container.style.display = "none";
		this.appointment_tab.addEventListener("click", function()
		{
			if(tabs.app_container.style.display == "none"){
				tabs.sch_container.style.display = "none";
				tabs.app_container.style.display = "grid";
			}
			
		});

		this.schedule_tab.addEventListener("click", function(){
			if(tabs.sch_container.style.display == "none"){
				tabs.app_container.style.display = "none";
				tabs.sch_container.style.display = "grid";
			}
			
		});
	},
}

class Appointment{
	schedule_mydate = document.getElementById('sch-month-year');
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
				this.url = "../control/schedulecontroller.php";
				this.xhr.open("POST", this.url, true);
				appointment.xhr.onreadystatechange = appointment.response;
				this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				//send request
				this.xhr.send(
					"appointment=" + "appointment"	
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
		if(appointment.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(appointment.xhr.status == 200){
				//get JSON results
				let result = JSON.parse(appointment.xhr.responseText);
				if(result[0] == true){	
					appointment.content(result[1]);
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
				alert(appointment.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	}

	content(date)
	{
		alert("hello world");
		var ul = document.createElement('ul');
		for (var count = 0; count < date.length; count++) {
			var li = document.createElement('li');
			li.appendChild(document.createTextNode(date[count]));
			li.className = "li_date";
			ul.appendChild(li);
			appointment.getDateValue(li);
		}
		
		appointment.schedule_mydate.appendChild(ul);
	}

	getDateValue(listProperty)
	{
		listProperty.addEventListener("click", function()
		{
			appointment.getDayValue(listProperty.textContent);
		});
	}

	/*This function returns the day values under the selected month*/
	getDayValue(day){
		appointment.request();
	}

}

tabs.change_tab();
let appointment = new Appointment();
appointment.createXHR();
appointment.request();