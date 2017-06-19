<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Consulta de competência</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Consulta de competências</h2>
		<br>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div class="form-group">
				<label for="selectppc">Selecione o curso para visualizar as
					competências: </label> <select id="selectppc" name="ppccod"
					class="form-control">
	<?php
	$usuario = "root";
	$senha = "";
	try {
		$con = new PDO ( "mysql:host=localhost;dbname=dbdep;charset=utf8", $usuario, $senha );
		$con->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$consultappc = $con->query ( "select * from ppc inner join perfilconclusao on ppc.ppccod = perfilconclusao.ppccod" );
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
				<input type="submit" value="enviar">
			</div>
			<br>
		</form>
		<?php
		if ( array_key_exists ( "ppccod", $_POST )) {
			$usuario = "root";
			$senha = "";
			try {
				$con = new PDO("mysql:host=localhost;dbname=dbdep;charset=utf8", $usuario, $senha);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$consultacomp = $con->prepare("select * from competencia inner join perfilconclusao on competencia.compcod = perfilconclusao.compcod inner join ppc on perfilconclusao.ppccod = ppc.ppccod where ppc.ppccod = :ppccod");
				$consultacomp->bindParam(":ppccod", $ppccod);
				$ppccod = $_POST['ppccod'];
				if ($consultacomp->execute() && $consultacomp->rowCount() > 0) {
					echo "<h1>Número de competências encontradas: ". $consultacomp->rowCount(). "</h1><br>";
					echo "<table class= 'table table-bordered'>";
					echo "<thead>";
					echo "<th>Descrição da competencia</th>";
					echo "<th colspan= '2'>Ação</th>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $consultacomp->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr>";
						echo "<td>". $row['compdes']. "</td>";
						echo "<td>";
						echo "<a href= 'alterarcompetencia.php?compcod=". $row['compcod']. "'>alterar</a>";
						echo "</td>";
						echo "<td>";
						echo "<a href= 'confirmaexclusaocompetencia.php?compcod=". $row['compcod']. "'>excluir</a>";
						echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		} 
				?>
	</div>
</body>
</html>