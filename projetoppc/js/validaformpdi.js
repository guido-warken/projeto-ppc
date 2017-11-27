/**
 * 
 */
function validarFormulario() {
	var pdiAnoIni = document.getElementById("pdianoini");
	var pdiAnoFim = document.getElementById("pdianofim");
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

function formatarCampo() {
	var pdiEnsino = document.getElementById("pdiensino");
	var pdiPesquisa = document.getElementById("pdipesquisa");
	var pdiMetodo = document.getElementById("pdimetodo");
	var contentPdiEnsino = pdiEnsino.value;
	var contentPdiPesquisa = pdiPesquisa.value;
	var contentPdiMetodo = pdiMetodo.value;
	if (contentPdiEnsino.search(/\t+/g, 0) != -1) {
		contentPdiEnsino = contentPdiEnsino.replace(/\t+/g, "");
		pdiEnsino.value = contentPdiEnsino;
	}
	if (contentPdiPesquisa.search(/\t+/g, 0) != -1) {
		contentPdiPesquisa = contentPdiPesquisa.replace(/\t+/g, "");
		pdiPesquisa.value = contentPdiPesquisa;
	}
	if (contentPdiMetodo.search(/\t+/g, 0) != -1) {
		contentPdiMetodo = contentPdiMetodo.replace(/\t+/g, "");
		pdiMetodo.value = contentPdiMetodo;
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