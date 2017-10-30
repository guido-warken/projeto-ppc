/**
 * 
 */

function validarFormulario() {
	var cerdes = document.getElementById("cerdes");
	var cerreq = document.getElementById("cerreq");
	var cerch = document.getElementById("cerch");
	if (cerdes.value.length == 0) {
		alert("O campo Descrição da Certificação deve ser preenchido corretamente");
		cerdes.focus();
		return false;
	}
	if (cerreq.value.length == 0) {
		alert("O campo Requisitos da Certificação deve ser preenchido corretamente");
		cerreq.focus();
		return false;
	}
	if (isNaN(cerch.value)) {
		alert("O campo Carga horária da certificação deve ser preenchido corretamente");
		cerch.focus();
		return false;
	}
}

function formatarCampo() {
	var cerdes = document.getElementById("cerdes");
	var cerreq = document.getElementById("cerreq");
	if (cerdes.value.search(/\t+/g, 0) != -1) {
		cerdes.value = cerdes.value.replace(/\t+/g, "");
	}
	if (cerreq.value.search(/\t+/g, 0) != -1) {
		cerreq.value = cerreq.value.replace(/\t+/g, "");
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
				success : function(result, status, xhr) {
					if (status == "success") {
						$(".container").html(result);
						$("#frm-escolha").hide();
					}
				},
				error : function(xhr, status, error) {
					alert("Erro ao processar a requisição. \n Causa do erro: "
							+ error);
				}
			});
}

function negarExclusao() {
	location.href = "?pagina=certificacao&opcao=consultar";
}
