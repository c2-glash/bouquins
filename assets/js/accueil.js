
//lancement si #carousel existe sur la page
if(document.getElementById('carousel') !== null){
    //ajout classe "active" à la 1ere slide du slider sur l'accueil
    let slides = document.querySelectorAll('.carousel-item');
    let slideUne = slides[0];
    slideUne.className += " active";
    let carouselControls = document.querySelectorAll('.carouselControl');
    let controlUn = carouselControls[0];
    controlUn.className += " active";
}