//------------------------------------------------------------------------------
function carrega_simbolos(){
    function retorno(ret){
        id("tabela_simbolos").innerHTML = ret;
    }
    ajax('php/simbolos.php', null, retorno);
};

//------------------------------------------------------------------------------
function carrega_arquivos(){
    function retorno(ret){
        id("lista_arquivos").innerHTML = ret;
    }
    ajax('php/carrega_arquivos.php', null, retorno);
};

//------------------------------------------------------------------------------
function carrega_codigo(a){
    id("btn_editar").style.display = 'inline';
    
    if(a){
      //caso escolha um arquivo da lista
      id('nome_arquivo').value = a;
    }
    
    function retorno(ret){
        // exibe e oculta os elementos
        id("btn_salvar").style.display = 'none';
        id("btn_cancelar").style.display = 'none';
        id("btn_compilar").disabled = false;
        
        id('path_arquivo').value = '';
        id("titulo_codigo").innerHTML = id('nome_arquivo').value;
        id("codigo").innerHTML = '<pre>'+ret+'</pre>';
    }
    if(id('nome_arquivo').value == ''){
        alert("Envie um arquivo primeiro");
        return;
    }
    var strpar = array_args('codigo', id('nome_arquivo').value);
    ajax('php/codigo.php', strpar, retorno);
};

//------------------------------------------------------------------------------
function edita_codigo(){
    id("btn_editar").style.display = 'none';
    function retorno(ret){
        // exibe e oculta os elementos
        id("btn_salvar").style.display = 'inline';
        id("btn_cancelar").style.display = 'inline'; 
        id("btn_compilar").disabled = true;
        
        id("codigo").innerHTML = '<pre contenteditable="true">'+ret+'</pre>';
    }
    var strpar = array_args('codigo', id('nome_arquivo').value);
    ajax('php/codigo_editar.php', strpar, retorno);
};

//------------------------------------------------------------------------------
function upload_codigo(){
    upload_arquivo('path_arquivo', 'php/upload_arquivo.php');
};

function retorno_upload(ret){
    carrega_arquivos();
    
    ret = JSON.parse(ret);
    ret.COD == 0 ? alert('Arquivo Enviado com Sucesso!') : alert('Erro ao Enviar o Arquivo!');
    
    if(!id('nome_arquivo').value){
        id('nome_arquivo').value = ret.NOME;
    }
    
    carrega_codigo();
};
//------------------------------------------------------------------------------
function salva_codigo(){
    var novo_codigo = id('codigo').firstElementChild.innerText;
    
    function retorno(ret){
        id("btn_editar").style.display = 'inline';
        carrega_codigo();
    }
    var strpar = array_args('novo_codigo', novo_codigo, 'arquivo', id('nome_arquivo').value);
    ajax('php/codigo_salvar.php', strpar, retorno);
};

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
    var strpar = array_args('arquivo', id('nome_arquivo').value);
    ajax('php/compila.php', strpar, retorno);
};


var erro_referencia = [];                                                       //DECLARA ARRAY ERRO REFERENCIA
carrega_simbolos();
carrega_arquivos();
