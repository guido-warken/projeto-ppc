$("#frm-vincular").change(exibirVinculo);

function exibirVinculo() {
    var ppccod = $("#ppccod").val();
    var discod = $("#discod").val();
    if (ppccod == "-1" && discod == "-1") {
        $("#atc-vinc").html("<span>Selecione um PPC e uma disciplina</span>");
    } else if (ppccod != "-1" && discod == "-1") {
        $("#atc-vinc").html("<span>Selecione uma disciplina</span>");
    } else if (ppccod == "-1" && discod != "-1") {
        $("#atc-vinc").html("<span>Selecione um PPC</span>");
    } else {
        listarAtividadesVinculadas(ppccod, discod);
    }
}

$("button").click(function (event) {
    event.preventDefault();
    if (event.target.id == "btn-sim") {
        submeterExclusao();
    } else {
        negarExclusao();
    }
});

function listarAtividadesVinculadas(ppccod = 0, discod = 0) {
    $.get("http://localhost/projetoppc/forms/vinculo/atcvinc.php", {
        ppccod: ppccod,
        discod: discod
    },
        function (resultado, status, xhr) {
            if (status == "success") {
                $("#atc-vinc").html(resultado);
            }
        });
}

function submeterExclusao() {
    $.ajax({
        type: "POST",
        url: document.URL,
        data: {
            escolha: "sim"
        },
        success: function (resultado, status, xhr) {
            if (status == "success") {
                $(".container").html(resultado);
                $("#frm-escolha").hide();
            }
        },
        error: function (xhr, status, error) {
            alert("Falha ao processar a requisição. Causa do erro:" + error);
        }
    });
}

function negarExclusao() {
    location.href = "?pagina=vinculo3&opcao=cadastrar";
}

