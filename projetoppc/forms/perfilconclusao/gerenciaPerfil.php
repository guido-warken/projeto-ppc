<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\perfilConclusaoDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\ppcDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\competenciaDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de conteÃºdo curricular</title>
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
		$ppcs = buscarPpcs ();
		$competencias = buscarCompetencias ();
		?>
	<h2>Cadastro de perfil de conclusão</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
		$totalppcs = count ( $ppcs );
		if ($totalppcs > 0) :
			?>
	<label for="ppccod">Selecione o PPC: </label> <select
					class="form-control" id="ppccod" name="ppccod">
	<?php
			foreach ( $ppcs as $ppc ) :
				?>
	<option value="<?=$ppc['ppccod']; ?>">
	<?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?>
	</option>
	<?php
			endforeach
			;
			?>
	</select>
	<?php
		else :
			?>
	<h1>Nenhum ppc cadastrado no sistema</h1>
				<br> <a href="../ppc/gerenciaPpc.php?opcao=cadastrar">Clique aqui
					para cadastrar um novo ppc</a><br>
					<?php
		endif;
		?>
			</div>
			<br>
			<div class="form-group">
	<?php
		$totalcompetencias = count ( $competencias );
		if ($totalcompetencias > 0) :
			?>
	<label for="compcod">Selecione a competência: </label> <select
					class="form-control" id="compcod" name="compcod">
	<?php
			foreach ( $competencias as $competencia ) :
				?>
	<option value="<?=$competencia['compcod']; ?>">
	<?=$competencia["compdes"]; ?>
	</option>
	<?php
			endforeach
			;
			?>
	</select>
	<?php
		else :
			?>
	<h1>Nenhuma competência cadastrada no sistema</h1>
				<br> <a
					href="../competencia/gerenciaCompetencia.php?opcao=cadastrar">Clique
					aqui para cadastrar uma nova competência</a><br>
					<?php
		endif;
		?>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="enviar" class="btn btn-success">
			</div>
			<br>
		</form>
		<?php
		if (! array_key_exists ( "ppccod", $_POST ) && ! array_key_exists ( "compcod", $_POST ))
			return;
		try {
			if (inserirPerfilConclusao ( $_POST ["ppccod"], $_POST ["compcod"] )) {
				echo "<h1>Perfil de Conclusão cadastrado com êxito</h1><br>";
				echo "<a href= 'gerenciaPerfil.php?opcao=consultar'>Clique aqui para consultar os perfis de conclusão cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
		endif;
	
	?>
	</div>
</body>
</html>