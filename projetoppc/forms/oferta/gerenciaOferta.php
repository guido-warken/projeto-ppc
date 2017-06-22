<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\ofertaDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de ofertas de curso</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	<?php
	if ($_GET["opcao"] == "cadastrar"):
	?>
	<h2>Cadastro de oferta de curso</h2><br>
	<form action="" method="post">
	<div class="form-group">
	<?php
	$ppcs = buscarP
	?>
	</div>
	</form>
	</div>
</body>
</html>