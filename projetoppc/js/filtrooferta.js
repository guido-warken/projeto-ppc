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
		if (divUnidade.hidden == false)
			divUnidade.hidden = true;
	} else if (isChecked(opcao2)) {
		divUnidade.hidden = false;
		if (divPpc.hidden == false)
			divPpc.hidden = true;
	}
}

function isChecked(componente) {
	return componente.checked;
}