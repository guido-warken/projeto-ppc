$("#frm-salvar").submit(validarFormulario);
$("#frm-alterar").submit(validarFormulario);
$("#frm-alterar").find("#curtit").focus(formatarCampo);
$("#btn-sim").click(submeterExclusao);
$("#btn-nao").click(negarExclusao);

function validarFormulario(event) {
	event.preventDefault();
	var curnome = $("#curnome").val();
	var curtit = $("#curtit").val();
	var eixcod = $("#eixcod").val();
	if (curnome.length == 0) {
		alert("O campo nome do curso deve ser preenchido corretamente.");
		$("#curnome").focus();
		return;
	}
	if (curtit.length == 0) {
		alert("O campo titulação do curso deve ser preenchido corretamente.");
		$("#curtit").focus();
		return;
	}
	if (eixcod == "-1") {
		alert("Por favor, selecione um eixo tecnológico.");
		$("#eixcod").focus();
		return;
	}
	submeterFormulario(curnome, curtit, eixcod, event.target.id);
}

function formatarCampo() {
	var conteudoCurtit = $("#curtit").val();
	if (conteudoCurtit.search(/\t+/g, 0) != -1) {
		conteudoCurtit = conteudoCurtit.replace(/\t+/g, "");
		$("#curtit").val(conteudoCurtit);
	}
}

function submeterExclusao(event) {
	event.preventDefault();
	$.ajax({
		async: true,
		type: "POST",
		url: document.URL,
		data: {
			escolha: "sim"
		},
		success: function (result, status) {
			if (status == "success") {
				$(".container").html(result);
				$("#frm-escolha").hide();
			}
		},
		error: function (xhr, status, error) {
			alert("Erro ao processar a requisição.\n Causa do erro: " + error);
		}
	});
}

function negarExclusao(event) {
	event.preventDefault();
	location.href = "?pagina=curso&opcao=consultar";
}

function submeterFormulario(curnome = "", curtit = "", eixcod = 0, idFormulario = "") {
	if (idFormulario == "frm-salvar") {
		$.post(document.URL, {
			curnome: curnome,
			curtit: curtit,
			eixcod: eixcod,
			bt_form_salvar: 1
		},
			function (resultado, status, xhr) {
				if (status == "success") {
					$(".container").html(resultado);
				}
			});
	} else {
		$.post(document.URL, {
			curnome: curnome,
			curtit: curtit,
			eixcod: eixcod,
			bt_form_alterar: 1
		},
			function (resultado, status, xhr) {
				if (status == "success") {
					$(".container").html(resultado);
					$("#curnome").val("");
					$("#curtit").val("");
				}
			});
	}
}

