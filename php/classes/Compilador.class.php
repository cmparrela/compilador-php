<?php
// Reportar todos os erros exceto E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);

class Compilador {

    public $tabela_simbolos = null;
    public $parse = null;

    public function __Construct($arquivo) {
        $this->tabela_simbolos = file("../tabela_simbolos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->parse = file("../$arquivo", FILE_SKIP_EMPTY_LINES);
    }

    function getToken() {
        for ($i = 0; $i < count($this->parse); $i++) {
            $token[$i] = explode(' ', trim($this->parse[$i]));
        }

        return $token;
    }

    function validaToken($token) {
        for ($i = 0; $i < count($token); $i++) {
            for ($a = 0; $a < count($token[$i]); $a++) {
                //transforma string uppercase para lowercase
                ctype_lower($token[$i][$a]) ? $token[$i][$a] = $token[$i][$a] : $token[$i][$a] = strtolower($token[$i][$a]);

                //verfica se token atual nao existe na tabela de simbolo, se não é numero e se não é uma linha em branco
                if (!in_array($token[$i][$a], $this->tabela_simbolos) && !is_numeric($token[$i][$a]) && $token[$i][$a] != '') {

                    //verifica se o token inexistente não é uma string ou seja se esta entre aspas e se não é uma variavel
                    if (!preg_match("/^'(.+)'$/", $token[$i][$a]) && !preg_match("/^@(.+)$/", $token[$i][$a])) {
                        $mensagem_erro[] = ARRAY('MSG' => 'Erro Linha ' . $i . ': Não foi encontrado <b>' . $token[$i][$a] . '</b> na tabela de símbolos.<br>', 'ERRO' => $i);
                    }
                }
            }
        }

        if (empty($mensagem_erro)) {
            $mensagem_erro[] = ARRAY('MSG' => 'Compilado com Sucesso.', 'ERRO' => '-1');
        }

        return $mensagem_erro;
    }

}
