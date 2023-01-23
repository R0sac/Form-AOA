//CREA ELEMENTOS DOM SIN ID INCLUIDO
function createElements(parent,elementDOM, classes,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" class="+classes+">") 
    }
}

//CREA ELEMENTOS DOM CON ID INCLUIDO
function createElements2(parent,elementDOM, classes,ids,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" id='"+ids+"' class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" id='"+ids+"' class="+classes+">") 
    }
}