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

function formatarCampo() {
	var ppcObj = document.getElementById("ppcobj");
	var ppcDesc = document.getElementById("ppcdesc");
	var ppcEstagio = document.getElementById("ppcestagio");
	var contentPpcDesc = ppcDesc.innerHTML;
	var contentPpcObj = ppcObj.innerHTML;
	var contentPpcEstagio = ppcEstagio.innerHTML;
	if (contentPpcDesc.search(/\t+/g, 0) != -1) {
		contentPpcDesc = contentPpcDesc.replace(/\t+/g, "");
		ppcDesc.innerHTML = contentPpcDesc;
	}
	if (contentPpcObj.search(/\t+/g, 0) != -1) {
		contentPpcObj = contentPpcObj.replace(/\t+/g, "");
		ppcObj.innerHTML = contentPpcObj;
	}
	if (contentPpcEstagio.search(/\t+/g, 0) != -1) {
		contentPpcEstagio = contentPpcEstagio.replace(/\t+/g, "");
		ppcEstagio.innerHTML = contentPpcEstagio;
	}
}

function submeterExclusao() {
	$.ajax({
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
			alert("Erro ao processar a requisição.\n Causa do erro: " + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=ppc&opcao=consultar";
}