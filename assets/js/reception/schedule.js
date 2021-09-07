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
let appointment = {

}

tabs.change_tab();