function submitButton(value){
	document.getElementById("adminForm").setAttribute("action",document.getElementById("adminForm").getAttribute("action")+"&task="+value);
	jQuery('[disabled]').removeAttr('disabled');
	document.getElementById("adminForm").submit();
}