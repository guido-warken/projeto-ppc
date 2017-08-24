/**
 * 
 */
function gerenciarFiltro() {
	var divPpc = document.getElementById("div-ppc");
	var divCompetencia = document.getElementById("div-competencia");
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	if (isChecked(opcao1)) {
		divCompetencia.hidden = true;
		divPpc.hidden = false;
	} else if (isChecked(opcao2)) {
		divPpc.hidden = true;
		divCompetencia.hidden = false;
	}
}

function isChecked(componente) {
	return componente.checked;
}