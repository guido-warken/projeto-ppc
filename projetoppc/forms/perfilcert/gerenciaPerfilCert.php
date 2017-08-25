<?php
require_once 'c:\wamp64\www\projetoppc\dao\perfilCertificacaoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\competenciaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\certificacaoDao.php';
?>
<script src="js/redirectperfilcert.js"></script>
<script src="js/filtroperfilcert.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    $certificacoes = buscarCert();
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de perfil de certificação
		de curso</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
	<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
	<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select id="ppccod" name="ppccod" class="form-control">
	<?php
        foreach ($ppcs as $ppc) :
            ?>
	<option value="<?=$ppc['ppccod']; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Não há nenhum ppc cadastrado no sistema</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para
					cadastrar um novo ppc</a>
			</div>
			<br>
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
	<label for="compcod">Selecione a competência</label> <select
				id="compcod" name="compcod" class="form-control">
	<?php
        foreach ($competencias as $competencia) :
            ?>
	<option value="<?=$competencia['compcod']; ?>"><?=$competencia["compdes"]; ?></option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Não há nenhuma competência cadastrada no
					sistema</h1>
				<br> <a href="?pagina=competencia&opcao=cadastrar">Clique aqui para
					cadastrar uma nova competência</a>
			</div>
			<br>
	<?php
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
	<?php
    $totalcert = count($certificacoes);
    if ($totalcert > 0) :
        ?>
	<label for="cercod">Selecione a certificação</label> <select
				id="cercod" name="cercod" class="form-control">
	<?php
        foreach ($certificacoes as $cert) :
            ?>
	<option value="<?=$cert['cercod']; ?>"><?=$cert["cerdes"]; ?></option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Não há nenhuma certificação cadastrada no
					sistema</h1>
				<br> <a href="?pagina=certificacao&opcao=cadastrar">Clique aqui para
					cadastrar uma nova certificação</a>
			</div>
			<br>
	<?php
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("compcod", $_POST) && ! array_key_exists("cercod", $_POST))
        return;
    try {
        if (inserirPerfilCert($_POST["ppccod"], $_POST["compcod"], $_POST["cercod"])) {
            echo "<h1 class= 'text-success'>Perfil de certificação de curso cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=perfilcert&opcao=consultar'>Clique aqui para consultar os perfis de certificação de curso cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    $certificacoes = buscarCert();
    ?>
	<h2 class="text-center text-primary bg-primary">Consulta de perfis de certificação de curso</h2>
	<br> <a href="?pagina=perfilcert&opcao=cadastrar">Novo perfil de
		certificação de curso</a><br>
	<form action="" method="post">
		<div class="form-group">
			<label>Selecione a opção: </label><br> <label class="label-check">Selecionar
				perfil de certificação de curso por <abbr class="text-uppercase">ppc</abbr>:
				<input type="radio" name="escolha" id="opt1" class="form-check"
				value="ppc" onclick="gerenciarFiltro()">
			</label><br> <label class="label-check">Selecionar perfil de
				certificação de curso por competência: <input type="radio"
				name="escolha" id="opt2" class="form-check" value="competencia"
				onclick="gerenciarFiltro()">
			</label><br> <label class="label-check">Selecionar perfil de
				certificação de curso por certificação: <input type="radio"
				name="escolha" id="opt3" class="form-check" value="cert"
				onclick="gerenciarFiltro()">
			</label>
		</div>
		<br>
		<div class="form-group" id="div-ppc">
			<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select id="ppccod" name="ppccod" class="form-control">
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
		<div class="form-group" id="div-competencia">
			<label for="compcod">Selecione a competência</label> <select
				id="compcod" name="compcod" class="form-control">
	<?php
    foreach ($competencias as $competencia) :
        ?>
	<option value="<?=$competencia['compcod']; ?>"><?=$competencia["compdes"]; ?></option>
	<?php
    endforeach
    ;
    ?>
	</select>
		</div>
		<div class="form-group" id="div-cert">
			<label for="cercod">Selecione a certificação</label> <select
				id="cercod" name="cercod" class="form-control">
	<?php
    foreach ($certificacoes as $cert) :
        ?>
	<option value="<?=$cert['cercod']; ?>"><?=$cert["cerdes"]; ?></option>
	<?php
    endforeach
    ;
    ?>
	</select>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="enviar" class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $opcao = $_POST["escolha"];
    if ($opcao == "ppc") :
        $perfis = buscarPerfilCertPorPpc($_POST["ppccod"]);
        $ppc = buscarPpcPorId($_POST["ppccod"]);
        $totalperfilcert = count($perfis);
        ?>
		<h2 class="text-center" text-primary bg-primary><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h2>
	<br>
		<?php
        if ($totalperfilcert > 0) :
            ?>
	<h2 class="text-center text-info">
		Número de perfis de Certificação de curso encontrados com este <abbr
			class="text-uppercase">ppc</abbr>: <?=$totalperfilcert; ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>
			Perfil de certificação de curso por <abbr class="text-uppercase">ppc</abbr>
		</caption>
		<thead>
			<tr>
				<th>Competência</th>
				<th>Certificação</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
            foreach ($perfis as $perfil) :
                $competencia = buscarCompetenciaPorId($perfil["compcod"]);
                $certificacao = buscarCertPorId($perfil["cercod"]);
                ?>
	<tr>
				<td><?=$competencia["compdes"]; ?></td>
				<td><?=$certificacao["cerdes"]; ?></td>
				<td><a
					href="?pagina=perfilcert&opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir
						perfil de certificação de curso</a></td>
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
	<div class="text-warning bg-info">
		<h1 class="text-center">
			Nenhum perfil de certificação de término de curso cadastrado com este
			<abbr class="text-uppercase">ppc</abbr>
		</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo perfil de certificação
			de Término de curso</p>
	</div>
	<br>
	<?php
        endif;
     elseif ($opcao == "competencia") :
        $perfis = buscarPerfilCertPorCompetencia($_POST["compcod"]);
        $competencia = buscarCompetenciaPorId($_POST["compcod"]);
        $totalperfilcert = count($perfis);
        ?>
	<h2 class="text-center text-primary bg-primary"><?=$competencia["compdes"]; ?></h2>
	<br>
	<?php
        if ($totalperfilcert > 0) :
            ?>
	<h2 class="text-center text-info">Número de perfis de certificação de curso encontrados com esta competência: <?=$totalperfilcert; ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>Perfil de certificação de curso por competência</caption>
		<thead>
			<tr>
				<th><abbr class="text-uppercase">ppc</abbr></th>
				<th>Certificação</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
            foreach ($perfis as $perfil) :
                $ppc = buscarPpcPorId($perfil["ppccod"]);
                $certificacao = buscarCertPorId($perfil["cercod"]);
                ?>
	<tr>
				<td><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></td>
				<td><?=$certificacao["cerdes"]; ?></td>
				<td><a
					href="?pagina=perfilcert&opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir
						perfil de certificação de curso</a></td>
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
		<div class="text-warning bg-info">
		<h1 class="text-center">Nenhum perfil de certificação de término de
			curso cadastrado com esta competência</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo perfil de certificação
			de Término de curso</p>
	</div>
	<br>
	<?php
        endif;
     elseif ($opcao == "cert") :
        $perfis = buscarPerfilCertPorCertificacao($_POST["cercod"]);
        $certificacao = buscarCertPorId($_POST["cercod"]);
        $totalperfilcert = count($perfis);
        ?>
		<h2 class="text-center text-primary bg-primary"><?=$certificacao["cerdes"]; ?></h2>
	<br>
		<?php
        if ($totalperfilcert > 0) :
            ?>
	<h2 class="text-center text-info">Número de perfis de certificação de curso encontrados com esta certificação: <?=$totalperfilcert; ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>Perfil de certificação de curso por certificação</caption>
		<thead>
			<tr>
				<th><abbr class="text-uppercase">ppc</abbr></th>
				<th>Competência</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
            foreach ($perfis as $perfil) :
                $ppc = buscarPpcPorId($perfil["ppccod"]);
                $competencia = buscarCompetenciaPorId($perfil["compcod"]);
                ?>
	<tr>
				<td><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></td>
				<td><?=$competencia["compdes"]; ?></td>
				<td><a
					href="?pagina=perfilcert&opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir
						perfil de certificação de curso</a></td>
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
	<div class="text-warning bg-info">
		<h1 class="text-center">Nenhum perfil de certificação de término de curso cadastrado com
			esta competência</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo perfil de certificação
			de Término de curso</p>
	</div>
	<br>
	<?php
        endif;
    else :
        ?>
			<div class="text-danger bg-danger">
		<p>
			Impossível de pesquisar os perfis de certificação de curso.<br> Por
			favor, selecione uma opção marcando uma das três opções acima.
		</p>
	</div>
	<br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "excluir") :
    $perfil = buscarPerfilCertPorId($_GET["ppccod"], $_GET["compcod"], $_GET["cercod"]);
    $ppc = buscarPpcPorId($perfil["ppccod"]);
    $competencia = buscarCompetenciaPorId($perfil["compcod"]);
    $certificacao = buscarCertPorId($perfil["cercod"]);
    ?>
		<h2 class="text-center text-primary bg-primary">Exclusão de perfil de
		certificação de curso</h2>
	<br>
	<form action="" method="post">
		<div class="form-group text-warning">
			<p>
		Você está prestes a excluir um perfil de certificação de curso, pertencente ao <?=$ppc["curnome"]; ?>, com a competência <?=$competencia["compdes"]; ?>, com a certificação <?=$certificacao["cerdes"]; ?>.<br>
				Você gostaria de executar esta operação?<br> Ao executar esta
				operação, ela não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" name="escolha" value="sim"
				class="btn btn-default">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" name="escolha" value="não"
				class="btn btn-default">
		</div>
	</form>
		<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirPerfilCert($perfil["ppccod"], $perfil["compcod"], $perfil["cercod"])) {
                echo "<h1>Perfil de certificação de curso excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=perfilcert&opcao=consultar'>Clique aqui para voltar à tela de consulta de perfil de certificação de curso</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o perfil de certificação de curso não será excluído.</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de perfis de certificação de curso</button><br>";
    }
endif;
?>
			</div>
