/**
 * 
 */

function validarFormulario() {
	var disnome = document.getElementById("disnome");
	var disobj = document.getElementById("disobj");
	var disch = document.getElementById("disch");
	var discementa = document.getElementById("discementa");
	if (disnome.value.length == 0) {
		alert("O campo nome da disciplina deve ser preenchido corretamente.");
		disnome.focus();
		return false;
	} else if (disobj.value.length == 0) {
		alert("O campo Objetivo da disciplina deve ser preenchido corretamente.");
		disobj.focus();
		return false;
	} else if (isNaN(disch.value)) {
		alert("O campo carga horária da disciplina deve ser preenchido corretamente.");
		disch.focus();
		return false;
	} else if (discementa.value.length == 0) {
		alert("O campo ementa da disciplina deve ser preenchido corretamente.");
		discementa.focus();
		return false;
	}
}