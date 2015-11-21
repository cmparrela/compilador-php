<?php
require_once './classes/Compilador.class.php';

$codigo_caminho = $_GET['arquivo'];
$codigo_caminho = 'codigo.nex';

$compilador = new Compilador($codigo_caminho);

$token = $compilador->getTokenCodigo();
$compilador->analiseLexica($token);
$compilador->analiseSintatica($token);
$compilador->analiseSemantica($token);

$retorno = $compilador->getErros();

echo json_encode($retorno);


/**
 * Exibe o array dentro das tags <pre>
 */
function d($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

