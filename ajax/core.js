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
function ajax(link,par,callback){
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
    
    if(par != 'undefined'){
        var url = link + '?' + par;
    }
    xmlHttp.onreadystatechange = function () {
        if(xmlHttp.readyState == 4){
            if (xmlHttp.status == 200) {                                        //STATUS 200: 'OK'
                callback(xmlHttp.responseText);
            }
        }
    }
    xmlHttp.open('GET', url, true);
    xmlHttp.setRequestHeader('content-type','text/html; charset=utf-8');
    xmlHttp.send();
};