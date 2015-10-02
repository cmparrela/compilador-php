<?php
require_once './funcoes/funcoes.php';

$codigo_caminho = $_GET['arquivo'];
//$codigo_caminho = 'codigo.nex';

$simbolos = file("../tabela_simbolos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$parse = file("../" . $codigo_caminho, FILE_SKIP_EMPTY_LINES);
$token = token($parse);
$mensagem_erro = valida_token($token, $simbolos);

if (empty($mensagem_erro)) {
    $mensagem_erro[] = ARRAY('MSG' => 'Compilado com Sucesso.', 'ERRO' => '-1');
}

echo json_encode($mensagem_erro);
