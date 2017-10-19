/**
 * 
 */
function validarFormulario() {
	var eixdesc = document.getElementById("eixdesc");
	if (eixdesc.value.length == 0) {
		alert("O campo eixo tecnológico deve ser preenchido corretamente.");
		eixdesc.focus();
		return false;
	}
	if (eixdesc.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo eixo tecnológico não pode conter números.");
		eixdesc.focus();
		return false;
	}
}

function formatarValor() {
	var eixdesc = document.getElementById("eixdesc");
	var contentEixdesc = eixdesc.value;
	eixdesc.value = contentEixdesc.toUpperCase();
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
	location.href = "?pagina=eixotec&opcao=consultar";
}