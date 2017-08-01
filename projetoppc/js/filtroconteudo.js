/**
 * 
 */
function gerenciarFiltro() {
	var divPpc = document.getElementById("div-ppc");
	var divDisciplina = document.getElementById("div-disciplina");
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	if (isChecked(opcao1)) {
		divDisciplina.hidden = true;
		divPpc.hidden = false;
	} else if (isChecked(opcao2)) {
		divPpc.hidden = true;
		divDisciplina.hidden = false;
	}
}

function isChecked(componente) {
	return componente.checked;
}