let vitals = {
	xhr: null,
	url: null,
	
	vitals_form: document.getElementById("vitals-form"),
	vitals_c: document.getElementById("vitals-container"),
	fetch_vitals_btn: document.getElementById("fetch-v-btn"),

	createXHR: function()
	{
		vitals.xhr = null;
		try{
			vitals.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				vitals.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(vitals.xhr)
		{
			try{
				vitals.url = "../control/DoctorController.php";
				vitals.xhr.open("POST", vitals.url, true);
				vitals.xhr.onreadystatechange = vitals.response;
				vitals.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				vitals.xhr.send("vitals_pid=" + vitals.vitals_form.vitals_pid.value);
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
		if(vitals.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(vitals.xhr.status == 200){
				try{
					vitals.vitals_c.innerHTML = "";
					let result = JSON.parse(vitals.xhr.responseText);
					if(result[0] == false)
					{
						vitals.vitals_c.innerHTML = result[1];
					}else if(result[0] == true){
						for(var i = 0; i < result[1].length; i++)
						{
						var temp = result[1][i].temperature;
						var glucose = result[1][i].blood_glucose;
						var pressure = result[1][i].blood_pressure;
						var weight = result[1][i].weight;
						var height = result[1][i].height;
						var pulse = result[1][i].pulse	;		
						}		
						vitals.container(vitals.vitals_c, temp, glucose, pressure, weight, height, pulse);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(vitals.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	container: function(v_c, temp, glucose, pressure, weight, height, pulse)
	{
		var table = document.createElement("table");
		var thead = document.createElement("thead");
		var tbody = document.createElement("tbody");
		var heading1 = document.createElement("th");
		heading1.appendChild(document.createTextNode("Temperature"));
		var heading2 = document.createElement("th");
		heading2.appendChild(document.createTextNode("Blood Glucose"));
		var heading3 = document.createElement("th");
		heading3.appendChild(document.createTextNode("Blood Pressure"));
		var heading4 = document.createElement("th");
		heading4.appendChild(document.createTextNode("Weight"));
		var heading5 = document.createElement("th");
		heading5.appendChild(document.createTextNode("Height"));
		var heading6 = document.createElement("th");
		heading6.appendChild(document.createTextNode("Pulse"));

		var row1 = document.createElement("tr");
		row1.appendChild(heading1);
		row1.appendChild(heading2);
		row1.appendChild(heading3);
		row1.appendChild(heading4);
		row1.appendChild(heading5);
		row1.appendChild(heading6);
		thead.appendChild(row1);
		table.appendChild(thead);
		/************************************************************************************************/
		

		var row2_data1 = document.createElement("td");
		row2_data1.innerHTML = temp;
		var row2_data2 = document.createElement("td");
		row2_data2.innerHTML = glucose;
		var row2_data3 = document.createElement("td");
		row2_data3.appendChild(document.createTextNode(pressure));
		var row2_data4 = document.createElement("td");
		row2_data4.appendChild(document.createTextNode(weight));
		var row2_data5 = document.createElement("td");
		row2_data5.appendChild(document.createTextNode(height));
		var row2_data6 = document.createElement("td");
		row2_data6.appendChild(document.createTextNode(pulse));
		
		var row2 = document.createElement("tr");
		row2.appendChild(row2_data1);
		row2.appendChild(row2_data2);
		row2.appendChild(row2_data3);
		row2.appendChild(row2_data4);
		row2.appendChild(row2_data5);
		row2.appendChild(row2_data6);
		tbody.appendChild(row2);
		table.appendChild(tbody);
		table.setAttribute("id", "vitals-table-data");
		v_c.appendChild(table);

	},

	runVitals: function(){
		vitals.createXHR();
		vitals.fetch_vitals_btn.addEventListener("click", function(){
			vitals.request();
		});
	} 
	
}

vitals.runVitals();