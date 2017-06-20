<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\competenciaDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de competências</title>
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
		<h2>Cadastro de competências</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="compdes">Competência: </label>
				<textarea rows="3" cols="3" id="compdes" name="compdes"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "compdes", $_POST ))
			return;
		try {
			if (inserirCompetencia ( $_POST ["compdes"] )) {
				echo "<h1>Competência cadastrada com êxito!</h1><br>";
				echo "<a href= 'gerenciaCompetencia.php?opcao=consultar'>Clique aqui para consultar as competências cadastradas</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	endif;
	
	?>
	</div>
</body>
</html>