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
	<?php
	$usuario = "root";
	$senha = "";
	$compcod = null;
	try {
		$con = new PDO("mysql:host=localhost;dbname=dbdep;charset=utf8", $usuario, $senha);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$insersaocomp = $con->prepare("insert into competencia (compdes) values (:compdes)");
		$insersaocomp->bindParam(":compdes", $compdes);
		$compdes = $_POST['compdes'];
		if ($insersaocomp->execute() ) {
			$consultacomp = $con->query("select max(competencia.compcod) from competencia");
			if ($consultacomp->execute() && $consultacomp->rowCount() > 0) {
				$compcod = $consultacomp->fetch(PDO::FETCH_BOTH);
			}
			$insersaoppccod = $con->prepare("insert into perfilconclusao (ppccod, compcod) values (:ppccod, :compcod)");
			$insersaoppccod->bindParam(":ppccod", $ppccod);
			$insersaoppccod->bindParam(":compcod", $compcod[0]);
			$ppccod = $_POST['ppccod'];
			if ($insersaoppccod->execute()) {
				echo "<h1>Competência cadastrada com êxito!</h1><br>";
				echo "<a href= 'consultacompetencia.php'>Clique aqui para visualizar as competências cadastradas</a>";
			}
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	?>
	</div>
		</body>
	</html>