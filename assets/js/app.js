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
import '../css/app.css';

//JS compilé dans un seul fichier
import './bootstrap.js';
import './headerLayout2.js';
import './accueil.js';

//react
import React    from 'react';
import ReactDOM from 'react-dom';
import { SearchBar } from './SearchBar';

//Si le container react-livres est présent sur la page, on lance react
const reactLivres = document.getElementById('react-livres');
if(reactLivres !== undefined){
    ReactDOM.render(<SearchBar />, reactLivres);    
}