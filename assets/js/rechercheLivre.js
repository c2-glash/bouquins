//lancement JS sous reserve que #resultatsOpenLibrary soit sur la page en question
if(document.getElementById('resultatsOpenLibrary') !== null){

    //recuperation de l'element contenant le HTML à générer à partir du json pour le livre
    const formResult = document.getElementById('resultatsOpenLibrary');

    //recuperation de l'element contenant le HTML à générer à partir du json pour l'auteur
    const formResultAuteur = document.getElementById('resultatsOpenLibraryAuteur');

    //lancement fonction lancementRechercheISBN au submit du form
    const formRechercheIsbn = document.getElementById('rechercheolisbn');
    formRechercheIsbn.addEventListener("submit", LancementRechercheIsnb);

    //lancement fonction lancementRechercheTitre au submit du form
    const formRechercheTitre = document.getElementById('rechercheoltitre');
    formRechercheTitre.addEventListener("submit", LancementRechercheTitre);

    //definition var auteur et livre
    let auteurLivre = '';
    let titreLivre = '';

    //fonction chargement contenu ajax
    let ajaxHTML = function (url){
        console.log("requete Ajax");
        return new Promise(function(resolve, reject){
            let requeteAjaxHTML = new XMLHttpRequest();

            //requete GET avec fichier à charger en asynchrone = true
            requeteAjaxHTML.open("GET", url, true)

            requeteAjaxHTML.onreadystatechange = function(event){
                if (requeteAjaxHTML.readyState == 4) {
                    if(requeteAjaxHTML.status == 200) {
                        //affichage du contenu du doc de la requete GET
                        //resolve(conteneurHTML.innerHTML = requeteAjaxHTML.responseText);
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

    function LancementRechercheIsnb(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="rechercheisbn"]').value;

        console.log(`chargement livre ISBN n° ${inputData}`);

        //lancement de la fonction correspondante aux retours du form
        ajaxHTML(`https://openlibrary.org/isbn/${inputData}.json`)
        .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
            
            console.log("requete réussie");
            
            //parsage du json stocké
            JSONtoHTML = JSON.parse(response);
            
            //definition des éléments du livre à afficher
            titreLivre = JSONtoHTML.title;
            auteurLivre = JSONtoHTML.authors[0].key;
            let couvertureLivre = JSONtoHTML.covers[0];

            
            //affichage du HTML
            formResult.innerHTML = `
            <p><b>Titre</b> : ${titreLivre}
            <br/><b>Couverture</b> : 
            <br/><img src="https://covers.openlibrary.org/b/id/${couvertureLivre}-L.jpg">
            </p>`;

            LancementRechercheAuteur();
            
        }).catch(function (requeteAjaxHTML){
            //en cas d'échec de la requete
            console.log(`erreur : ${requeteAjaxHTML}`);
        })
    }

    function LancementRechercheAuteur()
    {
        console.log(`chargement auteur du livre ${titreLivre}`);

        //lancement de la fonction correspondante aux retours du form
        ajaxHTML(`https://openlibrary.org/${auteurLivre}.json`)
        .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
            
            console.log("requete Auteur réussie");
            
            //parsage du json stocké
            JSONtoHTML = JSON.parse(response);
            
            //definition des éléments de l'auteur à afficher
            let nomAuteur = JSONtoHTML.name;
            
            //affichage du HTML de l'image
            formResultAuteur.innerHTML = `
            <p><b>Auteur</b> : ${nomAuteur}</p>`;
            
        }).catch(function (requeteAjaxHTML){
            //en cas d'échec de la requete
            console.log(`erreur : ${requeteAjaxHTML}`);
        })
    }

    function LancementRechercheTitre(event)
    {
        //pour bloquer l'envoi du form
        event.preventDefault();

        //recuperation du contenu des champs du form
        let inputData = document.querySelector('input[name="recherchetitre"]').value;

        console.log(`Recherche avec titre = ${inputData}`);

        //lancement de la fonction correspondante aux retours du form
        ajaxHTML(`https://openlibrary.org/search.json?q=title%3A${inputData}`)
        .then(function (response){//reponse retourne le resolve de la fn dans ajaxHTML
            
            console.log("requete recherche titre réussie");
            
            //parsage du json stocké
            JSONtoHTML = JSON.parse(response);
            console.log(`nombre de resultats de la recherche : ${JSONtoHTML.docs.length}`);

            let resultatsHTML = '';

            //definition d'un nombre max de résultats
            let limiteResultats = 10;
            if(JSONtoHTML.docs.length < 10){
                limiteResultats = JSONtoHTML.docs.length;
            }

            for(i = 0; i < limiteResultats; i++ ){
                //definition des éléments du livre à afficher
                titreLivre = JSONtoHTML.docs[i].title;
                auteurLivre = '';
                if(JSONtoHTML.docs[i].author_name !== undefined){
                    for(j = 0; j < JSONtoHTML.docs[i].author_name.length; j++){
                        auteurLivre += `${JSONtoHTML.docs[i].author_name[j]} `;
                    }
                }
                //chargement HTML
                resultatsHTML += `<p class="resultatlivre">${titreLivre} - ${auteurLivre}</p>`;
            }
            //affichage du HTML
            formResult.innerHTML = resultatsHTML;
           
            
        }).catch(function (requeteAjaxHTML){
            //en cas d'échec de la requete
            console.log(`erreur : ${requeteAjaxHTML}`);
        })
    }
}