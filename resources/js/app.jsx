import '../css/app.css';
import './bootstrap';
import {basicSetup, EditorView} from "codemirror"
import {EditorState, Compartment} from "@codemirror/state"
import {javascript} from "@codemirror/lang-javascript"
import {python} from "@codemirror/lang-python"
import {java} from "@codemirror/lang-java"
import {cpp} from "@codemirror/lang-cpp"

import React from 'react';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { createRoot } from 'react-dom/client';

console.log('[inertia.js] Creating Inertia app...');
createInertiaApp({
    resolve: (name) => import(`./components/${name}.jsx`),
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />)
    },
}).then(r => {
    console.log('[inertia.js] Inertia app created successfully');
})

/*
document.addEventListener('DOMContentLoaded', function () {
    const editors = document.querySelectorAll('.code-editor');
    editors.forEach(editor => {
        const language = editor.dataset.language;
        const code = editor.textContent.trim();
        const compartment = new Compartment();
        const state = EditorState.create({
            doc: code,
            extensions: [
                basicSetup,
                compartment.of(language === 'javascript' ? javascript : language === 'python' ? python : language === 'java' ? java : cpp)
            ]
        });
        new EditorView({
            state,
            parent: editor
        });
    });
});
*/
