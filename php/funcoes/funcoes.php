<?php
// Reportar todos os erros exceto E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);

// Separa a PARSE em TOKEN e remove os espaços em branco
function token($parse) {
    for ($i = 0; $i < count($parse); $i++) {
        $token[$i] = explode(' ', trim($parse[$i]));
    }
    return $token;
}

// Valida o token
function valida_token($token, $simbolos) {
    for ($i = 0; $i < count($token); $i++) {
        for ($a = 0; $a < count($token[$i]); $a++) {
            //transforma string uppercase para lowercase
            ctype_lower($token[$i][$a]) ? $token[$i][$a] = $token[$i][$a] : $token[$i][$a] = strtolower($token[$i][$a]);

            //verfica se token atual nao existe na tabela de simbolo, se não é numero e se não é uma linha em branco
            if (!in_array($token[$i][$a], $simbolos) && !is_numeric($token[$i][$a]) && $token[$i][$a] != '') {

                //verifica se o token inexistente não é uma string ou seja se esta entre aspas e se não é uma variavel
                if (!preg_match("/^'(.+)'$/", $token[$i][$a]) && !preg_match("/^@(.+)$/", $token[$i][$a])) {
                    $mensagem_erro[] = ARRAY('MSG' => 'Erro Linha ' . $i . ': Não foi encontrado <b>' . $token[$i][$a] . '</b> na tabela de símbolos.<br>', 'ERRO' => $i);
                }
            }
        }
    }

    return $mensagem_erro;
}

?>