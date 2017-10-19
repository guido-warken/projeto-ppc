/**
 * 
 */
function validarFormulario() {
	var eixtdes = document.getElementById("eixtdes");
	if (eixtdes.value.length == 0) {
		alert("O campo eixo temático deve ser preenchido corretamente.");
		eixtdes.focus();
		return false;
	}
	if (eixtdes.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo eixo temático não pode conter números.");
		eixtdes.focus();
		return false;
	}
}

function formatarValor() {
	var eixtdes = document.getElementById("eixtdes");
	var contenteixtdes = eixtdes.value;
	for (var i = 0; i < contenteixtdes.length; i++) {
		if (i == 0) {
			contenteixtdes = contenteixtdes.replace(contenteixtdes.charAt(i),
					contenteixtdes.charAt(i).toUpperCase());
			continue;
		}
		contenteixtdes = contenteixtdes.replace(contenteixtdes.charAt(i),
				contenteixtdes.charAt(i).toLowerCase());
	}
	eixtdes.value = contenteixtdes;
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
					alert("Não foi possível completar a ação de excluir o eixo tecnológico.\n Causa do erro: "
							+ error);
				}
			});
}

function negarExclusao() {
	location.href = "?pagina=eixotem&opcao=consultar";
}