/**
 * 
 */
function validarFormulario() {
	var curnome = document.getElementById("curnome");
	var curtit = document.getElementById("curtit");
	if (curnome.value.length == 0) {
		alert("O campo nome do curso deve ser preenchido corretamente.");
		curnome.focus();
		return false;
	}
	if (curtit.value.length == 0) {
		alert("O campo titulação do curso deve ser preenchido corretamente.");
		curtit.focus();
		return false;
	}
}