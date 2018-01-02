<?php

function rotas($pagina)
{
    switch ($pagina) {
        case "atividade":
            require_once 'c:\wamp64\www\projetoppc\forms\atividade\gerenciaatividade.php';
            break;
        case "curso":
            require_once 'c:\wamp64\www\projetoppc\forms\curso\gerenciaCurso.php';
            break;
        case "ppc":
            require_once 'c:\wamp64\www\projetoppc\forms\ppc\gerenciaPpc.php';
            break;
        case "unidade":
            require_once 'c:\wamp64\www\projetoppc\forms\unidade\gerenciaUnidade.php';
            break;
        case "pdi":
            require_once 'c:\wamp64\www\projetoppc\forms\pdi\gerenciaPdi.php';
            break;
        case "eixotec":
            require_once 'c:\wamp64\www\projetoppc\forms\eixotec\gerenciaEixoTec.php';
            break;
        case "eixotem":
            require_once 'c:\wamp64\www\projetoppc\forms\eixotematico\gerenciaEixoTematico.php';
            break;
        case "disciplina":
            require_once 'c:\wamp64\www\projetoppc\forms\disciplina\gerenciaDisciplina.php';
            break;
        case "competencia":
            require_once 'c:\wamp64\www\projetoppc\forms\competencia\gerenciaCompetencia.php';
            break;
        case "indicador":
            require_once 'c:\wamp64\www\projetoppc\forms\indicador\gerenciaIndicador.php';
            break;
        case "certificacao":
            require_once 'c:\wamp64\www\projetoppc\forms\certificacao\gerenciaCertificacao.php';
            break;
        case "conteudo":
            require_once 'c:\wamp64\www\projetoppc\forms\conteudo\gerenciaConteudo.php';
            break;
        case "perfil":
            require_once 'c:\wamp64\www\projetoppc\forms\perfilconclusao\gerenciaPerfil.php';
            break;
        case "perfilcert":
            require_once 'c:\wamp64\www\projetoppc\forms\perfilcert\gerenciaPerfilCert.php';
            break;
        case "oferta":
            require_once 'c:\wamp64\www\projetoppc\forms\oferta\gerenciaOferta.php';
            break;
        case "vinculo":
            require_once 'c:\wamp64\www\projetoppc\forms\vinculo\gerenciavinculoind.php';
            break;
        case "vinculo2":
            require_once 'c:\wamp64\www\projetoppc\forms\vinculo\gerenciavinculofig.php';
            break;
        case "vinculo3":
            require_once 'c:\wamp64\www\projetoppc\forms\vinculo\gerenciavinculoatc.php';
            break;
        case "figura":
            require_once 'c:\wamp64\www\projetoppc\forms\figura\gerenciafigura.php';
            break;
        case "nivelamento":
            require_once 'c:\wamp64\www\projetoppc\forms\nivelamento\gerencianivelamento.php';
            break;
        default:
            require_once 'c:\wamp64\www\projetoppc\paginas\home.php';
            break;
    }
}

function active($pagina, $opcao, $link = "", $selecionada = "")
{
    if ($pagina == $link && $opcao == $selecionada) {
        return 'class= "active"';
    }
    return '';
}

?>