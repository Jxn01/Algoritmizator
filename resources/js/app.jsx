import '../css/app.css';
import './bootstrap';
import React from 'react';
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client';

createInertiaApp({
    resolve: (name) => import(`./components/${name}.jsx`),
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />)
    }
}).then(r => {
    // Log the successful creation of the Inertia app
    console.log('[inertia.js] Inertia app created successfully');
}).catch(e => {
    // Log the error if the Inertia app creation fails
    console.error('[inertia.js] Inertia app creation failed', e);
});
