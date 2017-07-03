<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\disciplinaDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de disciplinas</title>
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
	<h2>Cadastro de disciplinas</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="disnome">Nome da disciplina: </label> <input type="text"
					class="form-control" id="disnome" name="disnome">
			</div>
			<br>
			<div class="form-group">
				<label for="disobj">Objetivos da disciplina: </label>
				<textarea rows="3" cols="3" id="disobj" name="disobj"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="disch">Carga horária da disciplina: </label> <input
					type="number" id="disch" name="disch" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="discementa">Ementa da disciplina: </label>
				<textarea rows="3" cols="3" id="discementa" name="discementa"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="form-control" value="salvar">
			</div>
			<br>
		</form>
<?php
		if (! array_key_exists ( "disnome", $_POST ) && ! array_key_exists ( "disobj", $_POST ) && ! array_key_exists ( "disch", $_POST ) && ! array_key_exists ( "discementa", $_POST ))
			return;
		try {
			if (inserirDisciplina ( $_POST ["disnome"], $_POST ["disobj"], $_POST ["disch"], $_POST ["discementa"] )) {
				echo "<h1>Disciplina cadastrada com êxito!</h1><br>";
				echo "<a href= 'gerenciaDisciplina.php?opcao=consultar'>Clique aqui para consultar as disciplinas cadastradas</a><br>";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}
endif;
?>
	</div>
</body>
</html>