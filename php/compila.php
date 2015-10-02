<?php
require_once './classes/Compilador.class.php';

$codigo_caminho = $_GET['arquivo'];

$compilador = new Compilador($codigo_caminho);

$token = $compilador->getToken();
$retorno = $compilador->validaToken($token);

echo json_encode($retorno);
