<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\eixoTecDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de eixos tecnológicos</title>
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
	<h2>Cadastro de eixos tecnológicos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixdesc">eixo tecnológico</label> <input type="text"
					id="eixdesc" name="eixdesc" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "eixdesc", $_POST ))
			return;
		try {
			if (inserirEixoTecnológico ( $_POST ["eixdesc"] )) {
				echo "<h1>Eixo tecnológico cadastrado com êxito!</h1><br>";
				echo "<a href= 'gerenciaEixoTec.php?opcao=consultar'>Clique aqui para consultar os eixos tecnológicos cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_GET ["opcao"] == "consultar") :
		$eixostec = buscarEixosTecnologicos ();
		$totaleixostec = count ( $eixostec );
		?>
	<h2>Consulta de eixos tecnológicos</h2>
		<br> <a href="gerenciaEixoTec.php?opcao=cadastrar">Novo eixo
			tecnológico</a><br>
	<?php
		if ($totaleixostec > 0) :
			?>
		<h2>Número de eixos tecnológicos encontrados: <?=$totaleixostec; ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Eixos Tecnológicos</caption>
			<thead>
				<tr>
					<th>Eixo Tecnológico</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ( $eixostec as $eixotec ) :
				?>
		<tr>
					<td><?=$eixotec["eixdesc"]; ?></td>
					<td><a
						href="gerenciaEixoTec.php?opcao=alterar&eixcod=<?=$eixotec['eixcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaEixoTec.php?opcao=excluir&eixcod=<?=$eixotec['eixcod']; ?>">Excluir
							eixo tecnológico</a></td>
				</tr>
		<?php
			endforeach
			;
			?>
		</tbody>
		</table>
		<?php
		else :
			?>
		<h1>Nenhum eixo tecnológico cadastrado no sistema.</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo tecnológico.</p>
		<br>
		<?php
		endif;
	endif;
	?>
	</div>
</body>
</html>