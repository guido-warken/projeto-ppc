/**
 * 
 */
function validarFormulario() {
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	var ppcObj = document.getElementById("ppcobj");
	var ppcDesc = document.getElementById("ppcdesc");
	var ppcEstagio = document.getElementById("ppcestagio");
	var curcod = document.getElementById("curcod");
	var ppcanoini = document.getElementById("ppcanoini");
	if (ppcObj.value.length == 0) {
		alert("O campo objetivo do PPC deve ser preenchido corretamente.");
		ppcObj.focus();
		return false;
	}
	if (ppcDesc.value.length == 0) {
		alert("O campo estrutura curricular do PPC deve ser preenchido corretamente.");
		ppcDesc.focus();
		return false;
	}
	if (ppcEstagio.value.length == 0) {
		alert("O campo estágio do PPC deve ser preenchido corretamente.");
		ppcEstagio.focus();
		return false;
	}
	if (curcod.value == "-1") {
		alert("Por favor, selecione um curso.");
		curcod.focus();
		return false;
	}
	if (!isChecked(opcao1) && !isChecked(opcao2)) {
		alert("Selecione uma das duas opções para a modalidade do PPC.");
		opcao1.focus();
		return false;
	}
	if (isNaN(ppcanoini.value) || ppcanoini.value.length == 0) {
		alert("O campo ano de início de vigência do PPC deve ser preenchido corretamente.");
		ppcanoini.focus();
		return false;
	}
}

function isChecked(componente) {
	return componente.checked;
}

function validarConsulta() {
	var curcod = document.getElementById("curcod");
	if (curcod.value == "-1") {
		alert("Por favor, selecione um curso.");
		curcod.focus();
		return false;
	}
}