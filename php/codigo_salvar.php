<?php
include '../config_path.php';
$nome_arquivo = $_GET['arquivo'];
$novo_codigo = $_GET['novo_codigo'];

$handle = fopen($GLOBALS['PATH'].'/'.$nome_arquivo, "w");
$linha = 0;
if ($handle) {
    fwrite($handle, $novo_codigo);
    fclose($handle);
} else {
    echo 'Ops! Erro ao abrir o Arquivo';
} 
