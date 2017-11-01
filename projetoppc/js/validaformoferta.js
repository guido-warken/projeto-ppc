/**
 * 
 */

function validarFormulario() {
	var ofecont = document.getElementById("ofecont");
	var ofeVagasMat = document.getElementById("ofevagasmat");
	var ofeVagasVesp = document.getElementById("ofevagasvesp");
	var ofeVagasNot = document.getElementById("ofevagasnot");
	if (ofecont.value.length == 0) {
		alert("O campo contexto educacional deve ser preenchido corretamente.");
		ofecont.focus();
		return false;
	}
	if (isNaN(ofeVagasMat.value)) {
		alert("O campo número de vagas matutinas deve conter apenas números.");
		ofeVagasMat.focus();
		return false;
	}
	if (isNaN(ofeVagasVesp.value)) {
		alert("O campo número de vagas vespertinas deve conter apenas números.");
		ofeVagasVesp.focus();
		return false;
	}
	if (isNaN(ofeVagasNot.value)) {
		alert("O campo número de vagas noturnas deve conter apenas números.");
		ofeVagasNot.focus();
		return false;
	}
}

function formatarCampo() {
	var ofecont = document.getElementById("ofecont");
	if (ofecont.value.search(/\t+/g, 0) != -1) {
		ofecont.value = ofecont.value.replace(/\t+/g, "");
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
		success : function(result, status, xhr) {
			if (status == "success") {
				$(".container").html(result);
				$("#frm-escolha").hide();
			}
		},
		error : function(xhr, status, error) {
			alert("Erro ao processar a requisição. \n Causa do erro: " + erro);
		}
	});

}

function negarExclusao() {
	location.href = "?pagina=oferta&opcao=consultar";
}
