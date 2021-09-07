
let nok_dropdown = document.getElementById("nok-dropdown");
let nok_rel = document.getElementById("nok-rel");
let list = document.getElementById("rel-ol");



nok_rel.addEventListener("click", function(){
	if(nok_dropdown.style.display == ""){
		nok_dropdown.style.display = "block";
		for(var i = 0; i < list.childElementCount; i++){
			list.children[i].addEventListener("click", function(){
				nok_rel.value = this.innerText;
				nok_dropdown.style.display = "";
			});
		}
	}else{
		nok_dropdown.style.display = "";
	}
});
