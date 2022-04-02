let prescriptionObject = {
	xhr: null,
	url: null,
	prescription_btn: document.getElementById("print-prescription-btn"),
	prescription_form: document.getElementById("prescription-form"),
	print_prescription: document.getElementById('print-prescription-div'),
	p_name: document.getElementById("td-pat-name"),
	p_addr: document.getElementById("td-pat-addr"),
	p_age: document.getElementById("td-pat-age"),
	p_gender: document.getElementById("td-pat-gender"),
	presc: document.getElementById("td-pat-presc"),
	doc_name: document.getElementById("td-doc-name"),
	presc_date: document.getElementById("td-presc-date"),
	closePrint_btn: document.getElementById("close-print-btn"),
	print_btn: document.getElementById('print-btn'),

	createXHR: function()
	{
		prescriptionObject.xhr = null;
		try{
			prescriptionObject.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				prescriptionObject.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},

	request: function()
	{
		if(prescriptionObject.xhr)
		{
			try{
				prescriptionObject.url = "../control/PrescriptionController.php";
				prescriptionObject.xhr.open("POST", prescriptionObject.url, true);
				prescriptionObject.xhr.onreadystatechange = prescriptionObject.response;
				prescriptionObject.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				prescriptionObject.xhr.send("presc_pid=" + prescriptionObject.prescription_form.presc_pid.value);

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
		if(prescriptionObject.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(prescriptionObject.xhr.status == 200){
				try{
					let result = JSON.parse(prescriptionObject.xhr.responseText);
					if(result[0] == false)
					{
						console.log(result[1]);

					}else if(result[0] == true){	

						prescriptionObject.print_prescription.style.display = "block";
						prescriptionObject.closePrint_btn.style.display = "block";
						prescriptionObject.print_btn.style.display = "block";
						prescriptionObject.p_name.append(document.createTextNode(" "+result[1].name));
						prescriptionObject.p_addr.append(document.createTextNode(" "+result[1].address));
						prescriptionObject.p_age.append(document.createTextNode(" "+result[1].age));
						prescriptionObject.p_gender.append(document.createTextNode(" "+result[1].gender));
						prescriptionObject.presc.append(document.createTextNode(" "+result[1].prescription));
						prescriptionObject.presc_date.append(document.createTextNode(" "+result[1].prescription_date));
						prescriptionObject.doc_name.append(document.createTextNode(" "+result[2].doctor));
						console.log(result[2]);
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(prescriptionObject.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},

	runPrescription: function()
	{
		prescriptionObject.createXHR();
		prescriptionObject.prescription_btn.addEventListener("click", function(){
			prescriptionObject.request();
		});
	},
	
}

printPriscriptionObject = {
	print_btn: document.getElementById('print-btn'),
	print_prescription: document.getElementById('print-prescription-div'),
	closePrint_btn: document.getElementById("close-print-btn"),

	printPrescription: function()
	{
		var print_prescription = printPriscriptionObject.print_prescription.innerHTML;
		var a = window.open('', '', 'height = 550, width=650');
		a.document.write('<html>');
		a.document.write('<body>');
		a.document.write(print_prescription);
		a.document.write('</body></html>');
		a.document.close();
		a.print();
	},

	runPrint: function()
	{
		printPriscriptionObject.closePrint_btn.addEventListener("click", function(){
			printPriscriptionObject.print_prescription.style.display = "none";
			printPriscriptionObject.print_btn.style.display = "none";
			printPriscriptionObject.closePrint_btn.style.display = "none";

		});
		printPriscriptionObject.print_btn.addEventListener("click", function()
		{
			printPriscriptionObject.printPrescription();
		});
	}
}

printPriscriptionObject.runPrint();
prescriptionObject.runPrescription();