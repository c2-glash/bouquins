import React from 'react';
import { CardLivre } from './components/CardLivre';


export class SearchBar extends React.Component
{
    database = [];  // Base de données en provenance de l'API (côté Symfony)

    state = {
        search      : '',   // Saisie en cours de l'utilisateur
        suggestions : [],   // Liste des suggestions
        dbdata      : [],
        detailsutilisateur : [],
    };

    
    // Ne sera exécuté qu'une seule fois, à la construction du composant SearchBar
    componentDidMount()
    {
        // Exécution d'une requête HTTP GET vers l'API
        window.fetch('https://localhost:8000/api/livres')
            .then((httpResponse) =>
            {
                // Traduit la réponse HTTP brute en du JSON.
                return httpResponse.json();
            })
            .then((jsonResults) =>
            {
                // Stockage des données
                this.database = jsonResults;

                this.setState(
                {
                    dbdata : this.database
                });

            })
            

        // Exécution d'une requête HTTP GET vers l'API
        window.fetch('https://localhost:8000/api/user')
            .then((httpResponse) =>
            {
                // Traduit la réponse HTTP brute en du JSON.
                return httpResponse.json();
            })
            .then((jsonResults) =>
            {
                // Stockage des données
                this.detailsUtilisateur = jsonResults;

                this.setState(
                {
                    detailsutilisateur : jsonResults
                });

                
            })
    }

    onChangeSearch = (event) =>
    {

        const suggestions = this.database.filter((livre) => {
            // Garde uniquement les produits contenant la saisie de l'utilisateur.
            //toLowerCase() pour ignorer la casse lors de la recherche
            return livre.titre.toLowerCase().includes(event.target.value.toLowerCase());
        });

        this.setState(
        { 
            search      : event.target.value,   // Enregistrement de la saisie
            suggestions : suggestions           // Enregistrement des suggestions
        });
        
    }

    onFocus(){
        if(document.getElementById('searchSuggestions') !== null){
            let listeSuggestions = document.getElementById('searchSuggestions');
            listeSuggestions.classList.add("d-block");
            listeSuggestions.classList.remove("d-none");
        }
    }
    onBlur(){
        //délais pour laisser le temps du click, 300ms
        setTimeout(() => {
            if(document.getElementById('searchSuggestions') !== null){
                let listeSuggestions = document.getElementById('searchSuggestions');
                listeSuggestions.classList.add("d-none");
                listeSuggestions.classList.remove("d-block");
            }
        }, 300);
        
    }
    
    render()
    {
        // Parcourt la liste des suggestions et les transforme en une liste de <li> JSX.
        const listesuggestions = this.state.suggestions.map((suggestion, index) => {
            //affichage des résultat à partir de 2 chars dans la recherche 
            if(this.state.search.length > 1){
                return <li key={ index }><a href={'/livre/' + suggestion.id }>{ suggestion.titre }</a></li>
            }
        });
        
        //affichage complet par défaut

        let cardsSuggestions = this.database.map((livre, index) => {
            return (
                <CardLivre 
                    key =           { index }
                    id =            { livre.id }
                    titre =         { livre.titre }
                    description =   { livre.description }
                    dateAjout =     { livre.date_ajout}
                    categorie =     { livre.categories[0].nom }
                    urlCouverture = { livre.url_couverture }
                    nomAuteur =     { livre.auteurs[0].nom }
                    prenomAuteur =  { livre.auteurs[0].prenom }
                    estEmpruntable = { livre.est_empruntable }
                    estloggue =     { livre.utilisateur_loggue }
                ></CardLivre>
            )
        });

        let textNoResults = null;

        //affichage des résultat à partir de 2 chars dans la recherche 
        if(this.state.search.length > 1){
            cardsSuggestions = this.state.suggestions.map((livre, index) => {
                return (
                    <CardLivre 
                        key =           { index }
                        id =            { livre.id }
                        titre =         { livre.titre }
                        description =   { livre.description }
                        dateAjout =     { livre.dateAjout}
                        categorie =     { livre.categories[0].nom }
                        urlCouverture = { livre.url_couverture }
                        nomAuteur =     { livre.auteurs[0].nom }
                        prenomAuteur =  { livre.auteurs[0].prenom }
                        estEmpruntable = { livre.est_empruntable }
                        estloggue =     { livre.utilisateur_loggue } 
                    ></CardLivre>
                )
            });

            if(cardsSuggestions.length == 0){
                textNoResults = <div className="paginationElementLoader"><button className="btn btn-primary">Aucun résultat pour cette recherche</button></div>;
            }
        }

        return(
            <div id="react-SearchBar">
                <section className="container">
                    <div className="creact-container">
                        <h2>Tous les livres :</h2>
                        <form className="recherche-livres" onFocus={this.onFocus} onBlur={this.onBlur}>
                            <div className="form-group">
                                <input type="text" className="form-control mx-sm-3" id="recherche" placeholder="Recherche" value={ this.state.search } onChange={ this.onChangeSearch }/>
                                <ul id="searchSuggestions">
                                    { listesuggestions }
                                </ul>

                                
                            </div>
                        </form>
                       
                    </div>
                </section>
                <section>
                    <div className="containerParallax">
                        <div id="livresBg" className="parallaxElement parallaxBack">
                        </div>
                        <div className="parallaxElement parallaxBase">
                            <div className="container">
                    
                                <div className="card-deck">
                                    
                                    { cardsSuggestions }

                                    { textNoResults }
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        );
        /*
        <div className="form-group">
            <label htmlFor="triLivres">Rechercher des livres par : </label>
            <select className="custom-select form-control mx-sm-3" id="triLivres">
                <option className="formOption" value="1" defaultValue>titre de livre</option>
                <option className="formOption" value="2">nom de l'auteur</option>
                <option className="formOption" value="3">nom de la catégorie</option>
            </select>
        </div>
        */
    }
    
}