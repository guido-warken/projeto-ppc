<?php
require_once 'c:\wamp64\www\projetoppc\dao\ofertaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
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
<script src="../../js/filtro.js"></script>
</head>
<body>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de oferta de curso</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    $ppcs = buscarPpcs();
    $unidades = buscarUnidades();
    if (count($ppcs) > 0) :
        ?>
		<label for="ppccod">Selecione o ppc: </label> <select
					class="form-control" id="ppccod" name="ppccod">
		<?php
        foreach ($ppcs as $ppc) :
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
     elseif (count($ppcs) == 0) :
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
    if (count($unidades) > 0) :
        ?>
	<label>Selecione a unidade SENAC de oferta: </label> <select
					class="form-control" id="unicod" name="unicod">
	<?php
        foreach ($unidades as $unidade) :
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
     elseif (count($unidades) == 0) :
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
			<div class="form-group">
				<label for="ofevagasmat">Número de vagas matutinas: </label> <input
					type="number" id="ofevagasmat" name="ofevagasmat"
					class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="ofevagasvesp">Número de vagas vespertinas: </label> <input
					type="number" id="ofevagasvesp" name="ofevagasvesp"
					class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="ofevagasnot">Número de vagas noturnas: </label> <input
					type="number" id="ofevagasnot" name="ofevagasnot"
					class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("unicod", $_POST) && ! array_key_exists("ofecont", $_POST) && ! array_key_exists("ofevagasmat", $_POST) && ! array_key_exists("ofevagasvesp", $_POST) && ! array_key_exists("ofevagasnot", $_POST))
        return;
    try {
        if (inserirOferta($_POST["ppccod"], $_POST["unicod"], $_POST["ofecont"], $_POST["ofevagasmat"], $_POST["ofevagasvesp"], $_POST["ofevagasnot"])) {
            echo "<h1>Oferta cadastrada com êxito!</h1><br>";
            echo "<a href = 'gerenciaOferta.php?opcao=consultar'>Clique aqui para ver as ofertas de curso cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $unidades = buscarUnidades();
    ?>
	<h2>Consulta de oferta</h2>
		<br> <a href="gerenciaOferta.php?opcao=cadastrar">Nova oferta</a><br>
		<form action="" method="post">
			<div class="form-group">
				<label>Selecione a opção: </label><br> <label class="label-check">Listar
					unidades SENAC por ppc: <input type="radio" name="escolha"
					class="form-check" value="ppc" id="opt1"
					onclick="gerenciarFiltro()">
				</label><br> <label class="label-check">Listar ppcs por unidades SENAC:
					<input type="radio" name="escolha" class="form-check"
					value="unidade" id="opt2" onclick="gerenciarFiltro()">
				</label>
			</div>
			<br>
			<div class="form-group" id="div-ppc">
	<?php
    if (count($ppcs) > 0) :
        ?>
	<label for="ppccod">Selecione o ppc: </label> <select
					class="form-control" name="ppccod" id="ppccod">
					<option value="selecione">selecione</option>
	<?php
        foreach ($ppcs as $ppc) :
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
     elseif (count($ppcs) == 0) :
        ?>
	<h1>Nenhum ppc cadastrado no sistema</h1>
				<br> <a href="../ppc/gerenciaPpc.php?opcao=cadastrar">Cadastrar um novo
					ppc</a><br>
	<?php
    endif;
    ?>
	</div>
			<br>
			<div class="form-group" id="div-unidade">
	<?php
    if (count($unidades) > 0) :
        ?>
	<label for="unicod">Selecione a unidade SENAC: </label> <select
					class="form-control" name="unicod" id="unicod">
					<option value="selecione">selecione</option>
	<?php
        foreach ($unidades as $unidade) :
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
     elseif (count($unidades) == 0) :
        ?>
	<h1>Nenhuma unidade SENAC cadastrada no
					sistema</h1>
				<br> <a href="../unidade/gerenciaUnidade.php?opcao=cadastrar">Cadastrar uma nova
					unidade SENAC</a><br>
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
    if (! array_key_exists("escolha", $_POST))
        return;
    $opcao = $_POST["escolha"];
    $ofertas = [];
    if ($opcao == "ppc"):
        $ofertas = buscarOfertasPorPpc($_POST["ppccod"]);
    $ppc = buscarPpcPorId($_POST["ppccod"]);
    $totalofertas = count($ofertas);
    if ($totalofertas > 0):
    ?>
    <h2>Número de unidades que o fertam este ppc: <?=$totalofertas; ?></h2><br>
    <p>Clique em uma unidade abaixo para visualizar a sua oferta do ppc</p><br>
<ol class = "list-group">
<?php
foreach ($ofertas as $oferta):
$unidade = buscarUnidadePorId($oferta["unicod"]);
?>
<li class = "list-group-item">
<a href= "gerenciaOferta.php?opcao=ler&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>"><?=$unidade["uninome"]; ?></a>
</li>
<?php
endforeach;
?>
</ol>
<?php
else:
?>
<h1>Nenhuma oferta encontrada com este ppc</h1><br>
<p>Clique no link acima para cadastrar uma nova oferta</p><br>
<?php
endif;
elseif ($opcao == "unidade"):
$ofertas = buscarOfertasPorUnidade($_POST["unicod"]);
$unidade = buscarUnidadePorId($_POST["unicod"]);
$totalofertas = count($ofertas);
if ($totalofertas > 0):
?>
<h2>Número de ppcs ofertados na unidade SENAC <?=$unidade["uninome"]; ?>: <?=$totalofertas; ?></h2><br>
<p>Clique em um ppc abaixo para visualizar a sua oferta </p><br>
<ol class = "list-group">
<?php
foreach ($ofertas as $oferta):
$ppc = buscarPpcPorId($oferta["ppccod"]);
?>
<li class = "list-group-item">
<a href= "gerenciaOferta.php?opcao=ler&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>"><?=$ppc["ppcanoini"];?> - <?=$ppc["curnome"]; ?></a>
</li>
<?php
endforeach;
?>
</ol>
<?php
else:
?>
<h1>Nenhuma oferta cadastrada com esta unidade SENAC</h1><br>
<p>Clique no link acima para cadastrar uma nova oferta</p><br>
<?php
endif;
endif;
elseif ($_GET["opcao"] == "ler"):
$oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
$ppc = buscarPpcPorId($oferta["ppccod"]);
$unidade = buscarUnidadePorId($oferta["unicod"]);
?>
<h2><?=$unidade["uninome"]; ?>, <?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h2><br>
<div style="resize: both;">
<h2>Ano de vigência do ppc</h2><br>
<p><?=$ppc["ppcanoini"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>unidade SENAC</h2><br>
<p><?=$unidade["uninome"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>curso</h2><br>
<p><?=$ppc["curnome"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>Contexto educacional</h2><br>
<p><?=$oferta["ofecont"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>Número de vagas matutinas</h2><br>
<p><?=$oferta["ofevagasmat"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>Número de vagas vespertinas</h2><br>
<p><?=$oferta["ofevagasvesp"]; ?></p>
</div><br>
<div style="resize: both;">
<h2>Número de vagas noturnas</h2><br>
<p><?=$oferta["ofevagasnot"]; ?></p>
</div><br>
<div style="resize: both;">
<a href = "gerenciaOferta.php?opcao=alterar&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">Alterar conteúdo</a>
</div>
<div style="resize: both;">
<a href = "gerenciaOferta.php?opcao=excluir&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">excluir oferta de ppc</a>
</div>
<div style="resize: both;">
<a href = "gerenciaOferta.php?opcao=consultar">Voltar à tela de consulta de ofertas</a>
</div>
		<?php
 elseif ($_GET["opcao"] == "alterar") :
    $oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
    ?>
	<h2>Alteração de oferta de cursos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="ofecont">Contexto educacional</label>
				<textarea rows="3" cols="3" id="ofecont" name="ofecont"
					class="form-control">
					<?=$oferta["ofecont"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasmat">Número de vagas matutinas: </label> <input
					type="number" id="ofevagasmat" name="ofevagasmat"
					class="form-control" value="<?=$oferta['ofevagasmat']; ?>">
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasvesp">Número de vagas vespertinas: </label> <input
					type="number" id="ofevagasvesp" name="ofevagasvesp"
					class="form-control" value="<?=$oferta['ofevagasvesp']; ?>">
			</div>
			<br>
			<div class="form-control">
				<label for="ofevagasnot">Número de vagas noturnas: </label> <input
					type="number" id="ofevagasnot" name="ofevagasnot"
					class="form-control" value="<?=$oferta['ofevagasnot']; ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="alterar">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("unicod", $_POST) && ! array_key_exists("ofecont", $_POST) && ! array_key_exists("ofevagasmat", $_POST) && ! array_key_exists("ofevagasvesp", $_POST) && ! array_key_exists("ofevagasnot", $_POST))
        return;
    try {
        if (atualizarOferta($_POST["ppccod"], $_POST["unicod"], $_POST["ofecont"], $_POST["ofevagasmat"], $_POST["ofevagasvesp"], $_POST["ofevagasnot"])) {
            echo "<h1>Oferta atualizada com êxito!</h1><br>";
            echo "<a href= 'gerenciaOferta.php?opcao=consultar'>Voltar à tela de consulta de ofertas</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
    $unidade = buscarUnidadePorId($oferta["unicod"]);
    $ppc = buscarPpcPorId($oferta["ppccod"]);
    $curso = buscarCursoPorId($ppc["curcod"]);
    ?>
	<h2>Exclusão de oferta de curso</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
	Você está prestes a excluir a oferta do curso <?=$curso["curnome"]; ?>, com o ppc do ano de <?=$ppc["ppcanoini"]; ?>, na unidade SENAC <?=$unidade["uninome"]; ?>.<br>
					Você tem certeza de que deseja executar esta operação?<br> Após a
					confirmação, a operação não poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="sim"
					class="btn btn-success">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="não"
					class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirOferta($oferta["ppccod"], $oferta["unicod"])) {
                echo "<h1>Oferta excluída com êxito!</h1><br>";
                echo "<a href= 'gerenciaOferta.php?opcao=consultar'>Voltar à tela de consulta de oferta</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header("Location: gerenciaOferta.php?opcao=consultar");
    }
endif;
?>
</div>
</body>
</html>