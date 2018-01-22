<?php
require_once 'c:\wamp64\www\projetoppc\dao\ofertanivelamentodao.php';
$ppccod = isset($_GET["ppccod"]) ? $_GET["ppccod"] : "";
$unicod = isset($_GET["unicod"]) ? $_GET["unicod"] : "";
if (empty($ppccod) || empty($unicod)) :
    ?>
<div class="text-danger">
	<p>Selecione um PPC e uma unidade do SENAC</p>
</div>
<?php
    return;
endif;

$nivelamentosNaoVinculados = buscarNivelamentosDesvinculados($ppccod, $unicod);
if (! empty($nivelamentosNaoVinculados)) :
    ?>
<label for="nivcod">Selecione a atividade de nivelamento a ser
	vinculada: <span>*</span>
</label>
<select id="nivcod" name="nivcod" class="form-control">
	<option value="-1">selecione</option>
<?php
    foreach ($nivelamentosNaoVinculados as $nivelamento) :
        ?>
<option value="<?=$nivelamento["nivcod"]; ?>"><?=$nivelamento["nivdes"]; ?></option>
<?php
    endforeach
    ;
    ?>
</select>
<?php
else :
    ?>
<div class="text-warning">
	<p>Não há nenhuma atividade de nivelamento a ser vinculada.</p>
</div>
<?php
endif;
?>