import React, { memo, useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Footer from "./Footer.jsx";
import Navbar from "./Navbar.jsx";
import calculatePasswordStrength from "@/PasswordStrength.js";
import axios from 'axios';

/**
 * Registration component
 *
 * This component provides a registration form for users to create a new account.
 * It includes fields for name, username, email, password, and password confirmation, with validation and password strength checking.
 * @param {Object} props The component properties
 * @param {string} props.title The title of the page
 * @param {string} props.activeTab The active tab in the navigation bar
 * @returns {JSX.Element} The rendered registration form
 */
const Registration = memo(({ title, activeTab }) => {
    const [formData, setFormData] = useState({
        name: '',
        username: '',
        email: '',
        password: '',
        confirmPassword: ''
    });
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [formErrors, setFormErrors] = useState({});

    /**
     * Handles form input changes.
     * Updates the form data state and calculates password strength if the password field is changed.
     * @param {Event} e The input change event
     * @returns {void}
     */
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (name === 'password') {
            setPasswordStrength(calculatePasswordStrength(value));
        }
    };

    /**
     * Handles form submission for registration.
     * Validates the form data and sends a registration request to the server.
     * @param {Event} event The form submission event
     * @returns {void}
     */
    const handleSubmit = (event) => {
        event.preventDefault();
        const errors = validateForm();
        setFormErrors(errors);
        if (Object.keys(errors).length === 0) {
            const { confirmPassword, ...data } = formData;
            axios.post('/algoritmizator/api/register', data)
                .then(response => {
                    alert("Sikeres regisztráció!");
                    window.location.href = '/algoritmizator/auth/confirm-email';
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        setFormErrors(error.response.data.errors);
                    } else {
                        alert("Hiba történt a regisztráció közben. Kérlek, próbáld újra később!");
                    }
                });
        }
    };

    /**
     * Validates the form data.
     * Checks for required fields, valid email format, password strength, and matching passwords.
     * @returns {Object} The errors object containing error messages for each field.
     */
    const validateForm = () => {
        const errors = {};
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!formData.name) errors.name = "A név megadása kötelező.";
        if (!formData.username) errors.username = "A felhasználónév megadása kötelező.";
        if (!formData.email) {
            errors.email = "Az e-mail cím megadása kötelező.";
        } else if (!emailRegex.test(formData.email)) {
            errors.email = "Az e-mail érvénytelen.";
        }
        if (!formData.password) errors.password = "A jelszó megadása kötelező.";
        if (!formData.confirmPassword) errors.confirmPassword = "A jelszó megerősítése kötelező.";
        if (formData.password && formData.confirmPassword && formData.password !== formData.confirmPassword) {
            errors.confirmPassword = "A jelszavak nem egyeznek.";
        }
        if (passwordStrength < 3) errors.password = "A jelszó túl gyenge, legalább erősnek kell lennie.";

        return errors;
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
                        <h2 className="text-3xl font-bold text-white mb-2">Fiók létrehozása</h2>
                    </div>
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Regisztráció</h3>
                        <form onSubmit={handleSubmit}>
                            {/* Name field */}
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="name">
                                    Név
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="nameTip" />
                                    <ReactTooltip anchorSelect={'#nameTip'} place="right" effect="solid">
                                        Add meg a neved.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="text"
                                    placeholder="Név"
                                    onChange={handleChange}
                                    name="name"
                                    value={formData.name}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.name ? 'border-red-500' : 'border-gray-600'}`}
                                    id="name"
                                />
                                {formErrors.name && <p className="text-xs text-red-500 mt-1">{formErrors.name}</p>}
                            </div>

                            {/* Username field */}
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="username">
                                    Felhasználónév
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="usernameTip" />
                                    <ReactTooltip anchorSelect={'#usernameTip'} place="right" effect="solid">
                                        Add meg az egyedi felhasználóneved.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="text"
                                    placeholder="Felhasználónév"
                                    onChange={handleChange}
                                    name="username"
                                    value={formData.username}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.username ? 'border-red-500' : 'border-gray-600'}`}
                                    id="username"
                                />
                                {formErrors.username && <p className="text-xs text-red-500 mt-1">{formErrors.username}</p>}
                            </div>

                            {/* Email field */}
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="email">
                                    E-mail cím
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="emailTip" />
                                    <ReactTooltip anchorSelect={'#emailTip'} place="right" effect="solid">
                                        Add meg az e-mail címed.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="email"
                                    placeholder="E-mail cím"
                                    onChange={handleChange}
                                    name="email"
                                    value={formData.email}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.email ? 'border-red-500' : 'border-gray-600'}`}
                                    id="email"
                                    autoComplete={"email"}
                                />
                                {formErrors.email && <p className="text-xs text-red-500 mt-1">{formErrors.email}</p>}
                            </div>

                            {/* Password field */}
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="password">
                                    Jelszó
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="passwordTip" />
                                    <ReactTooltip anchorSelect={'#passwordTip'} place="right" effect="solid">
                                        Adj meg egy erős jelszót, amely betűk, számok és szimbólumok keverékét tartalmazza.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="password"
                                    placeholder="Jelszó"
                                    onChange={handleChange}
                                    name="password"
                                    value={formData.password}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.password ? 'border-red-500' : 'border-gray-600'}`}
                                    id="password"
                                    autoComplete={"new-password"}
                                />
                                {formErrors.password && <p className="text-xs text-red-500 mt-1">{formErrors.password}</p>}
                            </div>

                            {/* Confirm Password field */}
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="confirmPassword">
                                    Jelszó megerősítése
                                    <FontAwesomeIcon tabIndex="-1" icon={faQuestionCircle} className="ml-2" id="confirmPasswordTip" />
                                    <ReactTooltip anchorSelect={'#confirmPasswordTip'} place="right" effect="solid">
                                        Add meg újra a jelszót a megerősítéshez.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="password"
                                    placeholder="Jelszó megerősítése"
                                    onChange={handleChange}
                                    name="confirmPassword"
                                    value={formData.confirmPassword}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.confirmPassword ? 'border-red-500' : 'border-gray-600'}`}
                                    id="confirmPassword"
                                    autoComplete={"new-password"}
                                />
                                {formErrors.confirmPassword &&
                                    <p className="text-xs text-red-500 mt-1">{formErrors.confirmPassword}</p>}
                            </div>

                            {/* Password strength indicator */}
                            {formData.password && (
                                <div className="mt-2">
                                    <div className="bg-gray-300 w-full h-2 rounded-full">
                                        <div
                                            className={`h-2 rounded-full ${passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-yellow-500' : passwordStrength === 3 ? 'bg-green-500' : passwordStrength === 4 ? 'bg-blue-500' : 'bg-gray-300'} w-${passwordStrength * 25}%`}
                                        ></div>
                                    </div>
                                    <p className="text-xs text-gray-500 mt-1">
                                        Jelszó erőssége: {["Nincs", "Gyenge", "Mérsékelt", "Erős", "Nagyon erős"][passwordStrength]}
                                    </p>
                                </div>
                            )}

                            {/* Submit button */}
                            <div className="flex items-center justify-between mt-6">
                                <button type="submit"
                                        className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">
                                    Regisztráció
                                </button>
                            </div>

                            {/* Link to login page */}
                            <div className="mt-4 text-center">
                                <a href="/algoritmizator/auth/login" className="text-purple-200 hover:text-purple-400 transition duration-300">
                                    Már van fiókod? Jelentkezz be
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Registration;
