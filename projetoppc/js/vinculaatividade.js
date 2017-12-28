/**
 * 
 */

function exibirVinculo() {
	var ppccod = document.getElementById("ppccod");
	var discod = document.getElementById("discod");
	if (ppccod.value != "-1" && discod.value != "-1") {
		$.get("http://localhost/projetoppc/forms/vinculo/atcvinc.php", {
			ppccod : $("#ppccod").val(),
			discod : $("#discod").val()
		}, function(result, status, xhr) {
			if (status == "success") {
				$("#atc-vinc").html(result);
			}
		});
	} else {
		$("#atc-vinc").html(null);
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
			alert("Não foi possível executar a requisição." + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=vinculo3&opcao=cadastrar";
}