//lancement si #imageUne existe sur la page
if(document.getElementById('#imageUne') !== null){
    
    //modification de margin-top sur les pages livres & auteurs pour l'image couverture / auteur
    let imageUne = document.querySelector('#imageUne');
    let hauteurTitre = document.querySelector('.layoutHeader2 h1').clientHeight;

    //calc valeur margin negative à appliquer à l'image
    // -106 = hauteur des margins et paddings à compenser
    let marginNegative = -106 - hauteurTitre;

    //passage de margin negative en strong + px
    marginNegative = marginNegative.toString();
    marginNegative += 'px';

    //application du style
    imageUne.style.marginTop = marginNegative;
}