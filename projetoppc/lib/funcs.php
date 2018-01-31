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
        case "vinculo4":
            require_once 'c:\wamp64\www\projetoppc\forms\vinculo\gerenciavinculoofe.php';
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

function loadScript($pagina)
{
    switch ($pagina) {
        case "atividade":
            echo "<script src='
            js/validaformatividade.js'></script>";
            break;
        case "nivelamento":
            echo "<script src='
            js/validaformnivelamento.js'></script>";
            break;
        case "curso":
            echo "<script src='
            js/validaformcurso.js'></script>";
            break;
        case "ppc":
            echo "<script src='
            js/validaformppc.js'></script>";
            break;
        case "unidade":
            echo "<script src='
            js/validaformunidade.js'></script>";
            break;
        case "eixotec":
            echo "<script src='
            js/validaformeixotec.js'></script>";
            break;
        case "eixotem":
            echo "<script src='
            js/validaformeixotem.js'></script>";
            break;
        case "pdi":
            echo "<script src='
            js/validaformpdi.js'></script>";
            break;
        case "disciplina":
            echo "<script src='
            js/validaformdisciplina.js'></script>";
            break;
        case "competencia":
            echo "<script src='
            js/validaformcompetencia.js'></script>";
            break;
        case "indicador":
            echo "<script src='
            js/validaformindicador.js'></script>";
            break;
        case "certificacao":
            echo "<script src='
            js/validaformcertificacao.js'></script>";
            break;
        case "conteudo":
            echo "<script src='
            js/filtroconteudo.js'></script>";
            echo "<script src='
            js/validaformconteudo.js'></script>";
            break;
        case "perfil":
            echo "<script src='
            js/validaformperfil.js'></script>";
            echo "<script src='
            js /filtroperfil.js'></script>";
            break;
        case "perfilcert":
            echo "<script src='
            js/validaformperfilcert.js'></script>";
            echo "<script src='
            js/filtroperfilcert.js'></script>";
            break;
        case "oferta":
            echo "<script src='
            js/validaformoferta.js'></script>";
            echo "<script src='
            js/filtrooferta.js'></script>";
            break;
        case "figura":
            echo "<script src='
            js/validaformfigura.js'></script>";
            break;
        case "vinculo":
            echo "<script src='
            js/vinculaindicador.js'></script>";
            break;
        case "vinculo2":
            echo "<script src='
            js/vinculafigura.js'></script>";
            break;
        case "vinculo3":
            echo "<script src='
            js/vinculaatividade.js'></script>";
            break;
        case "vinculo4":
            echo "<script src='js/vinculaoferta.js'></script>";
            break;
        
        default:
            ;
            break;
    }
}

?>