// Import necessary CSS and bootstrap files
import '../css/app.css';
import './bootstrap';

// Import necessary CodeMirror modules for code editing
import {basicSetup, EditorView} from "codemirror"
import {EditorState, Compartment} from "@codemirror/state"

// Import language support for JavaScript, Python, Java, and C++
import {javascript} from "@codemirror/lang-javascript"
import {python} from "@codemirror/lang-python"
import {java} from "@codemirror/lang-java"
import {cpp} from "@codemirror/lang-cpp"

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
})

/*
// Code for setting up CodeMirror editors on the page
document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the 'code-editor' class
    const editors = document.querySelectorAll('.code-editor');
    // For each editor...
    editors.forEach(editor => {
        // Get the language and code from the editor element
        const language = editor.dataset.language;
        const code = editor.textContent.trim();
        // Create a new compartment for the editor
        const compartment = new Compartment();
        // Create the initial state for the editor
        const state = EditorState.create({
            doc: code,
            extensions: [
                basicSetup,
                // Set the language of the editor based on the language data attribute
                compartment.of(language === 'javascript' ? javascript : language === 'python' ? python : language === 'java' ? java : cpp)
            ]
        });
        // Create a new CodeMirror editor view with the initial state and parent element
        new EditorView({
            state,
            parent: editor
        });
    });
});
*/
