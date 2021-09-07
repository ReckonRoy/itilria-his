let emr = {
	emr_btn: document.getElementById("emr-btn"),
	patient_id: document.getElementById("patientID-field"),
	emr_parent_div: document.getElementById("emr-container"),
	emr_e_d: document.getElementById("emr-record-div"),
	emr_date: document.getElementById('emr-rd-div'),
	date_table: document.getElementById("date_table"),
	close_btn: document.getElementById("close"),
	overlay: document.getElementById('overlay'),
	access_option: null,
	xhr: null,
	url: null,
	record_date: null,

	createXHR: function()
	{
		emr.xhr = null;
		try{
			emr.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				emr.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(emr.xhr)
		{
			try{
				emr.url = "../../emr/control/EmrController.php";
				emr.xhr.open("POST", emr.url, true);
				emr.xhr.onreadystatechange = emr.response;
				emr.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				//access emr record when the emr button is clicked
				if(emr.access_option == "emr_default_access")
				{
					emr.xhr.send(
					"patient_id=" + emr.patient_id.value	
					);

				}else if(emr.access_option == "emr_access_date")//access the emr record when the date is selected
				{
					emr.xhr.send(
					"p_id=" + emr.patient_id.value
					+"&"+"record_date"+"="+emr.record_date	
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
		if(emr.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(emr.xhr.status == 200){
				try{
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
				}
			}else{
				alert(emr.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	runEmr: function()
	{
		emr.createXHR();
		emr.overlay.style.display = "none";
		emr.emr_btn.addEventListener("click", function(){
			emr.access_option = "emr_default_access";
			emr.emr_date.innerHTML = "";
			emr.request();
		});
	},

	emr_modal: function(){
		emr.emr_parent_div.style.display = "none";
		emr.close_btn.addEventListener("click", function(){
			if(emr.emr_parent_div.style.display == "grid"){
				emr.emr_parent_div.style.display = "none";
			}
		});

		emr.emr_btn.addEventListener("click", function(){
			if(emr.emr_parent_div.style.display == "none"){
				emr.emr_parent_div.style.display = "grid";
			}
		});


	},

	/**
	 * prdc: patient record by date container
	 * this function displays the patients records by date
	 * it enables the user to select patient record based on a certain recorded date
	 */
	prd_container: function (parent, dates) {
		var table = document.createElement("table");
		table.className = "record_table_class";
		var thead = document.createElement("thead");
		var th = document.createElement("th");
		th.appendChild(document.createTextNode("Patient Record(s)"));
		thead.appendChild(th);
		table.appendChild(thead);
		for(var i = 0; i < dates.length; i++)
		{
			var tr = document.createElement("tr");
			var td = document.createElement("td");
			tr.appendChild(td);
			td.appendChild(document.createTextNode(dates[i]));
			table.appendChild(tr);
			emr.record_by_date(td);	
		}
	
		parent.appendChild(table);

		
	},

	//handle click events on the dates
	record_by_date: function(date_param)
	{
		date_param.addEventListener("click", function()
		{
			emr.access_option = "emr_access_date";
			emr.record_date = date_param.textContent;
			emr.request();
		});
	},
	/**
	 * Content div: displays the patient file 
	 * record is in tabular format
	 */
	content: function(container, record)
	{
		var table = document.createElement("table");
		table.className = "emr_table";
		var thead = document.createElement("thead");
		var th = document.createElement("th");
		th.setAttribute("id", "table-header");
		th.colSpan = "2";
		var empty_row = document.createElement("tr");
		var empty_data = document.createElement("td");
		empty_data.style.border = "none";
		empty_row.appendChild(empty_data);
		var empty_row2 = document.createElement("tr");
		var empty_data2 = document.createElement("td");
		empty_data2.style.border = "none";
		empty_row2.appendChild(empty_data2);
		th.appendChild(document.createTextNode("Electronic Medical Record"));
		thead.appendChild(th);
		table.appendChild(thead);

		var tbody = document.createElement("tbody");
		var row1 = document.createElement("tr");

		var row1_h1 = document.createElement("th");
		row1_h1.appendChild(document.createTextNode("Medical record of"));
		row1.appendChild(row1_h1);
		
		var row1_data1 = document.createElement("td");
		row1_data1.appendChild(document.createTextNode(record.name+" "+record.surname));
		row1.appendChild(row1_data1);
		tbody.appendChild(row1);
		//gender
		var row1_1 = document.createElement("tr");
		row1_1_h1 = document.createElement("th");
		row1_1_h1.appendChild(document.createTextNode("Gender"));
		row1_1.appendChild(row1_1_h1);
		row1_1_data1 = document.createElement("td");
		row1_1_data1.appendChild(document.createTextNode(record.gender));
		row1_1.appendChild(row1_1_data1);
		tbody.appendChild(row1_1);
		//date

		var row2_age = document.createElement("tr");
		row2_age_h1 = document.createElement("th");
		row2_age_h1.appendChild(document.createTextNode("Age"));
		row2_age.appendChild(row2_age_h1);
		row2_age_data1 = document.createElement("td");
		row2_age_data1.appendChild(document.createTextNode(record.age));
		row2_age.appendChild(row2_age_data1);
		tbody.appendChild(row2_age);

		var row2 = document.createElement("tr");
		row2_h1 = document.createElement("th");
		row2_h1.appendChild(document.createTextNode("Date"));
		row2.appendChild(row2_h1);
		row2_data1 = document.createElement("td");
		row2_data1.appendChild(document.createTextNode(record.vitals_date));
		row2.appendChild(row2_data1);
		tbody.appendChild(row2);

		//create next line
		tbody.appendChild(empty_row);
		tbody.appendChild(empty_row2);
		/***************************************************************************************************************
		 * 
		 * Space left for Reception
		 */

		/**************************************************************************************************************/
		//NURSE SECTION
		var row3 = document.createElement("tr");
		var row3_h1 = document.createElement("th");
		row3_h1.appendChild(document.createTextNode("Time"));
		row3.appendChild(row3_h1);
		var row3_data1 = document.createElement("td");
		row3_data1.appendChild(document.createTextNode(record.vitals_time));
		row3.appendChild(row3_data1);
		tbody.appendChild(row3);

		var row4 = document.createElement("tr");
		var row4_h1 = document.createElement("th");
		row4_h1.appendChild(document.createTextNode("Encounter"));
		row4.appendChild(row4_h1);
		var row4_data1 = document.createElement("td");
		row4_data1.appendChild(document.createTextNode("Preconsult"));
		row4.appendChild(row4_data1);
		tbody.appendChild(row4);

		var row5 = document.createElement("tr");
		var row5_h1 = document.createElement("th");
		row5_h1.appendChild(document.createTextNode("Care Provider"));
		row5.appendChild(row5_h1);

		var row5_data1 = document.createElement("td");
		row5_data1.appendChild(document.createTextNode(record.nurse_name + " " + record.nurse_surname+"("+record.profession+")"));
		row5.appendChild(row5_data1);
		tbody.appendChild(row5);

		var row5_1 = document.createElement("tr");
		var row5_1_h1 = document.createElement("th");
		row5_1_h1.appendChild(document.createTextNode("Patient History"));
		row5_1.appendChild(row5_1_h1);

		var row5_1_data1 = document.createElement("td");
		row5_1_data1.appendChild(document.createTextNode(record.history));
		row5_1.appendChild(row5_1_data1);
		tbody.appendChild(row5_1);

		var row6 = document.createElement("tr");
		var row6_h1 = document.createElement("th");
		row6_h1.appendChild(document.createTextNode("assesment"));
		row6.appendChild(row6_h1);
		var row6_data1 = document.createElement("td");

		var row6_data1_row6a = document.createElement("tr");
		var row6_data1_h1 = document.createElement("th");
		row6_data1_h1.appendChild(document.createTextNode("Vitals"));
		row6_data1_data = document.createElement("td");
		row6_data1_data.appendChild(document.createTextNode("Temperature: "+record.temp+ ", Blood glucose: "+record.glucose
			+", Blood pressure: "+record.pressure+", Weight: "+record.weight+", Height: "+record.height+
			", Pulse: "+record.pulse +", Saturation: "+record.saturation +", BMI: "+record.bmi
			));
		row6_data1_row6a.appendChild(row6_data1_h1);
		row6_data1_row6a.appendChild(row6_data1_data);
		row6_data1.appendChild(row6_data1_row6a);
		row6.appendChild(row6_data1);
		tbody.appendChild(row6);

		//create next line
		var empty_row = document.createElement("tr");
		var empty_data = document.createElement("td");
		empty_data.style.border = "none";
		empty_row.appendChild(empty_data);
		var empty_row2 = document.createElement("tr");
		var empty_data2 = document.createElement("td");
		empty_data2.style.border = "none";
		empty_row2.appendChild(empty_data2);
		tbody.appendChild(empty_row);
		tbody.appendChild(empty_row2);


		//Doctor Section
		var row7 = document.createElement("tr");
		var row7_h1 = document.createElement("th");
		row7_h1.appendChild(document.createTextNode("Time"));
		row7.appendChild(row7_h1);
		var row7_data1 = document.createElement("td");
		row7_data1.appendChild(document.createTextNode(record.doctor_time));
		row7.appendChild(row7_data1);
		tbody.appendChild(row7);

		var row8 = document.createElement("tr");
		var row8_h1 = document.createElement("th");
		row8_h1.appendChild(document.createTextNode("Care Provider"));
		row8.appendChild(row8_h1);
		var row8_data1 = document.createElement("td");
		row8_data1.appendChild(document.createTextNode(record.doctor_name + " " + record.doctor_surname));
		row8.appendChild(row8_data1);
		tbody.appendChild(row8);

		var row9 = document.createElement("tr");
		var row9_h1 = document.createElement("th");
		row9_h1.appendChild(document.createTextNode("assesment"));
		row9.appendChild(row9_h1);
		var row9_data1 = document.createElement("td");

		var row9_data1_row9a = document.createElement("tr");
		var row9_data1_h1 = document.createElement("th");
		row9_data1_h1.appendChild(document.createTextNode("Symptoms"));
		row9_data1_data = document.createElement("td");
		row9_data1_data.appendChild(document.createTextNode(record.symptoms));
		row9_data1_row9a.appendChild(row9_data1_h1);
		row9_data1_row9a.appendChild(row9_data1_data);
		row9_data1.appendChild(row9_data1_row9a);

		var row9_data1_row9b = document.createElement("tr");
		var row9_data1_h2 = document.createElement("th");
		row9_data1_h2.appendChild(document.createTextNode("Signs"));
		row9_data1_datab = document.createElement("td");
		row9_data1_datab.appendChild(document.createTextNode(record.signs));
		row9_data1_row9b.appendChild(row9_data1_h2);
		row9_data1_row9b.appendChild(row9_data1_datab);
		row9_data1.appendChild(row9_data1_row9b);

		row9.appendChild(row9_data1);
		tbody.appendChild(row9);

		var row10 = document.createElement("tr");
		var row10_h1 = document.createElement("th");
		row10.appendChild(row10_h1);
		var row10_data1 = document.createElement("td");

		var row10_data1_row10a = document.createElement("tr");
		var row10_data1_h1 = document.createElement("th");
		row10_data1_h1.appendChild(document.createTextNode("Investigations"));
		row10_data1_data = document.createElement("td");
		row10_data1_data.appendChild(document.createTextNode(record.investigation));
		row10_data1_row10a.appendChild(row10_data1_h1);
		row10_data1_row10a.appendChild(row10_data1_data);
		row10_data1.appendChild(row10_data1_row10a);

		var row10_data1_row10b = document.createElement("tr");
		var row10_data1_h2 = document.createElement("th");
		row10_data1_h2.appendChild(document.createTextNode("procedures"));
		row10_data1_datab = document.createElement("td");
		row10_data1_datab.appendChild(document.createTextNode(record.procedures));
		row10_data1_row10b.appendChild(row10_data1_h2);
		row10_data1_row10b.appendChild(row10_data1_datab);
		row10_data1.appendChild(row10_data1_row10b);

		row10.appendChild(row10_data1);
		tbody.appendChild(row10);

		var row11 = document.createElement("tr");
		row11_h1 = document.createElement("th");
		row11_h1.appendChild(document.createTextNode("Prescription"));
		row11.appendChild(row11_h1);
		row11_data1 = document.createElement("td");
		row11_data1.appendChild(document.createTextNode(record.prescription));
		row11.appendChild(row11_data1);
		tbody.appendChild(row11);

		var row12 = document.createElement("tr");
		row12_h1 = document.createElement("th");
		row12_h1.appendChild(document.createTextNode("Injections"));
		row12.appendChild(row12_h1);
		row12_data1 = document.createElement("td");
		row12_data1.appendChild(document.createTextNode(record.injections));
		row12.appendChild(row12_data1);
		tbody.appendChild(row12);
		table.appendChild(tbody);
		
		container.appendChild(table);
	},

	
	
}

emr.runEmr();
emr.emr_modal();