let asideObject = {
	appointment_tab: document.getElementById("appointment-btn"),
	vital_tab: document.getElementById("vital-btn"),

	clickAction: function(){
		this.appointment_tab.addEventListener("click", function(){
			window.location.href = "./admin.php";
		});

		this.vital_tab.addEventListener("click", function(){
			window.location.href = "./vitals.php";
		});
	} 
}

asideObject.clickAction(); 