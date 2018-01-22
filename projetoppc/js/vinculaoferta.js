var formulario = document.getElementById("frm-salvar");
formulario.addEventListener("change", function () {
    var ppccod = formulario.ppccod.value;
    var unicod = formulario.unicod.value;
    console.log(ppccod);
    console.log(unicod);
});