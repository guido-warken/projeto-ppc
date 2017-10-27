/**
 * 
 */
function validarFormulario() {
	var compdes = document.getElementById("compdes");
	if (compdes.value.length == 0) {
		alert("O campo Competência deve ser preenchido corretamente.");
		compdes.focus();
		return false;
	}
	if (compdes.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo Competência não pode conter números.");
		compdes.value = compdes.value.replace(/[0-9]/g, "");
		compdes.focus();
		return false;
	}
}

function formatarCampo() {
	var compdes = document.getElementById("compdes");
	if (compdes.value.search(/\t+/g, 0) != -1) {
		compdes.value = compdes.value.replace(/\t+/g, "");
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
	location.href = "?pagina=competencia&opcao=consultar";
}