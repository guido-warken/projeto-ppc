/**
 * 
 */

function exibirVinculo() {
	var ppccod = document.getElementById("ppccod");
	var discod = document.getElementById("discod");
	var atccod = document.getElementById("discod");
	if (ppccod.value == "-1" && discod.value != "-1") {
		alert("Por favor, selecione um PPC.");
		$("#atc-vinc").html(null);
		ppccod.focus();
		return;
	}
	if (discod.value == "-1" && ppccod.value != "-1") {
		alert("Por favor, selecione uma disciplina.");
		$("#atc-vinc").html(null);
		discod.focus();
		return;
	}
	if (ppccod.value == "-1" && discod.value == "-1" && atccod.value == "-1") {
		$("#atc-vinc").html(null);
		return;
	}
	$.get("http://localhost/projetoppc/forms/vinculo/atcvinc.php", {
		ppccod : $("#ppccod").val(),
		discod : $("#discod").val()
	}, function(result, status, xhr) {
		if (status == "success") {
			$("#atc-vinc").html(result);
		}
	});
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