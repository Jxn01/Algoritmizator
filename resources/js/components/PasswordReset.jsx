import React, { memo, useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import calculatePasswordStrength from "@/PasswordStrength.js";

/**
 * PasswordReset component
 *
 * This is a functional component that renders a password reset form.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState hook to manage the state of the email, password, confirmPassword, passwordsMatch, emailIsValid, passwordStrength, and resetSuccess.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 * @param {string} props.token - The password reset token
 *
 * @returns {JSX.Element} The PasswordReset component
 */
const PasswordReset = memo(({title, activeTab, token}) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [passwordsMatch, setPasswordsMatch] = useState(true);
    const [emailIsValid, setEmailIsValid] = useState(true);
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [resetSuccess, setResetSuccess] = useState(false);

    const handleSubmit = (event) => {
        event.preventDefault();
        if (password !== confirmPassword) {
            setPasswordsMatch(false);
            return;
        }
        setPasswordsMatch(true);
        const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i;
        if (!emailRegex.test(email)) {
            setEmailIsValid(false);
            return;
        }
        setEmailIsValid(true);
        if (calculatePasswordStrength(password) >= 2) {
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('password_confirmation', confirmPassword);
            formData.append('token', token);

            axios.post('/algoritmizator/api/reset-password', formData)
            setResetSuccess(true);
        }
    };

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md">
                    <div className="flex flex-col items-center mb-8">
                        <img src="/algoritmizator/storage/logo.png" alt="Logo"
                             className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"/>
                        <h2 className="text-3xl font-bold text-white mb-2">Jelszó visszaállítása</h2>
                    </div>
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Új jelszó beállítása</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="email">E-mail cím
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="emailTip"/>
                                    <ReactTooltip anchorSelect="#emailTip" place="right" effect="solid">
                                        Add meg a jelenlegi inf.elte.hu-s e-mail címét!
                                    </ReactTooltip>
                                </label>
                                <input type="text" placeholder="E-mail cím"
                                       autoComplete="email"
                                       onChange={e => setEmail(e.target.value)}
                                       className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${!emailIsValid ? 'border-red-500' : 'border-gray-600'}`}
                                       id="email"/>
                                {!emailIsValid &&
                                    <p className="text-xs text-red-500 mt-1">Kérjük, adj meg egy érvényes inf.elte.hu
                                        e-mail címet.</p>}
                            </div>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="password">Új jelszó
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="newPasswordTip"/>
                                    <ReactTooltip anchorSelect="#newPasswordTip" place="right" effect="solid">
                                        Adj meg egy erős jelszót, amely betűk, számok és szimbólumok keverékét
                                        tartalmazza.
                                    </ReactTooltip>
                                </label>
                                <input type="password" placeholder="Új jelszó"
                                       autoComplete="new-password"
                                       onChange={(e) => {
                                           setPassword(e.target.value);
                                           setPasswordStrength(calculatePasswordStrength(e.target.value));
                                       }}
                                       className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                       id="password"/>
                            </div>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="password">Új jelszó
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2"
                                                     id="newPasswordConfirmationTip"/>
                                    <ReactTooltip anchorSelect="#newPasswordConfirmationTip" place="right"
                                                  effect="solid">
                                        Add meg ugyanazt a jelszót még egyszer!
                                    </ReactTooltip>
                                </label>
                                <input type="password" placeholder="Új jelsző megerősítése"
                                       autoComplete="new-password"
                                       onChange={(e) => setConfirmPassword(e.target.value)}
                                       className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                       id="confirmPassword"/>
                                {!passwordsMatch &&
                                    <p className="text-xs text-red-500 mt-1">A jelszavak nem egyeznek.</p>}
                            </div>
                            <input type="hidden" value={token}/>
                            {password && (
                                <div className="mt-2">
                                    <div className="bg-gray-300 w-full h-2 rounded-full">
                                        <div
                                            className={`h-2 rounded-full ${passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-yellow-500' : passwordStrength === 3 ? 'bg-green-500' : passwordStrength === 4 ? 'bg-blue-500' : 'bg-gray-300'} w-${passwordStrength * 25}%`}></div>
                                    </div>
                                    <p className="text-xs text-gray-500 mt-1">Jelszó
                                        erőssége: {["Nincs", "Gyenge", "Mérsékelt", "Erős", "Nagyon erős"][passwordStrength]}</p>
                                </div>
                            )}
                            <div className="flex items-center justify-between mt-6">
                                <button type="submit"
                                        className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Jelszó
                                    visszaállítása
                                </button>
                            </div>
                            {resetSuccess &&
                                <p className="text-green-500 mt-2">A jelszavad sikeresen visszaállítottuk.</p>}
                        </form>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default PasswordReset;
