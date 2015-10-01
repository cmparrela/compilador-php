<?php
// Reportar todos os erros exceto E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);

$codigo_caminho = $_GET['arquivo'];
$token          = ARRAY();
$mensagem_erro  = ARRAY();

$simbolos = file("../tabela_simbolos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$parse = file("../".$codigo_caminho, FILE_SKIP_EMPTY_LINES);


// separa a PARSE em TOKEN e remove os espa�os em branco
for ($i = 0; $i < count($parse); $i++) {
    $token[$i] = explode(' ', trim($parse[$i]));
}

//percorre o array TOKEN
for ($i = 0; $i < count($token); $i++) {
    for ($a = 0; $a < count($token[$i]); $a++) {
        //verifica se a string é lowercase, caso sim mantem, caso não transforma para lower
        ctype_lower($token[$i][$a])? $token[$i][$a] = $token[$i][$a] : $token[$i][$a] = strtolower ($token[$i][$a]);
        
        //verfica se token atual n�o existe na tabela de simbolo, se n�o � numero e se n�o � uma linha em branco
        if (!in_array($token[$i][$a], $simbolos) && !is_numeric($token[$i][$a]) && $token[$i][$a] != '') {

            //verifica se o token inexistente n�o � uma string ou seja se est� entre aspas e se n�o � uma variavel
            if (!preg_match("/^'(.+)'$/", $token[$i][$a]) && !preg_match("/^@(.+)$/", $token[$i][$a])) {
                $mensagem_erro[] = ARRAY('MSG'=>'Erro Linha '.$i.': Não foi encontrado <b>' . $token[$i][$a] . '</b> na tabela de símbolos.<br>','ERRO'=> $i);
            }
            
        }
    }
}

if (empty($mensagem_erro)) {
    $mensagem_erro[] = ARRAY('MSG'=>'Compilado com Sucesso.','ERRO'=> '-1');
}

echo json_encode($mensagem_erro);
