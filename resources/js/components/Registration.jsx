import React, {memo, useState} from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Footer from "./Footer.jsx";
import Navbar from "./Navbar.jsx";

const Registration = memo(({title, activeTab, user}) => {
    const [formData, setFormData] = useState({
        name: '',
        username: '',
        email: '',
        password: '',
        confirmPassword: ''
    });
    const [emailIsValid, setEmailIsValid] = useState(true);
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [formErrors, setFormErrors] = useState({});

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (name === 'password') {
            setPasswordStrength(calculatePasswordStrength(value));
        }
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        const errors = validateForm();
        setFormErrors(errors);
        if (Object.keys(errors).length === 0) {
            const { confirmPassword, ...data } = formData;
            axios.post('/algoritmizator/api/register', data)
                .then(response => {
                    console.log('Registration successful:', response.data);
                    // Redirect to the login page
                    window.location.href = '/algoritmizator/auth/confirm-email';
                })
                .catch(error => {
                    console.error('Registration failed:', error.response.data);
                    if (error.response.status === 422) {
                        setFormErrors(error.response.data.errors);
                    }
                });
        }
    };

    const validateForm = () => {
        const errors = {};
        const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i;

        if (!formData.name) errors.name = "A név megadása kötelező.";
        if (!formData.username) errors.username = "A felhasználónév megadása kötelező.";
        if (!formData.email) {
            errors.email = "Az e-mail cím megadása kötelező.";
        } else if (!emailRegex.test(formData.email)) {
            errors.email = "Az e-mail érvénytelen. Csak inf.elte.hu e-maileket fogadunk el.";
        }
        if (!formData.password) errors.password = "A jelszó megadása kötelező.";
        if (!formData.confirmPassword) errors.confirmPassword = "A jelszó megerősítése kötelező.";
        if (formData.password && formData.confirmPassword && formData.password !== formData.confirmPassword) {
            errors.confirmPassword = "A jelszavak nem egyeznek.";
        }

        return errors;
    };

    function calculatePasswordStrength(pass) {
        let strength = 0;
        if (pass.length >= 8) strength += 1;
        if (pass.match(/\d+/)) strength += 1;
        if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength += 1;
        if (pass.match(/[^a-zA-Z0-9]/)) strength += 1;
        return strength;
    }

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md">
                    <div className="flex flex-col items-center mb-8">
                        <img src="/storage/logo.png" alt="Logo"
                             className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"/>
                        <h2 className="text-3xl font-bold text-white mb-2">Fiók létrehozása</h2>
                    </div>
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Regisztráció</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="name">
                                    Név
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="nameTip"/>
                                    <ReactTooltip anchorSelect={'#nameTip'} place="right" effect="solid">
                                        Adja meg a nevét.
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

                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="username">
                                    Felhasználónév
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="usernameTip"/>
                                    <ReactTooltip anchorSelect={'#usernameTip'} place="right" effect="solid">
                                        Adja meg a felhasználónevét.
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

                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="email">
                                    Email
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="emailTip"/>
                                    <ReactTooltip anchorSelect={'#emailTip'} place="right" effect="solid">
                                        Adja meg az e-mail címét. Csak inf.elte.hu e-maileket fogadunk el.
                                    </ReactTooltip>
                                </label>
                                <input
                                    type="email"
                                    placeholder="Email"
                                    onChange={handleChange}
                                    name="email"
                                    value={formData.email}
                                    className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${formErrors.email ? 'border-red-500' : 'border-gray-600'}`}
                                    id="email"
                                    autoComplete={"email"}
                                />
                                {formErrors.email && <p className="text-xs text-red-500 mt-1">{formErrors.email}</p>}
                            </div>

                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="password">
                                    Jelszó
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="passwordTip"/>
                                    <ReactTooltip anchorSelect={'#passwordTip'} place="right" effect="solid">
                                        Adjon meg egy erős jelszót, amely betűk, számok és szimbólumok keverékét tartalmazza.
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

                            <div className="mt-4">
                                <label className="block text-gray-300" htmlFor="confirmPassword">
                                    Jelszó megerősítése
                                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="confirmPasswordTip"/>
                                    <ReactTooltip anchorSelect={'#confirmPasswordTip'} place="right" effect="solid">
                                        Adja meg újra a jelszót a megerősítéshez.
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
                            {formData.password && (
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
                                        className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Regisztráció
                                </button>
                            </div>
                            <div className="mt-4 text-center">
                                <a href="/algoritmizator/auth/login" className="text-purple-200 hover:text-purple-400">Már van fiókja?
                                    Jelentkezzen be</a>
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
