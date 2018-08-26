document.addEventListener('DOMContentLoaded',cambioLogo);
function setAttributes(elem,attrs){
    for(var key in attrs){
        elem.setAttribute(key,attrs[key]);
    }
}
function cambioLogo(){
    

    var vecchioLogo=document.querySelector('#logo'),
        header = document.querySelector('.header-inner'),
        logo= document.createElement('div'),
        ancora = document.createElement('a'),
        img = new Image();

    vecchioLogo.remove();
    setAttributes(logo,{'id':'logo','class':'flex-col logo'});
    setAttributes(ancora,{'href':'http://grupponew.it','title':'Landing - Landing page di New Printing Evolution','rel':'home'});
    setAttributes(img,{'src':'http://grupponew.com/landing/wp-content/uploads/2018/05/npe_logo_2.png','class':'header_logo header-logo','alt':'Landing','width':'200','height':'100'});
    ancora.appendChild(img);
    logo.appendChild(ancora);
    header.appendChild(logo);  
}