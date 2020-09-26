//import de react obligatoire
import React from 'react';

//export de la classe pour pouvoir l'importer plus tard
export class CardLivre extends React.Component{
    render(){
        //recuperation de l'image + hash du gestionnaire d'assets
        const imgCouverture = require('../../img/' + this.props.urlCouverture);
        return (
            <div className="card mb-4">
                <div className="card-img-container">
                    <a href={'/livre/' + this.props.id }>
                        <img className="card-img-top" src={imgCouverture.default} alt={ 'Couverture' + this.props.titre} />
                    </a>
                </div>
                <div className="card-body">
                    <h5 className="card-title">{ this.props.titre }</h5>
                    
                    <p className="card-text"><b>Auteur</b> : { this.props.prenomAuteur} { this.props.nomAuteur }</p>
                    <p className="card-text"><b>Catégorie</b> : { this.props.categorie }</p>
                    <a href={'/livre/' + this.props.id} className="btn btn-primary">Détails</a>

                    <a href={'/emprunter/' + this.props.id} className="btn btn-primary">Emprunter</a>

                    </div>
                <div className="card-footer">
                <small className="text-muted">Ajouté à Bouquins le { this.props.dateAjout }</small>
                </div>
            </div>

        );
    }
}