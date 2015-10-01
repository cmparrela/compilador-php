//----------------------------------------------------------------------------//
function addclasse(id, classe){
    id.className = classe;
    return;
};

//----------------------------------------------------------------------------//
function delclasse(id){
    id.className = "";
    return;
};

//----------------------------------------------------------------------------//
function id(campo){
    return(document.getElementById(campo));
};

//----------------------------------------------------------------------------//
function rand(tamanho) {
    tamanho == 'undefined' ? tamanho = 32 : tamanho;
    tamanho > 32 ? tamanho = 32 : tamanho;
    
    return Math.random().toString(tamanho).substr(2);
};
function token(tamanho) {
    return rand(tamanho) + rand(tamanho);
};

//----------------------------------------------------------------------------//
function upload_arquivo(id_input, php_alvo){
    
    function envia_arquivo(){
        var form                = document.createElement('form');
            form.style.display  = 'none';
            form.action         = php_alvo;
            form.target         = iframe;
            form.enctype        = form.encoding = 'multipart/form-data';
            form.method         = 'POST';
            form.appendChild(id(id_input));

            document.body.appendChild(form);
            form.submit();
            
        var novo_input                  = document.createElement('input');
            novo_input.type             = 'file';
            novo_input.name             = id_input;
            novo_input.id               = id_input;
            novo_input.style.paddingTop = "10px";
            document.getElementById('ctn_input').appendChild(novo_input);
    };
    
    var iframe               = 'iframe_' + token(32);
    var frame                = document.createElement('iframe');
        frame.style.display  = 'none';
        frame.id             = iframe;
        frame.name           = iframe;
        
  document.body.appendChild(frame);
  setTimeout(envia_arquivo, 250);
};
