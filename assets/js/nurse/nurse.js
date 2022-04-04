

let saveVitals = {
	xhr: null,
	url: null,
	vitals_btn: document.getElementById("vitals-btn"),
	vitals_form: document.getElementById("vitals-form"),
	//notification_div: document.getElementById("notification-div"),
	close_btn: document.getElementById("close-btn"),
	vitals_div: document.getElementById("vitals-div"),
	p_tag: document.getElementById("message"),
	smp_div: document.getElementById("server-message-response"),
	n_c_d: document.getElementById("n-c-d"),
	createXHR: function()
	{
		saveVitals.xhr = null;
		try{
			saveVitals.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				saveVitals.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(saveVitals.xhr)
		{
			try{
				saveVitals.url = "../control/VitalsController.php";
				saveVitals.xhr.open("POST", saveVitals.url, true);
				saveVitals.xhr.onreadystatechange = saveVitals.response;
				saveVitals.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
				var temp = saveVitals.vitals_form.temperature;
				var glucose = saveVitals.vitals_form.blood_glu;
				var pressure = saveVitals.vitals_form.blood_pre;
				var weight = saveVitals.vitals_form.weight;
				var height = saveVitals.vitals_form.height;
				var pulse = saveVitals.vitals_form.pulse;
				var sat = saveVitals.vitals_form.saturation;
				var patient_id = saveVitals.vitals_form.p_id;
				var bmi = saveVitals.vitals_form.bmi;
				var vtime = saveVitals.vitals_form.vitals_time;
				var vdate = saveVitals.vitals_form.vitals_date;
				var history = saveVitals.vitals_form.history;
				saveVitals.xhr.send(
					patient_id.name+"="+patient_id.value
					+"&"+temp.name+"="+temp.value
					+"&"+glucose.name+"="+glucose.value
					+"&"+pressure.name+"="+pressure.value
					+"&"+weight.name+"="+weight.value
					+"&"+height.name+"="+height.value
					+"&"+pulse.name+"="+pulse.value
					+"&"+sat.name+"="+sat.value
					+"&"+bmi.name+"="+bmi.value
					+"&"+vtime.name+"="+vtime.value
					+"&"+vdate.name+"="+vdate.value
					+"&"+history.name+"="+history.value);

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
		if(saveVitals.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(saveVitals.xhr.status == 200){
				try{
					let result = JSON.parse(saveVitals.xhr.responseText);
					if(result[0] == false)
					{
						saveVitals.container(saveVitals.p_tag, result[1], result[2]);
					}else if(result[0] == true){					
						saveVitals.container(saveVitals.p_tag, result[1], result[2]);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(saveVitals.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	runVitals: function(){
		//saveVitals.notification_div.style.display = "none";
		saveVitals.createXHR();
		saveVitals.vitals_btn.addEventListener("click", function(){
			saveVitals.request();
		});
	},

	container: function(p_tag, message, class_state){
		var overlay = document.getElementById("overlay");
		p_tag.innerHTML = "";
		
		saveVitals.smp_div.className = class_state;
		saveVitals.smp_div.style.display = "none";
		overlay.style.display = "none";
		if (saveVitals.smp_div.style.display == "none"){
			overlay.style.display = "block";
			saveVitals.smp_div.style.display = "block";
		}
		//position pop-up in appropriate place in relation to the meeting divs 
        var calcDiv1_geom = saveVitals.vitals_div.clientHeight / 2;
        var calcDiv2_geom = saveVitals.smp_div.clientHeight / 2;
      	var process_geom = ((saveVitals.vitals_div.offsetTop + saveVitals.vitals_div.clientHeight) - (calcDiv1_geom + calcDiv2_geom) - 500);
        saveVitals.smp_div.style.top = process_geom + "px";
		window.scrollTo(0, saveVitals.vitals_div.offsetTop);
		
		p_tag.appendChild(document.createTextNode(message));
		saveVitals.close_btn.addEventListener("click", function(){
			overlay.style.display = "none";
			saveVitals.smp_div.style.display = "none";
		});
	},
	
}

saveVitals.runVitals();