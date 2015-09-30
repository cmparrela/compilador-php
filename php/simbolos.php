<?php
$simbolos = file("../tabela_simbolos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

for ($i = 0; $i < count($simbolos); $i++) {
    echo $simbolos[$i].'<br>';
}

