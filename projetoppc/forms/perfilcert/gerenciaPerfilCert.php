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
</head>
<body>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    $certificacoes = buscarCert();
    ?>
	<h2>Cadastro de perfil de certificação de término de curso</h2>
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
	endif;
	?>
	</div>
</body>
</html>