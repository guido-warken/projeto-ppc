<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\certificacaoDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de certificações</title>
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
	<h2>Cadastro de certificação</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="cerdes">Descritivo da certificação: </label> <input
					type="text" id="cerdes" name="cerdes" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="cerreq">Requisitos da certificação: </label>
				<textarea rows="3" cols="3" id="cerreq" name="cerreq"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="cerch">Carga horária da certificação: </label> <input
					type="number" id="cerch" name="cerch" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "cerdes", $_POST ) && ! array_key_exists ( "cerreq", $_POST ) && ! array_key_exists ( "cerch", $_POST ))
			return;
		try {
			if (inserirCertificacao ( $_POST ["cerdes"], $_POST ["cerreq"], $_POST ["cerch"] )) {
				echo "<h1>Certificação cadastrada com êxito!</h1><br>";
				echo "<a href= 'gerenciaCertificacao.php?opcao=consultar'>Clique aqui para consultar as certificações cadastradas</a>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_GET ["opcao"] == "consultar") :
		$certificacoes = buscarCert ();
		$totalcerts = count ( $certificacoes );
		?>
	<h2>Consulta de certificações</h2>
		<br> <a href="gerenciacertificacao.php?opcao=cadastrar">Nova
			certificação</a><br>
	<?php
		if ($totalcerts > 0) :
			?>
	<h2>Número de certificações encontradas: <?=$totalcerts; ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Certificações</caption>
			<thead>
				<tr>
					<th>Descritivo da certificação</th>
					<th>Requisitos da certificação</th>
					<th>Carga horária da certificação</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
			foreach ( $certificacoes as $certificacao ) :
				?>
	<tr>
					<td><?=$certificacao["cerdes"]; ?></td>
					<td><?=$certificacao["cerreq"]; ?></td>
					<td><?=$certificacao["cerch"]; ?> horas </td>
					<td><a
						href="gerenciaCertificacao.php?opcao=alterar&cercod=<?=$certificacao['cercod']; ?>">Alterar
							dados </a></td>
					<td><a
						href="gerenciaCertificacao.php?opcao=excluir&cercod=<?=$certificacao['cercod']; ?>">Excluir
							certificação </a></td>
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
	<h1>Nenhuma certificação cadastrada no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova certificação</p>
		<br>
	<?php
		endif;
	endif;
	?>
	</div>
</body>
</html>