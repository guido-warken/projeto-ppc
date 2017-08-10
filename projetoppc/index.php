<?php
$pagina = isset($_GET["pagina"])? $_GET["pagina"]: "";
require 'lib/funcs.php';
require 'paginas/header.php';
rotas($pagina);
require 'paginas/footer.php';
?>