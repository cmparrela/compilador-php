//----------------------------------------------------------------------------//
function array_args(){
    var argumentos = [];
    for(var i = 0;i < arguments.length; i+= 2){
            if(typeof(arguments[i+1]) != 'undefined'){
                    argumentos.push(arguments[i] + '=' + encodeURIComponent(arguments[i+1]));			
            }
    }
    return argumentos.join('&');
};
//----------------------------------------------------------------------------//
function ajax(url,par,callback, tipo){
    tipo = tipo || 'GET';
    
    if(typeof par == 'object'){
        tipo = 'POST';
    }
    var xmlHttp = null;
    
    if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera 8.0+, Safari
    } else {
        try {                           // < IE7
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(e){
                xmlHttp = null;
            }
        }
    }
    
    if(tipo == 'GET'){
        if(par != 'undefined'){
            url = url + '?' + par;
        }
        xmlHttp.open(tipo, url, true);
        xmlHttp.setRequestHeader('content-type','text/html; charset=utf-8');
    }else{
        xmlHttp.open(tipo, url, true);
        if(typeof par != 'object'){
          xmlHttp.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=utf-8');
        }
    }
    
    xmlHttp.setRequestHeader('Cache-Control','no-store, no-cache, must-revalidate');
    xmlHttp.onreadystatechange = function (){
        if(xmlHttp.readyState == 4){
            if (xmlHttp.status == 200){
                callback(xmlHttp.responseText);
            }else{
                callback(xmlHttp.status, xmlHttp.statusText);
            }
        }
    }
    xmlHttp.send(par);
};