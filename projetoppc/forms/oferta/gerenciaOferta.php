<?php
require_once 'c:\xampp\htdocs\projetoppc\dao\ofertaDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\ppcDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\unidadeDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de ofertas de curso</title>
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
	<h2>Cadastro de oferta de curso</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
		$ppcs = buscarPpcs ();
		$unidades = buscarUnidadesPorPdi ();
		if (count ( $ppcs ) > 0) :
			?>
		<label for="ppccod">Selecione o ppc: </label> <select
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
		 elseif (count ( $ppcs ) == 0) :
			?>
		<h1>Nenhum ppcCadastrado</h1>
				<br> <a href="../ppc/gerenciaPpc.php?opcao=cadastrar">Clique aqui
					para cadastrar um novo Ppc</a><br>
		<?php
		endif;
		?>
	</div>
			<br>
			<div class="form-group">
	<?php
		if (count ( $unidades ) > 0) :
			?>
	<label>Selecione a unidade SENAC de oferta: </label> <select
					class="form-control" id="unicod" name="unicod">
	<?php
			foreach ( $unidades as $unidade ) :
				?>
	<option value="<?=$unidade['unicod']; ?>">
	<?=$unidade["uninome"]; ?>
	</option>
	<?php
			endforeach
			;
			?>
	</select>
	<?php
		 elseif (count ( $unidades ) == 0) :
			?>
	<h1>Nenhuma unidade SENAC cadastrada</h1>
				<br> <a href="../unidade/gerenciaUnidade.php?opcao=cadastrar">Clique
					aqui para cadastrar uma nova unidade SENAC</a><br>
	<?php
		endif;
		?>
	</div>
			<br>
			<div class="form-group">
				<label for="ofecont">Contexto educacional</label>
				<textarea rows="3" cols="3" id="ofecont" name="ofecont"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasmat">Número de vagas matutinas: </label> <input
					type="number" id="ofevagasmat" name="ofevagasmat"
					class="form-control">
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasvesp">Número de vagas vespertinas: </label> <input
					type="number" id="ofevagasvesp" name="ofevagasvesp"
					class="form-control">
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasnot">Número de vagas noturnas: </label> <input
					type="number" id="ofevagasnot" name="ofevagasnot"
					class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "ppccod", $_POST ) && ! array_key_exists ( "unicod", $_POST ) && ! array_key_exists ( "ofecont", $_POST ) && ! array_key_exists ( "ofevagasmat", $_POST ) && ! array_key_exists ( "ofevagasvesp", $_POST ) && ! array_key_exists ( "ofevagasnot", $_POST ))
			return;
		try {
			if (inserirOferta ( $_POST ["ppccod"], $_POST ["unicod"], $_POST ["ofecont"], $_POST ["ofevagasmat"], $_POST ["ofevagasvesp"], $_POST ["ofevagasnot"] )) {
				echo "<h1>Oferta cadastrada com êxito!</h1><br>";
				echo "<a href = 'gerenciaOferta.php?opcao=consultar'>Clique aqui para ver as ofertas de curso cadastradas</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_GET ["opcao"] == "consultar") :
		$ppcs = buscarPpcsPorOferta ();
		$unidades = buscarUnidadesPorOferta ();
		?>
	<h2>Consulta de oferta</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
		if (count ( $ppcs ) > 0) :
			?>
	<label for="ppccod">Selecione o ppc: </label> <select
					class="form-control" name="ppccod" id="ppccod">
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
		 elseif (count ( $ppcs ) == 0) :
			?>
	<h1>Nenhuma oferta cadastrada e vinculada com nenhum ppc do sistema</h1>
				<br> <a href="gerenciaOferta.php?opcao=cadastrar">Cadastrar uma nova
					oferta</a><br>
	<?php
		endif;
		?>
	</div>
			<br>
			<div class="form-group">
	<?php
		if (count ( $unidades ) > 0) :
			?>
	<label for="unicod">Selecione a unidade SENAC: </label> <select
					class="form-control" name="unicod" id="unicod">
	<?php
			foreach ( $unidades as $unidade ) :
				?>
	<option value="<?=$unidade['unicod']; ?>">
	<?=$unidade["uninome"]; ?> 
	</option>
	<?php
			endforeach
			;
			?>
	</select>
	<?php
		 elseif (count ( $unidades ) == 0) :
			?>
	<h1>Nenhuma oferta cadastrada e vinculada com as unidades SENAC do
					sistema</h1>
				<br> <a href="gerenciaOferta.php?opcao=cadastrar">Cadastrar uma nova
					oferta</a><br>
	<?php
		endif;
		?>
	</div>
			<br>
			<div class="form-group">
				<input type="submit" value="enviar">
			</div>
			<br>
		</form>
	<?php
		if (! array_key_exists ( "ppccod", $_POST ) && ! array_key_exists ( "unicod", $_POST ))
			return;
		$ofertas = buscarOfertas ( $_POST ["ppccod"], $_POST ["unicod"] );
		?>
	<table class="table table-bordered">
			<thead>
				<tr>
					<th>Contexto educacional</th>
					<th>Número de vagas matutinas</th>
					<th>Número de vagas vespertinas</th>
					<th>Número de vagas noturnas</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ( $ofertas as $oferta ) :
			?>
	<tr>
					<td><?=$oferta["ofecont"]; ?></td>
					<td><?=$oferta["ofevagasmat"]; ?></td>
					<td><?=$oferta["ofevagasvesp"]; ?></td>
					<td><?=$oferta["ofevagasnot"]; ?></td>
					<td><a
						href="gerenciaOferta.php?opcao=alterar&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaOferta.php?opcao=excluir&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">excluir
							oferta</a></td>
				</tr>
	<?php
	endforeach;
	?>
	</tbody>
		</table>
	<?php
	endif;
	?>
	</div>
</body>
</html>