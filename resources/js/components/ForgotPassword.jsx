import React, { memo, useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import axios from 'axios';

/**
 * ForgotPassword component
 *
 * This component renders a form for users to request a password reset.
 * It includes validation for the email address and provides feedback to the user.
 * @param {Object} props - Component properties
 * @param {string} props.title - Title of the current page
 * @param {string} props.activeTab - Active tab of the navigation bar
 * @returns {JSX.Element} ForgotPassword component
 */
const ForgotPassword = memo(({ title, activeTab }) => {
    const [email, setEmail] = useState('');
    const [emailSent, setEmailSent] = useState(false);
    const [emailIsValid, setEmailIsValid] = useState(true);

    /**
     * Handles form submission for password reset.
     * Validates the email format and sends a request to the server if valid.
     * @param {Event} event - Form submission event
     * @returns {void}
     */
    const handleSubmit = (event) => {
        event.preventDefault();
        const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i; // Regular expression to validate ELTE email address
        if (emailRegex.test(email)) {
            setEmailIsValid(true);
            axios.post('/algoritmizator/api/forgot-password', { email })
                .then(response => {
                    alert('Jelszó-visszaállítási e-mailt küldtünk az e-mail címedre.');
                    setEmailSent(true);
                })
                .catch(error => {
                    alert("Hiba történt a jelszó-visszaállítási e-mail küldése közben. Lehetséges, hogy ezzel az e-mail címmel nem regisztráltál még a rendszerbe.");
                });

        } else {
            setEmailIsValid(false);
        }
    };

    return (
        <div>
            {/* Navbar component */}
            <Navbar title={title} activeTab={activeTab} />

            {/* Main content area */}
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md">
                    <div className="flex flex-col items-center mb-8">
                        <img
                            src="/algoritmizator/storage/logo.png"
                            alt="Logo"
                            className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"
                        />
                        <h2 className="text-3xl font-bold text-white mb-2">Jelszó alaphelyzetbe állítása</h2>
                    </div>

                    {/* Password reset form */}
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Elfelejtett jelszó</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="email">
                                    Email
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="emailTip" />
                                    <ReactTooltip anchorSelect="#emailTip" place="right" effect="solid">
                                        Add meg a fiókodhoz tartozó e-mail címet.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="email"
                                    placeholder="Email"
                                    onChange={e => setEmail(e.target.value)}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${!emailIsValid ? 'border-red-500' : 'border-gray-600'}`}
                                    id="email"
                                />
                                {!emailIsValid && (
                                    <p className="text-xs text-red-500 mt-1">Az e-mail érvénytelen. Csak inf.elte.hu e-maileket fogadunk el.</p>
                                )}
                            </div>
                            {emailSent ? (
                                <div className="mt-4 text-center text-green-500">
                                    Jelszó-visszaállítási e-mailt küldtünk az e-mail címedre.
                                </div>
                            ) : (
                                <div className="flex items-center justify-between mt-6">
                                    <button
                                        type="submit"
                                        className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300"
                                    >
                                        Visszaállítási e-mail küldése
                                    </button>
                                </div>
                            )}
                            <div className="mt-4 text-center">
                                <a
                                    href="/algoritmizator/auth/login"
                                    className="text-purple-200 hover:text-purple-400 transition duration-300"
                                >
                                    Vissza a bejelentkezéshez
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {/* Footer component */}
            <Footer />
        </div>
    );
});

export default ForgotPassword;
