/**
 * 
 */
function gerenciarFiltro() {
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	var divPpc = document.getElementById("div-ppc");
	var divUnidade = document.getElementById("div-unidade");
	if (isChecked(opcao1)) {
		divUnidade.hidden = true;
		divPpc.hidden = false;
	}
	if (isChecked(opcao2)) {
		divPpc.hidden = true;
		divUnidade.hidden = false;
	}
}

function isChecked(componente) {
	return componente.checked;
}