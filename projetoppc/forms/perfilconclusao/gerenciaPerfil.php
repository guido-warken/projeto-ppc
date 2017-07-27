<?php
require_once 'c:\wamp64\www\projetoppc\dao\perfilConclusaoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\competenciaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de perfil de conclusão de Curso</title>
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
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    ?>
	<h2>Cadastro de perfil de conclusão</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
	<label for="ppccod">Selecione o PPC: </label> <select
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
    $totalcompetencias = count($competencias);
    if ($totalcompetencias > 0) :
        ?>
	<label for="compcod">Selecione a competência: </label> <select
					class="form-control" id="compcod" name="compcod">
	<?php
        foreach ($competencias as $competencia) :
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
					aqui para cadastrar uma nova compet�ncia</a><br>
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
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("compcod", $_POST))
        return;
    try {
        if (inserirPerfilConclusao($_POST["ppccod"], $_POST["compcod"])) {
            echo "<h1>Perfil de Conclusão cadastrado com êxito!</h1><br>";
            echo "<a href= 'gerenciaPerfil.php?opcao=consultar'>Clique aqui para consultar os perfis de conclusão cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $perfis = buscarPerfisConclusao();
    ?>
		<h2>Consulta de perfis de conclusão</h2>
		<br> <a href="gerenciaPerfil.php?opcao=cadastrar">Novo perfil de
			conclusão</a>
		<form action="" method="post">
			<div class="form-group">
		<?php
    $totalperfis = count($perfis);
    if ($totalperfis > 0) :
        ?>
		<label for="ppccod">Selecione o ppc vinculado ào perfil de conclusão</label>
				<select id="ppccod" name="ppccod" class="form-control">
		<?php
        foreach ($perfis as $perfil) :
            $ppc = buscarPpcPorId($perfil["ppccod"]);
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
		<h1>Nenhum perfil de conclusão foi cadastrado no sistema</h1>
				<br> <a href="gerenciaperfil.php?opcao=cadastrar">Novo perfil de
					conclusão</a><br>
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
    if (! array_key_exists("ppccod", $_POST))
        return;
    $perfis = buscarPerfilConclusaoPorPpc($_POST["ppccod"]);
    ?>
		<table class="table table-bordered">
			<caption>Perfil de Conclusão do curso</caption>
			<thead>
				<tr>
					<th>Competência</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
			<?php
    foreach ($perfis as $perfil) :
        $competencia = buscarCompetenciaPorId($perfil["compcod"]);
        ?>
				<tr>
					<td><?=$competencia["compdes"]; ?></td>
					<td><a
						href="gerenciaPerfil.php?opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>">Excluir</a>
					</td>
				</tr>
				<?php
    endforeach
    ;
    ?>
			</tbody>
		</table>
		<?php
 elseif ($_GET["opcao"] == "excluir") :
    $perfil = buscarPerfilConclusaoPorId($_GET["ppccod"], $_GET["compcod"]);
    $ppc = buscarPpcPorId($perfil["ppccod"]);
    $competencia = buscarCompetenciaPorId($perfil["compcod"]);
    $curso = buscarCursoPorId($ppc["curcod"]);
    ?>
	<h2>Exclusão de Perfil de conclusão</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
	Você está prestes a excluir a competência <?=$competencia["compdes"]; ?>, do <?=$curso["curnome"]; ?>, com o ano de vigência de <?=$ppc["ppcanoini"]; ?>.<br>
					Você tem certeza de que deseja executar esta operação?<br> Ao
					confirmar, a operação não poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="sim">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="não">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirPerfilConclusao($perfil["ppccod"], $perfil["compcod"])) {
                echo "<h1>Perfil de conclusão de curso excluído com êxito!</h1><br>";
                echo "<a href= 'gerenciaPerfil.php?opcao=consultar'>Voltar à tela de consulta de perfil de conclusão</a>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header("Location: gerenciaPerfil.php?opcao=consultar");
	}
	endif;
	?>
			</div>
</body>
</html>