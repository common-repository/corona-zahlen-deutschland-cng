function toggleCoronaNumbers() {
	var element=document.getElementsByClassName("cng_overlay");
	element[0].classList.toggle("hidden");
	window.localStorage.setItem("cng_hide_overlay",element[0].classList.contains("hidden"));
} 

window.onload=function(){
	if(window.localStorage.getItem("cng_hide_overlay")!=null&&window.localStorage.getItem("cng_hide_overlay")=="false"){
		var element=document.getElementsByClassName("cng_overlay");
		element[0].classList.toggle("hidden");
	}
}