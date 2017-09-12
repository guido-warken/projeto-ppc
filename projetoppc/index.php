<?php
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : "";
$opcao = isset($_GET["opcao"]) ? $_GET["opcao"] : "";
require 'lib/funcs.php';
require 'paginas/header.php';
require 'paginas/menu.php';
rotas($pagina);
require 'paginas/footer.php';
?>