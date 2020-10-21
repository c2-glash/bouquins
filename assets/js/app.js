/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// CSS compilé dans un seul fichier
import '../css/bootstrap.css';
import '../css/style.scss';
import '../css/responsive.scss';
import '../css/parallax.scss';
import '../css/chargement.scss';

//JS compilé dans un seul fichier
import './bootstrap.js';
import './headerLayout2.js';
import './chargement.js';
import './accueil.js';
import './rechercheLivre.js';
import './uploadFichierForm.js';

//react
import React         from 'react';
import ReactDOM      from 'react-dom';
import { SearchBar } from './SearchBar';

//Lancement react quand #react-livres est présent
if(document.getElementById('react-livres') !== null){
    const reactLivres = document.getElementById('react-livres');
    ReactDOM.render(<SearchBar />, reactLivres);    
}

