import React, { memo, useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import calculatePasswordStrength from "@/PasswordStrength.js";
import axios from 'axios';

/**
 * PasswordReset component
 *
 * This component provides a form for users to reset their password. It includes fields for email, new password,
 * and password confirmation, with validation and password strength checking.
 * @param {Object} props Component properties
 * @param {string} props.title Title of the page
 * @param {string} props.activeTab Active tab in the navigation bar
 * @param {string} props.token Password reset token
 * @returns {JSX.Element} Password reset form
 */
const PasswordReset = memo(({ title, activeTab, token }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [passwordsMatch, setPasswordsMatch] = useState(true);
    const [emailIsValid, setEmailIsValid] = useState(true);
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [passwordStrong, setPasswordStrong] = useState(true);
    const [resetSuccess, setResetSuccess] = useState(false);

    /**
     * Handles form submission for password reset.
     * Validates the email format, password strength, and checks if passwords match.
     * @param {Event} event Form submission event
     * @returns {void}
     */
    const handleSubmit = (event) => {
        event.preventDefault();
        if (password !== confirmPassword) {
            setPasswordsMatch(false);
            return;
        }
        setPasswordsMatch(true);

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            setEmailIsValid(false);
            return;
        }
        setEmailIsValid(true);

        if (passwordStrength < 3) {
            setPasswordStrong(false);
            return;
        }
        setPasswordStrong(true);

        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('password_confirmation', confirmPassword);
        formData.append('token', token);

        axios.post('/algoritmizator/api/reset-password', formData)
            .then(response => {
                setResetSuccess(true);
            })
            .catch(error => {
                alert("Hiba történt a jelszó-visszaállítás közben. Lehetséges, hogy a jelszó-visszaállítási link lejárt vagy rossz e-mail címet adtál meg.");
            });
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
                        <h2 className="text-3xl font-bold text-white mb-2">Jelszó visszaállítása</h2>
                    </div>

                    {/* Password reset form */}
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Új jelszó beállítása</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="email">
                                    E-mail cím
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="emailTip" />
                                    <ReactTooltip anchorSelect="#emailTip" place="right" effect="solid">
                                        Add meg a jelenlegi inf.elte.hu-s e-mail címét!
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
                                    <p className="text-xs text-red-500 mt-1">Kérjük, add meg az érvényes inf.elte.hu e-mail címed.</p>
                                )}
                            </div>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="password">
                                    Új jelszó
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="newPasswordTip" />
                                    <ReactTooltip anchorSelect="#newPasswordTip" place="right" effect="solid">
                                        Adj meg egy erős jelszót, amely betűk, számok és szimbólumok keverékét tartalmazza.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="password"
                                    placeholder="Új jelszó"
                                    autoComplete="new-password"
                                    onChange={(e) => {
                                        setPassword(e.target.value);
                                        setPasswordStrength(calculatePasswordStrength(e.target.value));
                                    }}
                                    className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                    id="password"
                                />
                                {!passwordStrong && (
                                    <p className="text-xs text-red-500 mt-1">A jelszó túl gyenge, legalább erősnek kell lennie.</p>
                                )}
                            </div>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="confirmPassword">
                                    Új jelszó megerősítése
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="newPasswordConfirmationTip" />
                                    <ReactTooltip anchorSelect="#newPasswordConfirmationTip" place="right" effect="solid">
                                        Add meg ugyanazt a jelszót még egyszer!
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="password"
                                    placeholder="Új jelszó megerősítése"
                                    autoComplete="new-password"
                                    onChange={(e) => setConfirmPassword(e.target.value)}
                                    className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                    id="confirmPassword"
                                />
                                {!passwordsMatch && (
                                    <p className="text-xs text-red-500 mt-1">A jelszavak nem egyeznek.</p>
                                )}
                            </div>
                            <input type="hidden" value={token} />
                            {password && (
                                <div className="mt-2">
                                    <div className="bg-gray-300 w-full h-2 rounded-full">
                                        <div
                                            className={`h-2 rounded-full ${passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-yellow-500' : passwordStrength === 3 ? 'bg-green-500' : passwordStrength === 4 ? 'bg-blue-500' : 'bg-gray-300'} w-${passwordStrength * 25}%`}
                                        ></div>
                                    </div>
                                    <p className="text-xs text-gray-500 mt-1">Jelszó erőssége: {["Nincs", "Gyenge", "Mérsékelt", "Erős", "Nagyon erős"][passwordStrength]}</p>
                                </div>
                            )}
                            <div className="flex items-center justify-between mt-6">
                                <button
                                    type="submit"
                                    className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300"
                                >
                                    Jelszó visszaállítása
                                </button>
                            </div>
                            {resetSuccess && (
                                <p className="text-green-500 mt-2">A jelszavad sikeresen visszaállítottuk.</p>
                            )}
                        </form>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default PasswordReset;
