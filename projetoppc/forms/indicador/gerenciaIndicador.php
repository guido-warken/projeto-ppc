<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\indicadorDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de eixos temáticos</title>
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
	if ($_GET ["opcao"] == "cadastrar") :
		?>
	<h2>Cadastro de indicador</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="inddesc">Digite o indicador: </label>
				<textarea rows="3" cols="3" id="inddesc" name="inddesc"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "inddesc", $_POST ))
			return;
		try {
			if (inserirIndicador ( $_POST ["inddesc"] )) {
				echo "<h1>Indicador cadastrado com êxito</h1><br>";
				echo "<a href= 'gerenciaIndicador.php?opcao=consultar'>Clique aqui para consultar os indicadores</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	endif;
	
	?>
	</div>
</body>
</html>