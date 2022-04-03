chargeSheetObject = {
	img_pid: document.getElementById('img-pid'),
	chargesheet_btn: document.getElementById('chargesheet-btn'),
	enlarged_img_div: document.getElementById("enlarged-img-div"),
	enlarged_img: document.getElementById('enlarged-img'),
	emr_container: document.getElementById('emr-container'),
	chargesheet_image: document.getElementById('chargesheet-image'),
	close_eid: document.getElementById("close-eid"),
	img_src: null,
	xhr: null,
	url: null,

	createXHR: function()
	{
		chargeSheetObject.xhr = null;
		try{
			chargeSheetObject.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				chargeSheetObject.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	},
	request: function()
	{
		if(chargeSheetObject.xhr)
		{
			try{
				chargeSheetObject.url = "../control/ChargeSheetController.php";
				chargeSheetObject.xhr.open("POST", chargeSheetObject.url, true);
				chargeSheetObject.xhr.onreadystatechange = chargeSheetObject.response;
				chargeSheetObject.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				chargeSheetObject.xhr.send(chargeSheetObject.img_pid.name+"="+chargeSheetObject.img_pid.value);

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
		if(chargeSheetObject.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(chargeSheetObject.xhr.status == 200){
				try{
					let result = JSON.parse(chargeSheetObject.xhr.responseText);
					if(result[0] == false)
					{
						console.log(result[1]);
					}else if(result[0] == true){					
						chargeSheetObject.chargesheet_image.src="../../uploads/"+result[1];
						chargeSheetObject.img_src = "../../uploads/"+result[1];
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(chargeSheetObject.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	},
	

	getChargeSheet: function()
	{
		chargeSheetObject.createXHR();
		chargeSheetObject.chargesheet_btn.addEventListener("click", function()
		{
			chargeSheetObject.request();
		});	
	},

	img_modal: function()
	{
		chargeSheetObject.chargesheet_image.addEventListener("click", function()
		{
			chargeSheetObject.emr_container.style.display = "none";
			chargeSheetObject.enlarged_img_div.style.display = "block";
			chargeSheetObject.enlarged_img.src = chargeSheetObject.img_src;
		});

		chargeSheetObject.close_eid.addEventListener("click", function()
		{
			chargeSheetObject.enlarged_img.src = "";
			chargeSheetObject.enlarged_img_div.style.display = "none";
			chargeSheetObject.emr_container.style.display = "grid";
		});
	}
}

chargeSheetObject.getChargeSheet();
chargeSheetObject.img_modal();