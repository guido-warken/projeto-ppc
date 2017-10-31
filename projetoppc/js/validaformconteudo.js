/**
 * 
 */

function validarFormulario() {
	var contfase = document.getElementById("contfase");
	if (isNaN(contfase.value)) {
		alert("O campo fase da disciplina só pode ser preenchido com números.");
		contfase.focus();
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
	location.href = "?pagina=conteudo&opcao=consultar";
}
