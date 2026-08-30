/*CACHE LA BOITE DE PAYEMENT*/
const btn_avance= document.querySelector('#Avance');
const boite= document.querySelector('.payement');

btn_avance.addEventListener('click', function(){
   boite.style.display='block';
});

/*Envoie du paiement*/
const btn_retour= document.querySelector('#btn_retour');
const btn_payer= document.querySelector('#paiement_envoie');
const texte= document.querySelector('#texte');
const reussi= document.getElementById('envoie_reussi');

btn_payer.addEventListener('click', function (){
    btn_payer.style.display='none';
    texte.style.display='none';
    reussi.textContent='paiement validé et envoyé';
});

btn_retour.addEventListener('click', function(){
    if(boite.style.display=='block'){
        boite.style.display='none';
    }
});
