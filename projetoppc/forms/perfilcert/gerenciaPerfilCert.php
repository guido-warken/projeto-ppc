<?php
require_once 'c:\wamp64\www\projetoppc\dao\perfilCertificacaoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\competenciaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\certificacaoDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de perfil da certificação</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src= "../../js/filtroperfilcert.js"></script>
</head>
<body>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    $certificacoes = buscarCert();
    ?>
	<h2>Cadastro de perfil de certificação de curso</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
	<label for="ppccod">Selecione o ppc</label> <select id="ppccod"
					name="ppccod" class="form-control">
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
	<h1>Não há nenhum ppc cadastrado no sistema</h1>
				<br> <a href="../ppc/gerenciappc.php?opcao=cadastrar">Clique aqui
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
	<h1>Não há nenhuma competência cadastrada no sistema</h1>
				<br> <a
					href="../competencia/gerenciacompetencia.php?opcao=cadastrar">Clique
					aqui para cadastrar uma nova competência</a><br>
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
	<h1>Não há nenhuma certificação cadastrada no sistema</h1>
				<br> <a
					href="../certificacao/gerenciacertificacao.php?opcao=cadastrar">Clique
					aqui para cadastrar uma nova certificação</a><br>
	<?php
    endif;
    ?>
	</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("ppccod", $_POST) && ! array_key_exists("compcod", $_POST) && ! array_key_exists("cercod", $_POST))
        return;
    try {
        if (inserirPerfilCert($_POST["ppccod"], $_POST["compcod"], $_POST["cercod"])) {
            echo "<h1>Perfil de certificação de curso cadastrado com êxito!</h1><br>";
            echo "<a href= 'gerenciaperfilcert.php?opcao=consultar'>Clique aqui para consultar os perfis de certificação de curso cadastradas</a><br>";
        }
    } catch (PDOException $e) {
	    echo $e->getMessage();
	}
	elseif ($_GET["opcao"] == "consultar"):
	$ppcs = buscarPpcs();
	$competencias = buscarCompetencias();
	$certificacoes = buscarCert();
	?>
	<h2>Consulta de perfis de certificação de curso</h2><br>
	<a href= "gerenciaperfilcert.php?opcao=cadastrar">Novo perfil de certificação de curso</a><br>
	<form action= "" method= "post">
	<div class= "form-group">
	<label>Selecione a opção: </label><br>
	<label class= "label-check">Selecionar perfil de certificação de curso por ppc:
	<input type= "radio" name= "escolha" id= "opt1" class= "form-check" value= "ppc" onclick= "gerenciarFiltro()">
	</label><br>
	<label class= "label-check">Selecionar perfil de certificação de curso por competência:
	<input type= "radio" name= "escolha" id= "opt2" class= "form-check" value= "competencia" onclick= "gerenciarFiltro()">
	</label><br>
	<label class= "label-check">Selecionar perfil de certificação de curso por certificação:
	<input type= "radio" name= "escolha" id= "opt3" class= "form-check" value= "cert" onclick= "gerenciarFiltro()">
	</label>
	</div><br>
	<div class= "form-group" id= "div-ppc">
	<label for= "ppccod">Selecione o ppc</label>
	<select id= "ppccod" name= "ppccod" class= "form-control">
	<?php
	foreach ($ppcs as $ppc):
	?>
	<option value= "<?=$ppc['ppccod']; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
	<?php
	endforeach;
	?>
	</select>
	</div>
	<div class= "form-group" id= "div-competencia">
	<label for= "compcod">Selecione a competência</label>
	<select id= "compcod" name= "compcod" class= "form-control">
	<?php
	foreach ($competencias as $competencia):
	?>
	<option value= "<?=$competencia['compcod']; ?>"><?=$competencia["compdes"]; ?></option>
	<?php
	endforeach;
	?>
	</select>
	</div>
	<div class= "form-group" id= "div-cert">
	<label for= "cercod">Selecione a certificação</label>
	<select id= "cercod" name= "cercod" class= "form-control">
	<?php
	foreach ($certificacoes as $cert):
	?>
	<option value= "<?=$cert['cercod']; ?>"><?=$cert["cerdes"]; ?></option>
	<?php
	endforeach;
	?>
	</select>
	</div><br>
	<div class= "form-group">
	<input type= "submit" value= "enviar" class= "btn btn-success">
	</div><br>
	</form>
	<?php
	if (!array_key_exists("escolha", $_POST))
	    return;
	$opcao = $_POST["escolha"];
	if ($opcao == "ppc"):
	$perfis = buscarPerfilCertPorPpc($_POST["ppccod"]);
	$ppc = buscarPpcPorId($_POST["ppccod"]);
	$totalperfilcert = count($perfis);
	if ($totalperfilcert > 0):
	?>
	<h2>Número de perfis de Certificação de curso encontrados com este ppc: <?=$totalperfilcert; ?></h2><br>
	<h2><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h2><br>
	<table class= "table table-bordered" style= "resize: both;">
	<thead>
	<tr>
	<th>Competência</th>
	<th>Certificação</th>
	<th colspan= "2">Ação</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($perfis as $perfil):
	$competencia = buscarCompetenciaPorId($perfil["compcod"]);
	$certificacao = buscarCertPorId($perfil["cercod"]);
	?>
	<tr>
	<td><?=$competencia["compdes"]; ?></td>
	<td><?=$certificacao["cerdes"]; ?></td>
		<td>
	<a href= "gerenciaperfilcert.php?opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir perfil de certificação de curso</a>
	</td>
	</tr>
	<?php
	endforeach;
	?>
	</tbody>
	</table>
	<?php
	else:
	?>
	<h1>Nenhum perfil de certificação de término de curso cadastrado com este ppc</h1><br>
	<p>Clique no link acima para cadastrar um novo perfil de certificação de Término de curso</p>
	<?php
	endif;
	elseif ($opcao == "competencia"):
	$perfis = buscarPerfilCertPorCompetencia($_POST["compcod"]);
	$competencia = buscarCompetenciaPorId($_POST["compcod"]);
	$totalperfilcert = count($perfis);
	if ($totalperfilcert > 0):
	?>
	<h2>Número de perfis de certificação de curso encontrados com esta competência: <?=$totalperfilcert; ?></h2><br>
	<h2><?=$competencia["compdes"]; ?></h2><br>
	<table class= "table table-bordered" style= "resize: both;">
	<thead>
	<tr>
	<th>ppc</th>
	<th>Certificação</th>
	<th colspan= "2">Ação</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($perfis as $perfil):
	$ppc = buscarPpcPorId($perfil["ppccod"]);
	$certificacao = buscarCertPorId($perfil["cercod"]);
	?>
	<tr>
	<td><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></td>
	<td><?=$certificacao["cerdes"]; ?></td>
	<td>
	<a href= "gerenciaperfilcert.php?opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir perfil de certificação de curso</a>
	</td>
	</tr>
	<?php
	endforeach;
	?>
	</tbody>
	</table>
	<?php
	else:
	?>
	<h1>Nenhum perfil de certificação de término de curso cadastrado com esta competência</h1><br>
	<p>Clique no link acima para cadastrar um novo perfil de certificação de Término de curso</p>
	<?php
	endif;
	elseif ($opcao == "cert"):
	$perfis = buscarPerfilCertPorCertificacao($_POST["cercod"]);
	$certificacao = buscarCertPorId($_POST["cercod"]);
	$totalperfilcert = count($perfis);
	if ($totalperfilcert > 0):
	?>
	<h2>Número de perfis de certificação de curso encontrados com esta certificação: <?=$totalperfilcert; ?></h2><br>
	<h2><?=$certificacao["cerdes"]; ?></h2><br>
	<table class= "table table-bordered" style= "resize: both;">
	<thead>
	<tr>
	<th>ppc</th>
	<th>Competência</th>
	<th colspan= "2">Ação</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($perfis as $perfil):
	$ppc = buscarPpcPorId($perfil["ppccod"]);
	$competencia = buscarCompetenciaPorId($perfil["compcod"]);
	?>
	<tr>
	<td><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></td>
	<td><?=$competencia["compdes"]; ?></td>
	<td>
	<a href= "gerenciaperfilcert.php?opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>&cercod=<?=$perfil['cercod']; ?>">excluir perfil de certificação de curso</a>
	</td>
	</tr>
	<?php
	endforeach;
	?>
	</tbody>
	</table>
	<?php
	else:
	?>
	<h1>Nenhum perfil de certificação de término de curso cadastrado com esta competência</h1><br>
	<p>Clique no link acima para cadastrar um novo perfil de certificação de Término de curso</p>
	<?php
	endif;
	endif;
	elseif ($_GET["opcao"] == "excluir"):
	$perfil = buscarPerfilCertPorId($_GET["ppccod"], $_GET["compcod"], $_GET["cercod"]);
	$ppc = buscarPpcPorId($perfil["ppccod"]);
	$competencia = buscarCompetenciaPorId($perfil["compcod"]);
	$certificacao = buscarCertPorId($perfil["cercod"]);
		?>
		<h2>Exclusão de perfil de certificação de curso</h2><br>
		<form action= "" method= "post">
		<div class= "form-group">
		<p>
		Você está prestes a excluir um perfil de certificação de curso, pertencente ao <?=$ppc["curnome"]; ?>, com a competência <?=$competencia["compdes"]; ?>, com a certificação <?=$certificacao["cerdes"]; ?>.<br>
		Você gostaria de executar esta operação?<br>
		Ao executar esta operação, ela não poderá ser desfeita.
		</p>
		</div><br>
		<div class= "form-group">
		<input type= "submit" name= "escolha" value= "sim" class= "btn btn-success">
		</div><br>
		<div class= "form-group">
		<input type= "submit" name= "escolha" value= "não" class= "btn btn-success">
		</div>
		</form>
		<?php
		if (!array_key_exists("escolha", $_POST))
		    return;
		if ($_POST["escolha"] == "sim") {
		    try {
		        if (excluirPerfilCert($perfil["ppccod"], $perfil["compcod"], $perfil["cercod"])) {
		            echo "<h1>Perfil de certificação de curso excluído com êxito!</h1><br>";
		            echo "<a href= 'gerenciaperfilcert.php?opcao=consultar'>Clique aqui para voltar à tela de consulta de perfil de certificação de curso</a><br>";
		        }
		    } catch (PDOException $e) {
		        echo $e->getMessage();
		    }
		} else {
		    header("Location: gerenciaPerfilCert.php?opcao=consultar");
		}
		endif;
		?>
		
	</div>
</body>
</html>