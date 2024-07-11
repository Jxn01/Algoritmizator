import './bootstrap';
import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

/**
 * Initializes the Inertia.js application.
 *
 * This function sets up the Inertia.js application by resolving component imports dynamically
 * and rendering the application with React.
 * @returns {Promise<void>} A promise that resolves when the application is successfully created.
 */
createInertiaApp({
    /**
     * Resolves the component dynamically based on the given name.
     *
     * @param {string} name - The name of the component to resolve.
     * @returns {Promise<React.ComponentType>} The imported component.
     */
    resolve: (name) => import(`./components/${name}.jsx`),

    /**
     * Sets up the Inertia.js application by rendering the resolved component.
     *
     * @param {object} setupProps - The setup properties.
     * @param {HTMLElement} setupProps.el - The root element where the app will be rendered.
     * @param {React.ComponentType} setupProps.App - The main application component.
     * @param {object} setupProps.props - The properties to be passed to the application component.
     * @returns {void}
     */
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    }
})
    .then(response => {
        // Placeholder for any actions to be taken after the app is successfully created.
    })
    .catch(error => {
        // Handles any errors that occur during the app setup.
        alert(error);
    });
