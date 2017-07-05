<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\eixoTematicoDao.php';
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
	<h2>Cadastro de eixos temáticos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixtdes">Eixo temático: </label> <input type="text"
					name="eixtdes" id="eixtdes" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "eixtdes", $_POST ))
			return;
		try {
			if (inserirEixoTematico ( $_POST ["eixtdes"] )) {
				echo "<h1>Eixo Temático cadastrado com êxito!</h1><br>";
				echo "<a href= 'gerenciaEixoTematico.php?opcao=consultar'>Clique aqui para consultar os eixos temáticos cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_get ["opcao"] == "consultar") :
		$eixostematicos = buscarEixos ();
		?>
	<h2>Consultando os eixos temáticos</h2>
		<br> <a href="gerenciaEixoTematico.php?opcao=cadastrar">Novo eixo
			temático</a><br>
	<?php
		if (count ( $eixostematicos ) > 0) :
			?>
	<h2>Número de eixos temáticos encontrados: <?=count($eixostematicos); ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Eixos Temáticos</caption>
			<thead>
				<tr>
					<th>Eixo Temático</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
			foreach ( $eixostematicos as $eixo ) :
				?>
	<tr>
					<td><?=$eixo["eixtdes"]; ?></td>
					<td><a
						href="gerenciaEixoTematico.php?opcao=alterar&eixtcod=<?=$eixo['eixtcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaEixoTematico.php?opcao=excluir&eixtcod=<?=$eixo['eixtcod']; ?>">Excluir
							eixo temático</a></td>
				</tr>
	<?php
			endforeach
			;
			?>
	</tbody>
		</table>
	<?php
		 elseif (count ( $eixostematicos ) == 0) :
			?>
	<h1>Nenhum eixo temático cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo temático</p>
		<br>
	<?php
	endif;
	endif;
	?>
	</div>
</body>
</html>