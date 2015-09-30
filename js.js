//------------------------------------------------------------------------------
function carrega_simbolos(){
    function retorno(ret){
        id("tabela_simbolos").innerHTML = ret;
    }
    ajax('php/simbolos.php', null, retorno);
};

//------------------------------------------------------------------------------
function carrega_codigo(){
    function retorno(ret){
        // exibe e oculta os elementos
        id("btn_salvar").style.display = 'none';
        id("btn_cancelar").style.display = 'none';
        id("btn_compilar").disabled = false;
        
        id("codigo").innerHTML = '<pre>'+ret+'</pre>';
    }
    if(id('path_arquivo').value == ''){
        alert("Envie um arquivo primeiro");
        return;
    }
    var strpar = array_args('codigo', id('path_arquivo').files[0].name);
    ajax('php/codigo.php', strpar, retorno);
};

//------------------------------------------------------------------------------
function edita_codigo(){
    
    function retorno(ret){
        // exibe e oculta os elementos
        id("btn_salvar").style.display = 'inline';
        id("btn_cancelar").style.display = 'inline'; 
        id("btn_compilar").disabled = true;
        
        id("codigo").innerHTML = '<pre contenteditable="true">'+ret+'</pre>';
    }
    var strpar = array_args('codigo', id('path_arquivo').files[0].name);
    ajax('php/codigo_editar.php', strpar, retorno);
}

//------------------------------------------------------------------------------
function salva_codigo(){
    //var novo_codigo = id('novo_codigo').value;
    var novo_codigo = id('codigo').firstElementChild.innerText;
    
    function retorno(ret){
        carrega_codigo();
    }
    var strpar = array_args('novo_codigo', novo_codigo);
    ajax('php/codigo_salvar.php', strpar, retorno);
}

//------------------------------------------------------------------------------
function carrega_compilador(){
    carrega_codigo();                                                           //RECARREGA O CODIGO NA TELA
    id("mensagens").innerHTML = '';                                             //LIMPA O CAMPO
    
    if(erro_referencia != 'undefined'){                                         //CHECA ARRAY REFERENCIA PARA DELETAR CLASSE DE ERRO
        for(var j = 0; j < erro_referencia.length; j++){
            delclasse(id("span_"+erro_referencia[j]));                          //DELETA
        }
        erro_referencia = [];                                                   //SET ARRAY REFERENCIA PARA VAZIO
    }
    
    function retorno(ret){
        ret = JSON.parse(ret);
        
        for(var i = 0; i < ret.length; i++){                                    //CHECA O ARRAY DE RETORNO
            id("mensagens").innerHTML += ret[i].MSG;                            //PRINT A MSG DE ERRO OU SUCESSO
            if(ret[i].ERRO != '-1'){                                            //CHECA SE O ERRO � REALMENTE ERRO
                erro_referencia.push(ret[i].ERRO);                              //ARMAZENA NO ARRAY REFERENCIA PARA USO POSTERIOR
                addclasse(id("span_"+ret[i].ERRO), "vermelho");                 //SETA A CLASSE VERMELHO NO ERRO
            }
        }
    }
    var strpar = array_args('arquivo', id('path_arquivo').files[0].name);
    ajax('php/compila.php', strpar, retorno);
};


var erro_referencia = [];                                                       //DECLARA ARRAY ERRO REFERENCIA
carrega_simbolos();
