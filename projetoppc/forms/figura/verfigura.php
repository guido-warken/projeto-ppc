<?php
require_once 'c:\wamp64\www\projetoppc\dao\figuradao.php';
$figcod = $_GET["figcod"];
$imagem = buscarFiguraPorId($figcod);
header("Content-Type: image/jpg | image/png");
echo $imagem["figcont"];