/**
 * 
 */
function validarFormulario() {
	var pdiAnoIni = document.getElementById("pdianoini");
	var pdiAnoFim = document.getElementById("pdianofim");
	var unicod = document.getElementById("unicod");
	var pdiEnsino = document.getElementById("pdiensino");
	var pdiPesquisa = document.getElementById("pdipesquisa");
	var pdiMetodo = document.getElementById("pdimetodo");
	if (isNaN(pdiAnoIni.value)) {
		alert("O campo ano de início do PDI deve ser preenchido corretamente.");
		pdiAnoIni.focus();
		return false;
	}
	if (isNaN(pdiAnoFim.value)) {
		alert("O campo ano de término do PDI deve ser preenchido corretamente.");
		pdiAnoFim.focus();
		return false;
	}
	if (pdiEnsino.value.length == 0) {
		alert("O campo Política de ensino do PDI deve ser preenchido corretamente.");
		pdiEnsino.focus();
		return false;
	}
	if (pdiPesquisa.value.length == 0) {
		alert("O campo Política de pesquisa do PDI deve ser preenchido corretamente.");
		pdiPesquisa.focus();
		return false;
	}
	if (pdiMetodo.value.length == 0) {
		alert("O campo Metodologia do PDI deve ser preenchido corretamente.");
		pdiMetodo.focus();
		return false;
	}
}

function submeterExclusao() {
	$
			.ajax({
				async : true,
				type : "POST",
				url : document.URL,
				data : {
					escolha : "sim"
				},
				success : function(result, status) {
					if (status == "success") {
						$(".container").html(result);
						$("#frm-escolha").hide();
					}
				},
				error : function(xhr, status, error) {
					alert("erro ao processar a requisição. \n Causa do erro: "
							+ error);
				}
			});
}

function negarExclusao() {
	location.href = "?pagina=pdi&opcao=consultar";
}