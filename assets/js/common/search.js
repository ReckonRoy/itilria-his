class SearchPatient{
	search_form = document.getElementById('search-form');
	search_btn = document.getElementById('search-btn');
	xhr = null;
	url = null;
	createXHR(){
		sp.xhr = null;
		try{
			sp.xhr = new XMLHttpRequest();
		}catch(e){
			try{
				sp.xhr = new ActiveXObject("Microsoft.XMLHttp");
			}catch(e){}
		}
	}
	request(){
		if(sp.xhr)
		{
			try{
				sp.url = "";	
				sp.xhr.open("POST", sp.url, true);
				sp.xhr.onreadystatechange = sp.response;
				sp.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				sp.xhr.send("patient_id=" + sp.search_form.search_field.value);

				document.body.style.cursor = "wait";
			}catch(e){
				alert("Can't connect to server: " + e.toString());
				document.body.style.cursor = "default";
			}
		}
	}
	response(){
		//check if request is complete
		if(sp.xhr.readyState == 4){
			document.body.style.cursor = "default";
			if(sp.xhr.status == 200){
				try{
					sp.resultBox.innerHTML = "";
					let result = JSON.parse(sp.xhr.responseText);
					if(result[0] == false)
					{
						console.log(result[0]);
					}else if(result[0] == true){					
						for(var i = 0; i < result[1].length; i++)
						{
							let patient_id = result[1][i].patient_id;
							let name = result[1][i].name;
							let surname = result[1][i].surname;
							/*sp.content*/alert(sp.resultBox, patient_id, name, surname);
						}
					}
				}catch(e){
					alert("error reading response: " + e.toString());
				}
			}else{
				alert(sp.xhr.statusText);
				document.body.style.cursor = "default";
			}
		}
	}
	getSearchVal(){
		sp.search_btn.addEventListener("click", function(){
			sp.createXHR();
			sp.request();
		});
	}
}

let sp = new SearchPatient();
sp.getSearchVal();