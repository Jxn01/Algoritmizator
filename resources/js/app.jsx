// Import necessary CSS and bootstrap files
import '../css/app.css';
import './bootstrap';

// Import necessary React and Inertia modules
import React from 'react';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { createRoot } from 'react-dom/client';

// Log the start of Inertia app creation
console.log('[inertia.js] Creating Inertia app...');

// Create an Inertia app
createInertiaApp({
    // Dynamically import the necessary component based on the name
    resolve: (name) => import(`./components/${name}.jsx`),
    // Setup the Inertia app with the necessary root element, App component, and props
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />)
    },
}).then(r => {
    // Log the successful creation of the Inertia app
    console.log('[inertia.js] Inertia app created successfully');
}).catch(e => {
    // Log the error if the Inertia app creation fails
    console.error('[inertia.js] Inertia app creation failed', e);
});
