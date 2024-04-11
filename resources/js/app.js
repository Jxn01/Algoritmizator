import './bootstrap';
import {basicSetup, EditorView} from "codemirror"
import {EditorState, Compartment} from "@codemirror/state"
import {javascript} from "@codemirror/lang-javascript"
import {python} from "@codemirror/lang-python"
import {java} from "@codemirror/lang-java"
import {cpp} from "@codemirror/lang-cpp"

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

import React from 'react';
import ReactDOM from 'react-dom';
import LoginForm from './components/LoginForm';
import NotFound from "./components/NotFound.js";

    ReactDOM.render(<LoginForm />, document.getElementById('login-form'));

if (document.getElementById('not-found')) {
    ReactDOM.render(<NotFound />, document.getElementById('not-found'));
}

