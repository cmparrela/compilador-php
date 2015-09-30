<?php
$codigo = $_GET['codigo'];

$extensao = explode('.', $codigo);

if ($extensao[1] == 'nex') {

    $handle = fopen("../" . $codigo, "r");

    $linha = 0;
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            echo '<span id="span_' . $linha . '"><b>' . $linha++ . '</b>| ' . $line . '</span>';
        }

        fclose($handle);
    }
    else {
        echo 'Ops! Erro ao abrir o arquivo';
    }
}
else {
    echo 'Selecione um arquivo do tipo.NEX';
}
