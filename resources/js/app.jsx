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

//components

import NavbarComponent from './components/NavbarComponent';
import FooterComponent from './components/FooterComponent';
import JSCodeEditorComponent from './components/JSCodeEditorComponent';

//auth pages

import LoginPage from './pages/auth/LoginPage.jsx';
import RegistrationPage from './pages/auth/RegistrationPage.jsx';
import ForgotPasswordPage from './pages/auth/ForgotPasswordPage.jsx';
import PasswordResetPage from './pages/auth/PasswordResetPage.jsx';
import EmailConfirmationPage from './pages/auth/EmailConfirmationPage.jsx';
import VerificationEmailSentPage from './pages/auth/VerificationEmailSentPage.jsx';
import LogoutPage from "./pages/auth/LogoutPage.jsx";

//other pages

import DashboardPage from "./pages/DashboardPage.jsx";
import LessonsPage from "./pages/lessons/LessonsPage.jsx";
import QuizPage from "./pages/lessons/QuizPage.jsx";
import QuizResultsPage from "./pages/lessons/QuizResultsPage.jsx";
import ProfilePage from "./pages/ProfilePage.jsx";
import SocialsPage from "./pages/SocialsPage.jsx";

//error pages

import NotFoundPage from './pages/errors/NotFoundPage.jsx';
import InternalServerErrorPage from './pages/errors/InternalServerErrorPage.jsx';
import ForbiddenPage from './pages/errors/ForbiddenPage.jsx';

//components

if (document.getElementById('navbar')) {
    const currentPage = document.getElementById('navbar').dataset.currentPage;
    ReactDOM.render(<NavbarComponent currentPage={currentPage} />, document.getElementById('navbar'));
}

if (document.getElementById('footer')) {
    ReactDOM.render(<FooterComponent />, document.getElementById('footer'));
}

if(document.getElementById('js-code-editor')) {
    ReactDOM.render(<JSCodeEditorComponent/>, document.getElementById('js-code-editor'));
}

//auth pages

if(document.getElementById('login')) {
    ReactDOM.render(<LoginPage/>, document.getElementById('login'));
}

if(document.getElementById('registration')) {
    ReactDOM.render(<RegistrationPage/>, document.getElementById('registration'));
}

if(document.getElementById('forgot-password')) {
    ReactDOM.render(<ForgotPasswordPage />, document.getElementById('forgot-password'));
}

if(document.getElementById('reset-password')) {
    ReactDOM.render(<PasswordResetPage />, document.getElementById('reset-password'));
}

if(document.getElementById('verification-email-sent')) {
    ReactDOM.render(<VerificationEmailSentPage />, document.getElementById('verification-email-sent'));
}

if(document.getElementById('logout')) {
    ReactDOM.render(<LogoutPage />, document.getElementById('logout'));
}

//other pages

if(document.getElementById('dashboard')) {
    ReactDOM.render(<DashboardPage />, document.getElementById('dashboard'));
}

if(document.getElementById('lessons')) {
    ReactDOM.render(<LessonsPage />, document.getElementById('lessons'));
}

if(document.getElementById('quiz')) {
    ReactDOM.render(<QuizPage />, document.getElementById('quiz'));
}

if(document.getElementById('quiz-results')) {
    ReactDOM.render(<QuizResultsPage />, document.getElementById('quiz-results'));
}

if(document.getElementById('profile')) {
    ReactDOM.render(<ProfilePage />, document.getElementById('profile'));
}

if(document.getElementById('socials')) {
    ReactDOM.render(<SocialsPage />, document.getElementById('socials'));
}

//error pages

if (document.getElementById('not-found')) {
    ReactDOM.render(<NotFoundPage />, document.getElementById('not-found'));
}

if (document.getElementById('internal-server-error')) {
    ReactDOM.render(<InternalServerErrorPage />, document.getElementById('internal-server-error'));
}

if (document.getElementById('forbidden')) {
    ReactDOM.render(<ForbiddenPage />, document.getElementById('forbidden'));
}

