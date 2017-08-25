/**
 * 
 */
function gerenciarFiltro() {
	var divPpc = document.getElementById("div-ppc");
	var divUnidade = document.getElementById("div-unidade");
	var opcao1 = document.getElementById("opt1");
	var opcao2 = document.getElementById("opt2");
	if (isChecked(opcao1)) {
		divPpc.hidden = false;
	} else if (isChecked(opcao2)) {
		divUnidade.hidden = false;
	}
}

function isChecked(componente) {
	return componente.checked;
}