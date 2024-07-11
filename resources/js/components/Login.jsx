import React, { memo, useState } from 'react';
import axios from 'axios';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Footer from "./Footer.jsx";
import Navbar from "./Navbar.jsx";

/**
 * Login component
 *
 * This component provides a login form for users to enter their email and password.
 * It includes validation for the email format and handles the submission of the form.
 * @param {Object} props - Component properties
 * @param {string} props.title - Title of the current page
 * @param {string} props.activeTab - Active tab of the navigation bar
 * @returns {JSX.Element} Login component
 */
const Login = memo(({ title, activeTab }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [rememberMe, setRememberMe] = useState(false);
    const [emailIsValid, setEmailIsValid] = useState(true);
    const [loginAttempts, setLoginAttempts] = useState(0);

    /**
     * Handles form submission for login.
     * Validates the email format and sends a request to the server if valid.
     * @param {Event} event - Form submission event
     * @returns {void}
     */
    const handleSubmit = (event) => {
        event.preventDefault();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            setEmailIsValid(false);
            return;
        }

        setEmailIsValid(true);

        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('remember', rememberMe);

        axios.post('/algoritmizator/api/login', formData)
            .then(response => {
                window.location.href = '/algoritmizator/app';
            })
            .catch(error => {
                alert('Hibás e-mail cím vagy jelszó. Kérjük, próbáld újra.');
                setLoginAttempts(loginAttempts + 1);
            });
    };

    /**
     * Handles the change event for the "Remember Me" checkbox.
     * @param {Event} e - Change event for the checkbox
     * @returns {void}
     */
    const handleRememberMeChange = (e) => {
        setRememberMe(e.target.checked);
    };

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md">
                    <div className="flex flex-col items-center mb-8">
                        <img
                            src="/algoritmizator/storage/logo.png"
                            alt="Logo"
                            className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800 animate-pulse"
                        />
                        <h2 className="text-3xl font-bold text-white mb-2">Üdvözlünk újra!</h2>
                    </div>

                    {/* Login form */}
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Bejelentkezés a fiókodba</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <div className="relative">
                                    <label className="block text-gray-300" htmlFor="email">
                                        E-mail cím
                                        <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="emailTip" />
                                        <ReactTooltip anchorSelect={'#emailTip'} place="right" effect="solid">
                                            Add meg az e-mail címed.
                                        </ReactTooltip>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="E-mail cím"
                                        autoComplete="email"
                                        onChange={e => setEmail(e.target.value)}
                                        className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${!emailIsValid ? 'border-red-500' : 'border-gray-600'}`}
                                        id="email"
                                    />
                                    {!emailIsValid && (
                                        <p className="text-xs text-red-500 mt-1">Kérjük, adj meg egy érvényes e-mail címet.</p>
                                    )}
                                </div>
                                <div className="mt-4">
                                    <label className="block text-gray-300" htmlFor="password">Jelszó</label>
                                    <input
                                        type="password"
                                        placeholder="Jelszó"
                                        autoComplete="current-password"
                                        onChange={e => setPassword(e.target.value)}
                                        className="w-full px-4 py-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                        id="password"
                                    />
                                </div>
                                <div className="flex items-center mt-4">
                                    <input
                                        type="checkbox"
                                        id="rememberMe"
                                        checked={rememberMe}
                                        onChange={handleRememberMeChange}
                                        className="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500"
                                    />
                                    <label htmlFor="rememberMe" className="ml-2 block text-sm text-gray-300">Emlékezz rám</label>
                                </div>
                                <div className="flex items-baseline justify-between mt-4">
                                    <button type="submit" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">Bejelentkezés</button>
                                    <a href="/algoritmizator/auth/forgot-password" className="text-sm text-purple-300 hover:underline">Elfelejtetted a jelszavad?</a>
                                </div>
                                <div className="mt-4 text-center">
                                    {loginAttempts > 1 && <p className="text-sm text-red-500">Gondjaid vannak a bejelentkezéssel? Ellenőrizd hitelesítő adataid, és próbáld meg újra.</p>}
                                    <a href="/algoritmizator/auth/registration" className="text-purple-200 hover:text-purple-400 transition duration-300">Nincs fiókod? Regisztrálj</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Login;
