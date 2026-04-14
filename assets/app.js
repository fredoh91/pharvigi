// import './stimulus_bootstrap.js';
// /*
//  * Welcome to your app's main JavaScript file!
//  *
//  * This file will be included onto the page via the importmap() Twig function,
//  * which should already be in your base.html.twig.
//  */
// import './styles/app.css';

// console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


// Importe le JavaScript de Bootstrap (dropdowns, modals, tooltips, etc.)
// Nécessaire pour utiliser les composants interactifs de Bootstrap
import 'bootstrap';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

// console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

import { startStimulusApp } from '@symfony/stimulus-bridge';
// import '@symfony/autoimport';

// Démarrez l'application Stimulus et enregistrez les contrôleurs locaux
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.js$/
));


