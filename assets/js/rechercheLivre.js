//lancement JS sous reserve que #resultatsOpenLibrary (le bloc d'affichage des résultats de recherche) soit sur la page en question
if(document.getElementById('resultatsOpenLibrary') !== null){

    /**
     * Liens de l'API Open library : 
     * Doc : https://openlibrary.org/developers/api
     * Exemple recherche isbn : https://openlibrary.org/isbn/1436233283.json
     * Exemple recherche auteur : https://openlibrary.org/authors/OL79034A.json
     * Exemple recherche par titre : http://openlibrary.org/search.json?title=dune
     * Exemple URL image : https://covers.openlibrary.org/b/id/1847148-L.jpg  //-L.jpg, -M.jpg, -S.jpg
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

    //definition var auteurs non existants et boolean existance auteur
    let auteursNonExistant = '';
    let compteAuteurExistant = 0;

    //definition variables de stockage du Json en HTML
    let JSONtoHTMLIsbn = '';
    let JSONtoHTMLAuteur = '';
    let JSONtoHTMLTitre = '';

    //definition var nom auteur pour fn recherche auteur et tableau d'auteur pour l'isbn
    let nomAuteur = '';
    let auteurIsbn = [];

    //definition de la liste de resultats
    let listeResultatsHTML = '';

    //recuperation des champs du formuaire à remplir
    const champTitre = document.getElementById('livre_form_titre');
    const champIsbn = document.getElementById('livre_form_isbn');
    const champCouvertureUrl = document.getElementById('livre_form_url_externe_couverture');
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

    //recherche par ISBN retournant 1 resultat
    function LancementRechercheIsnb(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //suppression de l'éventuel message d'erreur précédent et résultats de recherche
        formResult.innerHTML = ``;

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="rechercheisbn"]').value;
        
        //verification que le champ de recherche est correctement renseigné
        if(inputData === ""){

            //affichage du message d'erreur
            formResult.innerHTML = `
            <div class="alert alert-danger">
                Veuillez renseigner l'ISBN avant de lancer la recherche.
            </div>`;
        
        } 

        //verification que l'input ne contient que des chiffres
        else if(inputData.match(/^[0-9]+$/) === null || inputData.length < 10) {

            //affichage du message d'erreur
            formResult.innerHTML = `
            <div class="alert alert-danger">
                Un ISBN ne peut contenir que 10 (en ommettant 978) ou 13 chiffres (en commencant avec 978).
            </div>`;
        }

        //sinon on peut soumettre la requete à openlib  
        else { 

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
                
                //affichage du message d'erreur
                formResult.innerHTML = `
                <div class="alert alert-danger">
                    Aucun résultat disponible sur Openlibrary.org pour cet ISBN. Vérifiez l'isbn ou essayez une recherche par titre de livre.
                </div>`;
            })
        }
    }

    //fn de recherche d'auteur lancée par la fn de recherche par ISBN
    //et affichage resultats + chargement data disponible dans les champs du form
    function LancementRechercheAuteur()
    {
        //reset variables nomAuteur et auteurIsbn
        nomAuteur = '';
        auteurIsbn = [];

        //pour chaque clé auteur listée dans la requete isbn, on boucle une requete ajax
        for(let i = 0; i < JSONtoHTMLIsbn.authors.length; i++){

            //lancement de la fonction ajaxHTML avec l'url de recherche auteur
            ajaxHTML(`https://openlibrary.org${JSONtoHTMLIsbn.authors[i].key}.json`)
            .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML

                //parsage du json stocké
                JSONtoHTMLAuteur = JSON.parse(response);
                
                //stockage nom de l'auteur
                nomAuteur += JSONtoHTMLAuteur.name + ' ';

                //ajout du nom de l'auteur au tableau
                auteurIsbn.push(JSONtoHTMLAuteur.name);

                //si la boucle est la dernière
                if(i === JSONtoHTMLIsbn.authors.length - 1){

                    //affichage du HTML pour les fn LancementRechercheIsnb() et LancementRechercheAuteur()
                    formResult.innerHTML += `
                    <ul class="liste-resultats-titre">
                        <li class="resultatlivre"><img src="https://covers.openlibrary.org/b/id/${couvertureLivre}-S.jpg" alt="couverture ${titreLivre}"/><p>${titreLivre} - ${nomAuteur}</p></li>
                    </ul>`;
                }

                //apres affichage, lancement boucle fn 
                //pour retourner le data attribute de chaque element au click
                let resultatsSelect = document.getElementsByClassName('resultatlivre');

                for(let i = 0; i < resultatsSelect.length; i++) {

                    //au clic -> lancement fn pour charger les values des champs du form
                    resultatsSelect[i].addEventListener("click", function() {
                        console.log('chargement data dans les champs');
                        
                        //set value du champ titre
                        champTitre.setAttribute('value', JSONtoHTMLIsbn.title);
                        console.log(`set ${JSONtoHTMLIsbn.title}`);
                        
                        //set value du champ isbn
                        champIsbn.setAttribute('value', JSONtoHTMLIsbn.isbn_13[0]);
                        console.log(`set ${JSONtoHTMLIsbn.isbn_13[0]}`);

                        //set value du champ URl couverture externe
                        champCouvertureUrl.setAttribute('value', `https://covers.openlibrary.org/b/id/${JSONtoHTMLIsbn.covers[0]}-L.jpg`);
                        console.log(`set ${JSONtoHTMLIsbn.covers[0]}`);
                        
                        //de-selection du champ auteur avant de lancer la boucle de selection
                        champAuteur.selectedIndex = - 1;
                        
                        //reset de compteAuteurExistant
                        compteAuteurExistant = 0;
                    
                        //selection du champ auteur : pour chaque auteur du livre/resultat cliqué : 
                        for(i = 0; i < auteurIsbn.length; i++){
                            
                            //pour chaque option du champ select auteur du form
                            for(j = 0; j < champAuteur.options.length; j++){

                                //si le nom de l'auteur sélectionné dans les resultat est identique a l'auteur du champ select du form
                                if(auteurIsbn[i] === champAuteur.options[j].innerText){
                                    //on selectionne l'option du select correspondante
                                    champAuteur.selectedIndex = j;
                                    //on incrémente le compteur d'auteurs existants
                                    compteAuteurExistant++;
                                }
                            }
                        }

                        //on affiche le message d'erreur si le nombre d'auteurs du livre est différent du compte d'auteurs existants
                        if(compteAuteurExistant !== auteurIsbn.length){
                            formResult.innerHTML += `
                            <div class="alert alert-danger">
                                Un ou plusieurs auteurs de ce livre n'ont pas été créés, <a href="/ajout/auteur">veuillez procéder à leur création</a> avant de créer ce livre.
                            </div>`;
                        }
                    })
                }
            }).catch(function (requeteAjaxHTML){
                //en cas d'échec de la requete
                console.log(`erreur : ${requeteAjaxHTML}`);

                //affichage du message d'erreur
                formResult.innerHTML = `
                <div class="alert alert-danger">
                    L'auteur du livre n'a pas été trouve sur Openlibrary.org, ou la requete a échouée.
                </div>`;
            })
        }
    }

    //fn de recherche par titre retoutnant plusieurs resultats
    function LancementRechercheTitre(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //suppression de l'éventuel message d'erreur précédent et résultats de recherche
        formResult.innerHTML = ``;

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="recherchetitre"]').value;

        //verification que le champ de recherche n'est pas vide
        if(inputData === ""){

            //affichage du message d'erreur
            formResult.innerHTML += `
            <div class="alert alert-danger">
                Veuillez renseigner le champ titre du livre avant de lancer la recherche.
            </div>`;
        } 

        //sinon on peut soumettre la requete à openlib  
        else {

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
                formResult.innerHTML += listeResultatsHTML;

                //apres affichage, lancement boucle fn 
                //pour retourner le data attribute de chaque element au click
                let resultatsSelect = document.getElementsByClassName('resultatlivre');

                for(let i = 0; i < resultatsSelect.length; i++) {

                    //au clic -> lancement fn pour charger les values des champs du form
                    resultatsSelect[i].addEventListener("click", function() {
                        console.log('chargement data dans les champs');
                        
                        //recuperation de l'index du résultat cliqué
                        let resultatLivre = this.getAttribute('data-resultat-livre');
                        
                        //set value du champ titre
                        champTitre.setAttribute('value', JSONtoHTMLTitre.docs[resultatLivre].title);
                        console.log(`set ${JSONtoHTMLTitre.docs[resultatLivre].title}`);
                        
                        //set value du champ isbn
                        champIsbn.setAttribute('value', JSONtoHTMLTitre.docs[resultatLivre].isbn[0]);
                        console.log(`set ${JSONtoHTMLTitre.docs[resultatLivre].isbn[0]}`);

                        //set value du champ URl couverture externe
                        champCouvertureUrl.setAttribute('value', `https://covers.openlibrary.org/b/id/${JSONtoHTMLTitre.docs[i].cover_i}-L.jpg`);
                        console.log(`set ${JSONtoHTMLTitre.docs[i].cover_i}`);
                        
                        //de-selection du champ auteur avant de lancer la boucle de selection
                        champAuteur.selectedIndex = - 1;
                        
                        //reset de compteAuteurExistant
                        compteAuteurExistant = 0;

                        //selection du champ auteur : pour chaque auteur du livre/resultat cliqué : 
                        for(i = 0; i < JSONtoHTMLTitre.docs[resultatLivre].author_name.length; i++){
                            
                            auteurLivre = JSONtoHTMLTitre.docs[resultatLivre].author_name[i];

                            //pour chaque option du champ select auteur du form
                            for(j = 0; j < champAuteur.options.length; j++){

                                //si le nom de l'auteur sélectionné dans les resultat est identique a l'auteur du champ select du form
                                if(auteurLivre === champAuteur.options[j].innerText){
                                    //on selectionne l'option du select correspondante
                                    champAuteur.selectedIndex = j;
                                    //on incrémente le compteur d'auteurs existants
                                    compteAuteurExistant++;
                                }
                            }
                        }

                        //on affiche le message d'erreur si le nombre d'auteurs du livre est différent du compte d'auteurs existants
                        if(compteAuteurExistant !== JSONtoHTMLTitre.docs[resultatLivre].author_name.length){
                            formResult.innerHTML += `
                            <div class="alert alert-danger">
                                Un ou plusieurs auteurs de ce livre n'ont pas été créés, <a href="/ajout/auteur">veuillez procéder à leur création</a> avant de créer ce livre.
                            </div>`;
                        }
                    })
                }
            }).catch(function (requeteAjaxHTML){
                //en cas d'échec de la requete
                console.log(`erreur : ${requeteAjaxHTML}`);

                //affichage du message d'erreur
                formResult.innerHTML += `
                <div class="alert alert-danger">
                    Aucun résultat disponible sur Openlibrary.org pour cette recherche, ou la requete a échouée. Essayez de changer les mot-clés ou tentez une recherche par ISBN.
                </div>`;
            })
        }
    }
}