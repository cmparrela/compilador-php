<?php
$codigo  = $_GET['codigo'];

$handle = fopen("../".$codigo, "r");
$linha = 0;
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        echo $line;
    }

    fclose($handle);
} else {
    echo 'Ops! Erro ao abrir o Arquivo';
} 
