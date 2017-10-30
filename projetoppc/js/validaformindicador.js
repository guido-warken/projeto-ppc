/**
 * 
 */

function validarFormulario() {
	var inddesc = document.getElementById("inddesc");
	if (inddesc.value.length == 0) {
		alert("O campo de Indicador deve ser preenchido corretamente.");
		inddesc.focus();
		return false;
	}
	if (inddesc.value.search(/[0-9]/g, 0) != -1) {
		alert("o campo de Indicador não pode conter caracteres numéricos.");
		inddesc.value = inddesc.value.replace(/[0-9]/g, "");
		inddesc.focus();
		return false;
	}
}

function formatarCampo() {
	var inddesc = document.getElementById("inddesc");
	if (inddesc.value.search(/\t+/g, 0) != -1) {
		inddesc.value = inddesc.value.replace(/\t+/g, "");
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
	location.href = "?pagina=indicador&opcao=consultar";
}
