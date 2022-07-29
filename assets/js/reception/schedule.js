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
	schedule_day = document.getElementById('sch-date-select');
	sbtn_div = document.getElementById("sch-btn-div");
	schedule_btn = document.getElementById('sch-btn');
	rfb = document.getElementById("purpose-section");//rfb-reason for booking
	visit_reason1 = document.getElementById('option1');
	visit_reason2 = document.getElementById('option2');
	appointment_day = null;
	month_day_value = null;
	reason_array = [];
	send_control = "default";
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
				if(appointment.send_control === "default"){
					this.xhr.send(
					"appointment=" + "appointment"	
					);
				}else if(appointment.send_control === "month_day")
				{
					this.xhr.send(
					"month_day=" + appointment.month_day_value	
					);
				} else if(appointment.send_control === "book patient"){
					patient_id = document.getElementById('patientID-field').value;
					alert(patient_id);
					this.xhr.send(
							"appointment_date="+appointment.appointment_day
							+"&appointment_reason="+appointment.reason_array
							+"&patient_id="+patient_id
						);
				}
				
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
					if(result[2] == "appointment")
					{
						appointment.content(result[1]);	
					}else if(result[2] == "month_day")
					{
						appointment.content_day(result[1]);
					}
					
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
		var ul = document.createElement('ul');
		for (var count = 0; count < date.length; count++) {
			var li = document.createElement('li');
			li.appendChild(document.createTextNode(date[count]));
			li.className = "li_date";
			ul.appendChild(li);
			appointment.getDateValue(li, "month_year_value");
		}
		appointment.schedule_mydate.appendChild(ul);
	}

	content_day(day)
	{
		var ul = document.createElement('ul');
		for (var count = 0; count < day.length; count++) {
			var li = document.createElement('li');
			li.appendChild(document.createTextNode(day[count]));
			li.className = "li_date";
			ul.appendChild(li);
			appointment.getDateValue(li, "day_value");
		}
		
		appointment.schedule_day.style.display = "block";
		appointment.schedule_day.appendChild(ul);
		appointment.schedule_mydate.style.display = "none";
	}

	getDateValue(listProperty, option)
	{
		listProperty.addEventListener("click", function()
		{
			if(option === "month_year_value")
			{
				appointment.getDayValue(listProperty.textContent);	
			}else if(option === "day_value"){
				appointment.appointment_day = listProperty.textContent;
				appointment.rfb.style.display = "block";
				appointment.sbtn_div.style.display = "block";
			}
			
		});
	}

	/*This function returns the day values under the selected month*/
	getDayValue(day){
		appointment.send_control = "month_day";
		appointment.month_day_value = day;
		appointment.request();
	}

	schedule_appointment()
	{
		appointment.schedule_btn.addEventListener("click", function()
		{
			
			if(appointment.appointment_day !== null)
			{
				if ((appointment.visit_reason1.checked === true)  || appointment.visit_reason2.checked === true)
				{
					if(appointment.visit_reason1.checked)
					{
						appointment.reason_array.push(appointment.visit_reason1.value);	
					}

					if(appointment.visit_reason2.checked)
					{
						appointment.reason_array.push(appointment.visit_reason2.value);	
					}
					
					alert(` ${appointment.appointment_day}\n${appointment.reason_array}`);
					appointment.send_control = "book patient";
					appointment.request();					
				}else{
					alert("please select a reason for your visit");
				}
			}else{
				alert("Please select an appointment day");
			}
		});
	}

}

tabs.change_tab();
let appointment = new Appointment();
appointment.createXHR();
appointment.request();
appointment.schedule_appointment();