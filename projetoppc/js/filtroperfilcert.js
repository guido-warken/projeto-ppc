/**
 * 
 */

function gerenciarFiltro() {
	var divPpc = document.getElementById("div-ppc");
	var divCompetencia = document.getElementById("div-competencia");
	var divCert = document.getElementById("div-cert");
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	var opcao3 = document.getElementById("opt3");
	if (isChecked(opcao1)) {
		divCert.hidden = true;
		divCompetencia.hidden = true;
		divPpc.hidden = false;
	} else if (isChecked(opcao2)) {
		divCert.hidden = true;
		divCompetencia.hidden = false;
		divPpc.hidden = true;
	} else if (isChecked(opcao3)) {
		divCert.hidden = false;
		divCompetencia.hidden = true;
		divPpc.hidden = true;
	}
}

function isChecked(componente) {
	return componente.checked;
}
