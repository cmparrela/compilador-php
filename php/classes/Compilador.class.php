<?php

// Reportar todos os erros exceto E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);

class Compilador {

    public $parse_simbolos = null;
    public $parse_sintatica = null;
    public $parse_codigo = null;
    public $token_sintatica = null;
    public $token_simbolos = null;
    public $mensagem_erro = null;

    function __Construct($arquivo) {
        $this->parse_simbolos = file("../tabelas/tabela_simbolos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->parse_sintatica = file("../tabelas/tabela_sintatica.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->parse_codigo = file("../$arquivo", FILE_SKIP_EMPTY_LINES);
    }

    function getTokenCodigo() {
        for ($i = 0; $i < count($this->parse_codigo); $i++) {
            $token[$i] = explode(' ', strtolower(trim($this->parse_codigo[$i])));
        }

        return $token;
    }

    function getTokenSimbolos() {
        for ($i = 0; $i < count($this->parse_simbolos); $i++) {
            $first_token = current(explode(' ', trim($this->parse_simbolos[$i])));
            $token[$first_token] = explode(' ', trim($this->parse_simbolos[$i]));
        }

        $this->token_simbolos = $token;
    }

    function getTokenSintatica() {
        for ($i = 0; $i < count($this->parse_sintatica); $i++) {
            $first_token = current(explode(' ', trim($this->parse_sintatica[$i])));
            $token[$first_token] = explode(' ', trim($this->parse_sintatica[$i]));
        }

        $this->token_sintatica = $token;
    }

    function getErros() {
        if (empty($this->mensagem_erro)) {
            $this->mensagem_erro[] = (['MSG' => 'Compilado com Sucesso.', 'ERRO' => '-1']);
        }
        return $this->mensagem_erro;
    }

    function analiseLexica($token) {
        $this->getTokenSimbolos();

        for ($i = 0; $i < count($token); $i++) {
            for ($a = 0; $a < count($token[$i]); $a++) {

                //verfica se token atual nao existe na tabela de simbolo, se não é numero e se não é uma linha em branco
                if (!array_key_exists($token[$i][$a], $this->token_simbolos) && !is_numeric($token[$i][$a]) && $token[$i][$a] != '') {

                    //verifica se o token inexistente não é uma string ou seja se esta entre aspas e se não é uma variavel
                    if (!preg_match("/^'(.+)'$/", $token[$i][$a]) && !preg_match("/^@(.+)$/", $token[$i][$a])) {
                        $this->mensagem_erro[] = ['MSG' => 'Erro Linha ' . $i . ': Não foi encontrado <strong>' . $token[$i][$a] . '</strong> na tabela de símbolos.<br>', 'ERRO' => $i];
                    }
                }
            }
        }
    }

    function analiseSintatica($token) {
        $this->getTokenSintatica();

        $handle = null;

        for ($i = 0; $i < count($token); $i++) {
            for ($a = 0; $a < count($token[$i]); $a++) {

                //se tiver um  handle em aberto
                if ($handle != null) {
                    if ($handle[$handle_index + 1] == $this->token_simbolos[$token[$i][$a]][1]) {
                        //verifica se a proxima regra sintatica é o atributo do token atual
                        $handle_index++;
                    }
                    if ($handle_index + 1 >= count($handle)) {
                        //verifica se ja foi concluida
                        $handle = null;
                        $handle_index = null;
                        $handle_nome = null;
                    }
                }

                //verifica se o atributo do token atual esta na tabela sintatica
                if (array_key_exists($this->token_simbolos[$token[$i][$a]][1], $this->token_sintatica)) {
                    if ($handle == null) {
                        $handle = $this->token_sintatica[$this->token_simbolos[$token[$i][$a]][1]];
                        $handle_index = 0;
                        $handle_nome = $token[$i][$a];
                    } else {
                        $this->mensagem_erro[] = ['MSG' => 'Erro Linha ' . $i . ': Um novo handle <strong>' . $token[$i][$a] . '</strong> foi aberto antes de finalizar o anterior <br>', 'ERRO' => $i];
                    }
                }
            }
        }
        if ($handle != null) {
            $this->mensagem_erro[] = ['MSG' => 'Erro Sintático no handle <strong>' . $handle_nome . '</strong> falta regras para finalizar esse handle<br>', 'ERRO' => null];
        }
    }

    function analiseSemantica($token) {
        for ($i = 0; $i < count($token); $i++) {
            for ($a = 0; $a < count($token[$i]); $a++) {

                //verifica se uma variavel esta em aberta
                if ($variavel != null) {

                    if ($variavel_index == 0) {
                        //verifico se o nome da variavel foi declarada
                        if (preg_match("/^@(.+)$/", $token[$i][$a])) {
                            $variavel_index++;
                        }
                    } else if ($variavel[$variavel_index] == $this->token_simbolos[$token[$i][$a]][1]) {
                        //verifica se a proxima regra da variavel é o token atual
                        $variavel_index++;
                    }
                    if ($variavel_index >= count($variavel)) {
                        //verifica se ja foi concluida
                        $variavel = null;
                        $variavel_concluida = true;
                        $variavel_index = null;
                    }
                }

                // verifica se o atributo atual é declaração de variavel
                if ($this->token_simbolos[$token[$i][$a]][1] == 'declaravariavel') {
                    $variavel = ['', 'tipovariavel', 'operadoratribuicao', 'fimhandle'];
                    $variavel_index = 0;
                    $variavel_concluida = false;
                }
            }
            if ($variavel_concluida == false) {
                $this->mensagem_erro[] = ['MSG' => 'Erro Semantico, uma variavel não foi concluida na linha <strong>' . $i . '</strong><br>', 'ERRO' => $i];
            }
        }
    }

}
