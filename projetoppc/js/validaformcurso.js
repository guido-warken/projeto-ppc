/**
 * 
 */
function validarFormulario() {
	var curnome = document.getElementById("curnome");
	var curtit = document.getElementById("curtit");
	var eixcod = document.getElementById("eixcod");
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
	if (eixcod.value == "-1") {
		alert("Por favor, selecione um curso.");
		eixcod.focus();
		return false;
	}
}