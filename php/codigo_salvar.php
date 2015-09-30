<?php

$codigo  = 'codigo.nex';
$novo_codigo = $_GET['novo_codigo'];

$handle = fopen("../".$codigo, "w");
$linha = 0;
if ($handle) {
    fwrite($handle, $novo_codigo);
    fclose($handle);
} else {
    echo 'Ops! Erro ao abrir o Arquivo';
} 
