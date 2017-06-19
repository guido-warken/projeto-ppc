<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Alteração de competência</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Alteração de Competência</h2>
		<br>
	<?php
	$usuario = "root";
	$senha = "";
	$row = null;
	try {
		$con = new PDO ( "mysql:host=localhost;dbname=dbdep;charset=utf8", $usuario, $senha );
		$con->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$consultacomp = $con->prepare ( "select competencia.*, perfilconclusao.* from competencia inner join perfilconclusao on competencia.compcod = perfilconclusao.compcod where competencia.compcod = :compcod" );
		$consultacomp->bindParam ( ":compcod", $compcod );
		$compcod = $_GET ['compcod'];
		if ($consultacomp->execute () && $consultacomp->rowCount () > 0) {
			$row = $consultacomp->fetch ( PDO::FETCH_ASSOC );
		}
	} catch ( PDOException $e ) {
		echo $e->getMessage ();
	}
	?>
		
		<form action="competenciaalterada.php" method="post">
			<div class="form-group">
				<label for="selectppc">Selecione o curso para a competência: </label>
				<select class="form-control" id="selectppc" name="ppccod">
				<?php
				$consultappc = $con->prepare ( "select * from ppc where ppc.ppccod = :ppccod" );
				$consultappc->bindParam ( ":ppccod", $row ['ppccod'] );
				if ($consultappc->execute () && $consultappc->rowCount () > 0) {
					$opcao = $consultappc->fetch ( PDO::FETCH_ASSOC );
					echo "<option value= '" . $opcao ['ppccod'] . "' selected = 'selected'>" . $opcao ['ppccurso'] . "</option>";
				}
				$consultappc = $con->prepare ( "select * from ppc where ppc.ppccod <> :ppccod" );
				$consultappc->bindParam ( ":ppccod", $row ['ppccod'] );
				if ($consultappc->execute () && $consultappc->rowCount () > 0) {
					while ( $opcao = $consultappc->fetch ( PDO::FETCH_ASSOC ) ) {
						echo "<option value= '" . $opcao ['ppccod'] . "'>" . $opcao ['ppccurso'] . "</option>";
					}
				}
				?>
				</select>
			</div>
			<br>
			<div class="form-group">
				<label for="inputcompdes">Descrição da competência</label>
				<textarea rows="3" cols="3" class="form-control" id="inputcompdes"
					name="compdes">
					<?php echo $row['compdes'];?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
			<input type="submit" value="alterar">
			</div>
		</form>
	</div>
</body>
</html>