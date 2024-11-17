function printID(e){
	e=e || window.event;
	e=e.target|| e.srcElement;
	console.log("ID:" + e.id + " value : " + e.src);
}
