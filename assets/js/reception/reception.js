let nokObject = {
	nok_dropdown: document.getElementById("nok-dropdown"),
	nok_rel: document.getElementById("nok-rel"),
	list: document.getElementById("rel-ol"),

	nok_m: function()
	{
		nokObject.nok_rel.addEventListener("click", function(){
			if(nokObject.nok_dropdown.style.display == ""){
				nokObject.nok_dropdown.style.display = "block";
				for(var i = 0; i < nokObject.list.childElementCount; i++){
					nokObject.list.children[i].addEventListener("click", function(){
						nokObject.nok_rel.value = this.innerText;
						nokObject.nok_dropdown.style.display = "";
					});
				}
			}else{
				nokObject.nok_dropdown.style.display = "";
			}
		});
	},
}

nokObject.nok_m();