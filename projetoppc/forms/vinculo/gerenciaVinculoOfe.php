<?php
require_once 'c:\wamp64\www\projetoppc\dao\ofertaNivelamentoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
?>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $unidades = buscarUnidades();
    $totalppcs = count($ppcs);
    $totalunidades = count($unidades);
    ?>
<h2 class="text-center text-primary bg-primary">Vinculação de oferta de
		curso com atividade de nivelamento</h2>
	<br>
	<p>
		Para vincular uma oferta de curso a uma atividade de nivelamento,
		Selecione o <abbr class="text-uppercase">ppc</abbr> referente ao curso
		desejado, bem como a unidade do <abbr class="text-uppercase">senac</abbr>
		que ofertaa o curso.<br> Assim, automaticamente aparecerão as
		atividades de nivelamento já vinculadas.<br> Após a seleção do <abbr
			class="text-uppercase">ppc</abbr> do curso e da unidade, selecione
		uma atividade de nivelamento. Por fim, clique no botão vincular.
	</p>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" id="frm-salvar">
		<div class="form-group">
<?php
    if ($totalppcs > 0) :
        ?>
<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span></label> <select class="form-control" id="ppccod"
				name="ppccod">
				<option value="-1">Selecione</option>
<?php
        foreach ($ppcs as $ppc) :
            ?>
<option value="<?=$ppc["ppccod"]; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
<div class="text-warning">
				<h1 class="text-center">
					Não há <abbr class="text-uppercase">ppc</abbr>s cadastrados no
					sistema
				</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para
					cadastrar um novo <abbr class="text-uppercase">ppc</abbr>
				</a>
			</div>
<?php
        return;
    endif;
    ?>
</div>
		<br>
		<div class="form-group">
<?php
    if ($totalunidades > 0) :
        ?>
<label for="unicod">Selecione a unidade do <abbr class="text-uppercase">senac</abbr>:
				<span>*</span></label> <select class="form-control" id="unicod"
				name="unicod">
				<option value="-1">Selecione</option>
<?php
        foreach ($unidades as $unidade) :
            ?>
<option value="<?=$unidade["unicod"]; ?>"><?=$unidade["uninome"]; ?></option>
<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
<div class="text-warning">
				<h1 class="text-center">
					Não há unidades do <abbr class="text-uppercase">senac</abbr>
					cadastradas no sistema
				</h1>
				<br> <a href="?pagina=unidade&opcao=cadastrar">Clique aqui para
					cadastrar uma nova unidade <abbr class="text-uppercase">senac</abbr>
				</a>
			</div>
<?php
        return;
    endif;
    ?>
</div>
		<br>
		<div class="form-group" id="nivelamentos-vinculados"></div>
		<br>
		<div class="form-group" id="nivelamentos-nao-vinculados"></div>
		<br>
		<div class="form-group">
			<input type="submit" name="bt-form-salvar" class="btn btn-primary"
				value="salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $ppccod = isset($_POST["ppccod"]) ? $_POST["ppccod"] : "";
    $unicod = isset($_POST["unicod"]) ? $_POST["unicod"] : "";
    $nivcod = isset($_POST["nivcod"]) ? $_POST["nivcod"] : "";
    if ($ppccod == - 1) :
        ?>
<div class="text-danger">
		<p>
			Selecione um <abbr class="text-uppercase">ppc</abbr>
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($unicod == - 1) :
        ?>
<div class="text-danger">
		<p>
			Selecione uma unidade do <abbr class="text-uppercase">senac</abbr>
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($nivcod == - 1) :
        ?>
<div class="text-danger">
		<p>Selecione uma atividade de nivelamento</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $vinculo = buscarVinculoPorId($ppccod, $unicod, $nivcod);
    if (! empty($vinculo)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Atividade de nivelamento já vinculada com a oferta de curso";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (vincularOfertaComNivelamento($ppccod, $unicod, $nivcod)) {
            echo "<h1 class='text-center text-success'>Oferta vinculada com êxito!</h1><br>";
            echo "<a href='index.php'>Voltar à tela inicial</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $vinculo = buscarVinculoPorId($_GET["ppccod"], $_GET["unicod"], $_GET["nivcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Desvincular atividade de
		nivelamento de uma oferta</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p>
Você está prestes a desvincular a atividade de nivelamento <?=$vinculo["nivdes"]; ?>, do curso <?=$vinculo["curnome"]; ?>, oferecido na unidade <?=$vinculo["uninome"]; ?>, com ano inicial de vigência em <?=$vinculo["ppcanoini"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" id="btn-sim">sim</button>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" id="btn-nao">não</button>
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $escolha = $_POST["escolha"];
    if ($escolha == "sim") {
        try {
            if (desvincularOfertaDeNivelamento($vinculo["ppccod"], $vinculo["unicod"], $vinculo["nivcod"])) {
                echo "<h1 class='text-center text-success'>Atividade de nivelamento desvinculada com êxito!</h1><br>";
                echo "<a href='index.php'>Voltar à tela inicial</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>
