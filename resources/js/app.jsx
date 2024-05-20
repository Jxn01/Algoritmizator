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
    //
}).catch(e => {
    alert(e);
});
