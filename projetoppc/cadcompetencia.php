<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cadastro de competência</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Cadastro de competências</h2>
		<br>
		<form action="competencia.php" method="post">
			<div class="form-group">
				<label for="selectppc">Selecione o curso para a competência: </label>
				<select class="form-control" id="selectppc" name="ppccod">
				<?php
				$usuario = "root";
				$senha = "";
				try {
					$con = new PDO ( "mysql:host=localhost;dbname=dbdep;charset=utf8", $usuario, $senha );
					$con->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
					$consultappc = $con->query ( "select * from ppc" );
					if ($consultappc->execute () && $consultappc->rowCount () > 0) {
						while ( $row = $consultappc->fetch ( PDO::FETCH_ASSOC ) ) {
							echo "<option value= '" . $row ['ppccod'] . "'>" . $row ['ppccurso'] . "</option>";
						}
					}
				} catch ( PDOException $e ) {
					echo $e->getMessage ();
				}
				?>
				</select>
			</div>
			<br>
			<div class="form-group">
				<label for="inputcompdes">Descrição da competência</label>
				<textarea rows="3" cols="3" class="form-control" id="inputcompdes"
					name="compdes"></textarea>
			</div>
			<br>
			<div class="form-group">
			<input type="submit" value="salvar">
			</div>
		</form>
	</div>
</body>
</html>