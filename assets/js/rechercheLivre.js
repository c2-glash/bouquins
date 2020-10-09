//lancement JS sous reserve que #resultatsOpenLibrary soit sur la page en question
if(document.getElementById('resultatsOpenLibrary') !== null){

    /**
     * Liens de l'API Open library : 
     * Doc : https://openlibrary.org/developers/api
     * Exemple recherche isbn : https://openlibrary.org/isbn/1436233283.json
     * Exemple recherche auteur : https://openlibrary.org/authors/OL79034A.json
     * Exemple recherche par titre : http://openlibrary.org/search.json?title=dune
     * Exemple URL image : https://covers.openlibrary.org/b/id/1847148-L.jpg  //-L, -M, -S
     */

    //recuperation de l'element allant contenir les resultats de recherche
    const formResult = document.getElementById('resultatsOpenLibrary');

    //lancement fonction lancementRechercheISBN au submit du form
    const formRechercheIsbn = document.getElementById('rechercheolisbn');
    formRechercheIsbn.addEventListener("submit", LancementRechercheIsnb);

    //lancement fonction lancementRechercheTitre au submit du form
    const formRechercheTitre = document.getElementById('rechercheoltitre');
    formRechercheTitre.addEventListener("submit", LancementRechercheTitre);

    //definition d'un nombre max de résultats pour la recherche par titre
    let limiteResultats = 15;

    //definition var auteur et livre
    let auteurLivre = '';
    let titreLivre = '';

    //definition variables de stockage du Json en HTML
    let JSONtoHTMLIsbn = '';
    let JSONtoHTMLAuteur = '';
    let JSONtoHTMLTitre = '';

    //definition var nom auteur pour fn recherche auteur
    let nomAuteur = '';

    //definition de la liste de resultats
    let listeResultatsHTML = '';

    //recuperation des champs du formuaire à remplir
    const champTitre = document.getElementById('livre_form_titre');
    const champIsbn = document.getElementById('livre_form_isbn');
    //const champDescription = document.getElementById('livre_form_description');
    //const champCouverture = document.getElementById('livre_form_url_couverture');
    const champAuteur = document.getElementById('livre_form_auteurs');

    //fonction chargement contenu ajax
    let ajaxHTML = function (url){
        return new Promise(function(resolve, reject){
            let requeteAjaxHTML = new XMLHttpRequest();

            //requete GET avec fichier à charger en asynchrone = true
            requeteAjaxHTML.open("GET", url, true)

            requeteAjaxHTML.onreadystatechange = function(event){
                if (requeteAjaxHTML.readyState == 4) {
                    if(requeteAjaxHTML.status == 200) {
                        resolve(requeteAjaxHTML.responseText);
                    } else {
                        reject(requeteAjaxHTML);
                    }
                }
            };
            
            //envoi de la requete
            requeteAjaxHTML.send(null);
        })
    }

    //fn de recherche par ISBN retournant 1 resultat
    function LancementRechercheIsnb(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="rechercheisbn"]').value;

        //lancement de la fonction ajaxHTML avec l'url de recherche isbn
        ajaxHTML(`https://openlibrary.org/isbn/${inputData}.json`)
        .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
            
            //parsage du json et stockage stocké
            JSONtoHTMLIsbn = JSON.parse(response);
            
            //stockage des éléments du livre à afficher
            titreLivre = JSONtoHTMLIsbn.title;
            couvertureLivre = JSONtoHTMLIsbn.covers[0];
            
            //lancement de la fn recherche auteur car nom de l'auteur non stocké dans le json récupéré par la requete
            LancementRechercheAuteur();
            
        }).catch(function (requeteAjaxHTML){
            //en cas d'échec de la requete
            console.log(`erreur : ${requeteAjaxHTML}`);
        })
    }

    //fn de recherche d'auteur lancée par la fn de recherche par ISBN
    function LancementRechercheAuteur()
    {
        //reset variable nomAuteur
        nomAuteur = '';
        //pour chaque clé auteur listée dans la requete isbn, on boucle une requete ajax
        for(let i = 0; i < JSONtoHTMLIsbn.authors.length; i++){

            //lancement de la fonction ajaxHTML avec l'url de recherche auteur
            ajaxHTML(`https://openlibrary.org${JSONtoHTMLIsbn.authors[i].key}.json`)
            .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
   
                //parsage du json stocké
                JSONtoHTMLAuteur = JSON.parse(response);
                
                //stockage nom de l'auteur
                nomAuteur += JSONtoHTMLAuteur.name + ' ';

                //si la boucle est la dernière
                if(i === JSONtoHTMLIsbn.authors.length - 1){

                    //affichage du HTML pour les fn LancementRechercheIsnb() et LancementRechercheAuteur()
                    formResult.innerHTML = `
                    <ul class="liste-resultats-titre">
                        <li class="resultatlivre"><img src="https://covers.openlibrary.org/b/id/${couvertureLivre}-S.jpg" alt="couverture ${titreLivre}"/><p>${titreLivre} - ${nomAuteur}</p></li>
                    </ul>`;
                }
            }).catch(function (requeteAjaxHTML){
                //en cas d'échec de la requete
                console.log(`erreur : ${requeteAjaxHTML}`);
            })
        }
        
    }

    //fn de recherche par titre retoutnant plusieurs resultats
    function LancementRechercheTitre(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="recherchetitre"]').value;

        //lancement de la fonction ajaxHTML avec l'url de recherche par titre
        ajaxHTML(`https://openlibrary.org/search.json?title=${inputData}`)
        .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
            
            //parsage du json stocké
            JSONtoHTMLTitre = JSON.parse(response);

            //limite du nombre de résultats affichés (voir let limiteResultats = x; en debut de page)
            if(JSONtoHTMLTitre.docs.length < limiteResultats){
                limiteResultats = JSONtoHTMLTitre.docs.length;
            }

            //début de liste résultats
            listeResultatsHTML = '<ul class="liste-resultats-titre">';

            for(i = 0; i < limiteResultats; i++ ){

                //definition des éléments du livre à afficher
                titreLivre = JSONtoHTMLTitre.docs[i].title;
                couvertureLivre = `https://covers.openlibrary.org/b/id/${JSONtoHTMLTitre.docs[i].cover_i}-S.jpg`;

                //chargement image filler si la couverture n'est pas disponible
                if(JSONtoHTMLTitre.docs[i].cover_i === undefined){
                    couvertureLivre = 'https://via.placeholder.com/42x54/292726.png?text=@';
                }
                
                //reset variable auteurLivre si plusieurs recherches sont lancées
                auteurLivre = '';

                //verification existance d'un auteur
                if(JSONtoHTMLTitre.docs[i].author_name !== undefined){

                    //boucle sur tous les auteurs
                    for(j = 0; j < JSONtoHTMLTitre.docs[i].author_name.length; j++){

                        //gestion des espaces entre noms d'auteurs et titre
                        if(j > 0){
                            auteurLivre += ` & ${JSONtoHTMLTitre.docs[i].author_name[j]} `;
                        } else {
                            auteurLivre += ` - ${JSONtoHTMLTitre.docs[i].author_name[j]}`;
                        }
                    }
                }

                //creation li HTML pour chaque résultat et ajout à la liste
                listeResultatsHTML += `<li class="resultatlivre" data-resultat-livre="${i}"><img src="${couvertureLivre}" alt="couverture ${titreLivre}"/><p>${titreLivre}${auteurLivre}</p></li>`;
            }

            //fin de la liste de résultats
            listeResultatsHTML += '</ul>';

            //affichage du HTML
            formResult.innerHTML = listeResultatsHTML;

            //apres affichage, lancement boucle fn 
            //pour retourner le data attribute de chaque element au click
            let resultatsSelect = document.getElementsByClassName('resultatlivre');
            for(let i = 0; i < resultatsSelect.length; i++) {

                //au clic -> lancement fn pour charger les values des champs du form
                resultatsSelect[i].addEventListener("click", function() {

                    //recuperation de l'index du résultat cliqué
                    let resultatLivre = this.getAttribute('data-resultat-livre');

                    //set value du champ titre
                    champTitre.setAttribute('value', JSONtoHTMLTitre.docs[resultatLivre].title);
                    
                    //set value du champ isbn
                    champIsbn.setAttribute('value', JSONtoHTMLTitre.docs[resultatLivre].isbn[0]);

                    //de-selection du champ auteur avant de lancer la boucle de selection
                    champAuteur.selectedIndex = - 1;

                    //selection du champ auteur : pour chaque auteur du livre/resultat cliqué : 
                    for(i = 0; i < JSONtoHTMLTitre.docs[resultatLivre].author_name.length; i++){
                        
                        auteurLivre = JSONtoHTMLTitre.docs[resultatLivre].author_name[i];

                        //pour chaque option du champ select auteur du form
                        for(j = 0; j < champAuteur.options.length; j++){

                            //si le nom de l'auteur sélectionné dans les resultat est identique a l'auteur du champ select du form
                            if(auteurLivre === champAuteur.options[j].innerText){
                                //on selectionne l'option du select correspondante
                                champAuteur.selectedIndex = j;
                            } else {
                                //lancer une creation d'auteur pour l'auteur non existant
                            }
                        }
                    }
                })
            }
        }).catch(function (requeteAjaxHTML){
            //en cas d'échec de la requete
            console.log(`erreur : ${requeteAjaxHTML}`);
        })
    }
}