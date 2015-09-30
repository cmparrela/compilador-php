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

