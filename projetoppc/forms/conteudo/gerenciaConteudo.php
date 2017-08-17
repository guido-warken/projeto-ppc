<?php
require_once 'c:\wamp64\www\projetoppc\dao\conteudoCurricularDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\eixoTematicoDao.php';
?>

<script src= "js/filtroconteudo.js"></script>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de conteúdo curricular</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    $ppcs = buscarPpcs();
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
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
    else :
        ?>
	<h1>Nenhum ppc cadastrado no sistema</h1>
				<br> <a href="../ppc/gerenciappc.php?opcao=cadastrar">Clique aqui
					para cadastrar um ppc</a><br>
	<?php
    endif;
    ?>
	</div>
			<br>
			<div class="form-group">
	<?php
    $disciplinas = buscarDisciplinas();
    $totaldisciplinas = count($disciplinas);
    if ($totaldisciplinas > 0) :
        ?>
	<label for="discod">Selecione a disciplina: </label> <select
					class="form-control" id="discod" name="discod">
	<?php
        foreach ($disciplinas as $disciplina) :
            ?>
	<option value="<?=$disciplina['discod']; ?>">
	<?=$disciplina["disnome"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
	<h1>Nenhuma disciplina cadastrada no sistema</h1>
				<br> <a href="../disciplina/gerenciaDisciplina.php?opcao=cadastrar">Clique
					aqui para cadastrar uma disciplina</a><br>
	<?php
    endif;
    ?>
	</div>
			<br>
			<div class="form-group">
	<?php
    $eixostematicos = buscarEixosTem();
    $totaleixostematicos = count($eixostematicos);
    if ($totaleixostematicos > 0) :
        ?>
	<label for="eixtcod">Selecione o eixo temático: </label> <select
					class="form-control" id="eixtcod" name="eixtcod">
	<?php
        foreach ($eixostematicos as $eixotematico) :
            ?>
	<option value="<?=$eixotematico['eixtcod']; ?>">
	<?=$eixotematico["eixtdes"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
	<h1>Nenhum eixo temático cadastrado no sistema</h1>
				<br> <a
					href="../eixotematico/gerenciaEixoTematico.php?opcao=cadastrar">Clique
					aqui para cadastrar um eixo temático</a><br>
	<?php
    endif;
    ?>
	</div>
			<br>
			<div class="form-group">
				<label for="contfase">Número da fase da disciplina: </label> <input
					type="number" id="contfase" name="contfase" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("discod", $_POST) && ! array_key_exists("eixtcod", $_POST) && ! array_key_exists("contfase", $_POST))
        return;
    try {
        if (inserirConteudoCurricular($_POST["ppccod"], $_POST["discod"], $_POST["eixtcod"], $_POST["contfase"])) {
            echo "<h1>Conteúdo curricular cadastrado com êxito!</h1><br>";
            echo "<a href= 'gerenciaConteudo.php?opcao=consultar'>Clique aqui para consultar os conteúdos curriculares cadastrados no sistema</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $disciplinas = buscarDisciplinas();
    ?>
		<h2>Exibição dos conteúdos curriculares</h2>
		<br> <a href="gerenciaConteudo.php?opcao=cadastrar">Novo conteúdo
			curricular</a><br>
		<form action="" method="post">
			<label>Selecione a opção: </label><br>
			<div class="form-group">
				<label class="label-check">Pesquisar conteúdo curricular por ppc: <input
					type="radio" name="escolha" value="ppc" id="opt1"
					class="form-check" onclick= "gerenciarFiltro()">
				</label><br> <label class="label-check">Pesquisar conteúdo
					curricular por disciplina: <input type="radio" name="escolha"
					value="disciplina" id="opt2" class="form-check" onclick= "gerenciarFiltro()">
				</label>
			</div>
			<br>
			<div class="form-group" id="div-ppc">
				<label for="ppccod">Selecione o ppc: </label> <select name="ppccod"
					id="ppccod" class="form-control">
			<?php
    foreach ($ppcs as $ppc) :
        ?>
			<option value="<?=$ppc['ppccod']; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
			<?php
    endforeach
    ;
    ?>
			</select>
			</div>
						<div class="form-group" id="div-disciplina">
				<label for="discod">Selecione a disciplina: </label> <select
					name="discod" id="discod" class="form-control">
			<?php
    foreach ($disciplinas as $disciplina) :
        ?>
			<option value="<?=$disciplina['discod']; ?>"><?=$disciplina["disnome"]; ?></option>
			<?php
    endforeach
    ;
    ?>
			</select>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="enviar">
			</div>
		</form>
						<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $opcao = $_POST["escolha"];
    if ($opcao == "ppc") :
        $conteudos = buscarConteudosCurricularesPorPpc($_POST["ppccod"]);
        $ppc = buscarPpcPorId($_POST["ppccod"]);
        $totalconteudos = count($conteudos);
        if ($totalconteudos > 0) :
            ?>
<h2><?= $ppc["ppcanoini"]; ?> - <?= $ppc["curnome"]; ?></h2>
		<table class="table table-bordered" style="resize: both;">
			<caption>Disciplinas por ppc</caption>
			<thead>
				<tr>
					<th>Disciplina</th>
					<th>Eixo temático</th>
					<th>Fase da disciplina</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
		<?php
            foreach ($conteudos as $conteudo) :
                $disciplina = buscarDisciplinaPorId($conteudo["discod"]);
                $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
                ?>
		<tr>
					<td><?=$disciplina["disnome"]; ?></td>
					<td><?=$eixotematico["eixtdes"]; ?></td>
					<td><?=$conteudo["contfase"]; ?>ª</td>
					<td><a
						href="gerenciaConteudo.php?opcao=alterar&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaConteudo.php?opcao=excluir&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Excluir
							conteudo curricular</a></td>
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
		<h1>Nenhum conteúdo curricular cadastrado com este ppc</h1>
		<br>
		<p>Clique no link acima para cadastrar um conteúdo curricular</p>
		<br>
		<?php
        endif;
     elseif ($opcao == "disciplina") :
        $conteudos = buscarConteudosCurricularesPorDisciplina($_POST["discod"]);
        $disciplina = buscarDisciplinaPorId($_POST["discod"]);
        $totalconteudos = count($conteudos);
        if ($totalconteudos > 0) :
            ?>
		<h2><?=$disciplina["disnome"] ?></h2>
		<br>
		<table class="table table-bordered" style="resize: both;">
			<caption>Ppcs por disciplina</caption>
			<thead>
				<tr>
					<th>ano de vigência do ppc</th>
					<th>Nome do curso</th>
					<th colspan="3">Ação</th>
				</tr>
			</thead>
			<tbody>
		<?php
            foreach ($conteudos as $conteudo) :
                $ppc = buscarPpcPorId($conteudo["ppccod"]);
                ?>
		<tr>
					<td><?=$ppc["ppcanoini"]; ?></td>
					<td><?=$ppc["curnome"]; ?></td>
					<td>
					<a href= "../ppc/gerenciappc.php?opcao=ler&ppccod=<?=$ppc['ppccod']; ?>">Visualizar PPC</a>
					</td>
					<td><a
						href="gerenciaConteudo.php?opcao=alterar&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaConteudo.php?opcao=excluir&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Excluir
							conteudo curricular</a></td>
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
		<h1>Nenhum conteúdo curricular cadastrado com esta disciplina</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo conteúdo curricular</p>
		<?php
        endif;
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $conteudo = buscarConteudoCurricularPorId($_GET["ppccod"], $_GET["discod"]);
    $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
    $eixostematicos = buscarEixosTemExceto($eixotematico["eixtcod"]);
    ?>
		<h2>Alteração de conteúdo curricular</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    $totaleixostematicos = count($eixostematicos);
    ?>
	<label for="eixtcod">Selecione o eixo temático: </label> <select
					class="form-control" id="eixtcod" name="eixtcod">
					<option value="<?=$eixotematico['eixtcod']; ?>" selected="selected">
					<?=$eixotematico["eixtdes"]; ?>
					</option>
	<?php
    if ($totaleixostematicos > 0) :
        foreach ($eixostematicos as $eixotematico) :
            ?>
	<option value="<?=$eixotematico['eixtcod']; ?>">
	<?=$eixotematico["eixtdes"]; ?>
	</option>
	<?php
        endforeach
        ;
			endif;
    
    ?>
	</select>
			</div>
			<br>
			<div class="form-group">
				<label for="contfase">Número da fase da disciplina: </label> <input
					type="number" id="contfase" name="contfase" class="form-control"
					value="<?=$conteudo['contfase']; ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="alterar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("discod", $_POST) && ! array_key_exists("eixtcod", $_POST) && ! array_key_exists("contfase", $_POST))
        return;
    try {
        if (atualizarConteudoCurricular($conteudo["ppccod"], $conteudo["discod"], $_POST["eixtcod"], $_POST["contfase"])) {
            echo "<h1>Conteúdo curricular atualizado com êxito!</h1><br>";
            echo "<a href= 'gerenciaConteudo.php?opcao=consultar'>Clique aqui para consultar novamente os conteúdos curriculares</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $conteudo = buscarConteudoCurricularPorId($_GET["ppccod"], $_GET["discod"]);
    $ppc = buscarPpcPorId($conteudo["ppccod"]);
    $disciplina = buscarDisciplinaPorId($conteudo["discod"]);
    $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
    ?>
	<h2>Exclusão de conteúdo curricular</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
	Você está prestes a excluir o conteudo curricular, referente ao ppc do curso <?=$ppc["curnome"]; ?>, com ano inicial de vigência em <?=$ppc["ppcanoini"]; ?>, com a disciplina <?=$disciplina["disnome"]; ?>, dada na <?=$conteudo["contfase"]; ?>ª fase.<br>
					Você tem certeza de que deseja executar esta operação?<br> Após a
					confirmação, esta operação não poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" class="btn btn-success"
					value="sim">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" class="btn btn-success"
					value="não">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirConteudoCurricular($conteudo["ppccod"], $conteudo["discod"])) {
                echo "<h1>Conteúdo curricular excluído com êxito!</h1><br>";
                echo "<a href= 'gerenciaConteudo.php?opcao=consultar'>Clique aqui para voltar à tela de consulta de conteúdos curriculares</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header("Location: gerenciaConteudo.php?opcao=consultar");
    }
endif;
?>
	</div>
