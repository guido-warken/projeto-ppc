var formulario = document.getElementById("frm-salvar");
formulario.addEventListener("change", event => {
    if (event.target.id == "nivcod") {
        return;
    }
    var ppccod = formulario.ppccod.value;
    var unicod = formulario.unicod.value;
    var divNivelamentosVinculados = document.getElementById("nivelamentos-vinculados");
    var divNivelamentosNaoVinculados = document.getElementById("nivelamentos-nao-vinculados");
    if (ppccod == "-1" && unicod == "-1") {
        divNivelamentosVinculados.innerHTML = "<span>Selecione um PPC e uma unidade do SENAC</span>";
    } else if (ppccod != "-1" && unicod == "-1") {
        divNivelamentosVinculados.innerHTML = "<span>Selecione uma unidade do SENAC</span>";
    } else if (ppccod == "-1" && unicod != "-1") {
        divNivelamentosVinculados.innerHTML = "<span>Selecione um PPC</span>";
    } else {
        listarNivelamentosVinculados(ppccod, unicod, divNivelamentosVinculados);
        listarNivelamentosNaoVinculados(ppccod, unicod, divNivelamentosNaoVinculados);
    }
});

function listarNivelamentosVinculados(ppccod = 0, unicod = 0, element) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/projetoppc/forms/vinculo/ofevinc.php?ppccod=" + ppccod + "&unicod=" + unicod);
    xhr.addEventListener("load", function () {
        if (this.status == 200) {
            element.innerHTML = this.responseText;
        } else {
            element.innerHTML = "<span>Falha na requisição</span>";
            console.log(this.responseText);
        }
    });
    xhr.send();
}

function listarNivelamentosNaoVinculados(ppccod = 0, unicod = 0, element) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/projetoppc/forms/vinculo/ofenvinc.php?ppccod=" + ppccod + "&unicod=" + unicod);
    xhr.addEventListener("load", function () {
        if (this.status == 200) {
            element.innerHTML = this.responseText;
        } else {
            element.innerHTML = "<span>Falha na requisição</span>";
            console.log(this.responseText);
        }
    });
    xhr.send();
}