import React from 'react';


export class SearchBar extends React.Component
{
    database = [];  // Base de données en provenance de l'API (côté Symfony)

    state = {
        search      : '',   // Saisie en cours de l'utilisateur
        suggestions : []    // Liste des suggestions
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
            })
    }

    onChangeSearch = (event) =>
    {
        const suggestions = this.database.filter((product) => {
            // Garde uniquement les produits contenant la saisie de l'utilisateur.
            return product.titre.includes(event.target.value);
        });

        this.setState(
        { 
            search      : event.target.value,   // Enregistrement de la saisie
            suggestions : suggestions           // Enregistrement des suggestions
        });
    }

    render()
    {
        // Parcourt la liste des suggestions et les transforme en une liste de <li> JSX.
        const listItems = this.state.suggestions.map((suggestion, index) => {
            return <li key={ index }>{ suggestion.titre }</li>
        });

        return(
            <div className="creact-container">
                <section className="container">
                    <h2>Tous les livres :</h2>
                    <form className="form-inline recherche-livres">
                        <div className="form-group">
                            <label htmlFor="recherche">Recherche : </label>
                            <input type="text" className="form-control mx-sm-3" id="recherche" placeholder="Recherche" value={ this.state.search } onChange={ this.onChangeSearch }/>
                            
                            <ul className="searchSuggestions">
                                { listItems }
                            </ul>

                        </div>
                        <div className="form-group">
                            <label htmlFor="triLivres">Rechercher des livres par : </label>
                            <select className="custom-select form-control mx-sm-3" id="triLivres">
                                <option className="formOption" value="1" defaultValue>titre de livre</option>
                                <option className="formOption" value="2">nom de l'auteur</option>
                                <option className="formOption" value="3">nom de la catégorie</option>
                            </select>
                        </div>
                        
                        <button type="submit" className="btn btn-primary">Lancer la recherche</button>
                    </form>
                </section>
                <section>
                    <div className="containerParallax">
                        <div id="livresBg" className="parallaxElement parallaxBack">
                        </div>
                        <div className="parallaxElement parallaxBase">
                            <div className="container">
                    
                                <div className="card-deck">
                                    
                                        <div className="card mb-4">
                                        <div className="card-img-container">
                                            <img className="card-img-top" src="" alt="Couverture" />
                                        </div>
                                        <div className="card-body">
                                            <h5 className="card-title">

                                            </h5>
                                            
                                            <p className="card-text">
                                            <b>Auteur</b> : 
                                            
                                            </p>
                                            <p className="card-text"><b>Catégorie</b> : 
                                                
                                            </p>
                                            <a href="/livre/{{livre.id}}" className="btn btn-primary">Détails</a>
                                            <a href="/livre/{{livre.id}}" className="btn btn-primary">Emprunter</a>
                                        </div>
                                        <div className="card-footer">
                                            <small className="text-muted">Ajouté à Bouquins le </small>
                                        </div>
                                    </div>
                                    <div className="paginationElementLoader"><button className="btn btn-primary">Charger plus de livres</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        );
    }
    
}