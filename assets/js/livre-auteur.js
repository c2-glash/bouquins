console.log('livre-auteur.js');

let imageUne = document.querySelector('#imageUne');
let hauteurTitre = document.querySelector('.layoutHeader2 h1').clientHeight;

console.log(hauteurTitre);

//calc valeur margin negative à appliquer à l'image
let marginNegative = -106 - hauteurTitre;

//passage de margin negative en strong + px
marginNegative = marginNegative.toString();
marginNegative += 'px';

console.log(marginNegative);

//application du style
imageUne.style.marginTop = marginNegative;
