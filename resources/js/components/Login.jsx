import React, { useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip'; // Correct import
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [emailIsValid, setEmailIsValid] = useState(true);
    const [loginAttempts, setLoginAttempts] = useState(0);

    const handleSubmit = (event) => {
        event.preventDefault();
        const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i;
        if (!emailRegex.test(email)) {
            setEmailIsValid(false);
            return;
        }
        setEmailIsValid(true);

        const formData = new URLSearchParams();
        formData.append('username', email);
        formData.append('password', password);

        axios.post('/api/login', formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
            .then(response => {
                console.log('Login successful:', response.data);
                localStorage.setItem('access_token', response.data.access_token);
                window.location.href = '/algoritmizator/app';
            })
            .catch(error => {
                console.error('Login failed:', error.response.data);
                alert('Hibás felhasználónév vagy jelszó. Kérjük, próbálja újra.');
                setLoginAttempts(loginAttempts + 1);
            });
    };

    const handlePasswordChange = (e) => {
        setPassword(e.target.value);
    };


    return (
        <div>
            <Navbar />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md">
                    <div className="flex flex-col items-center mb-8">
                        <div className="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                            <span className="text-xl font-semibold text-white">Logo</span>
                        </div>
                        <h2 className="text-3xl font-bold text-white mb-2">Üdvözöljük újra!</h2>
                    </div>
                    <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Bejelentkezés a fiókjába</h3>
                        <form onSubmit={handleSubmit}>
                            <div className="mt-4">
                                <div className="relative">
                                    <label className="block text-gray-300" htmlFor="email">Email
                                        <span className="ml-2 cursor-pointer">
                                            <FontAwesomeIcon id="emailHelp" icon={faQuestionCircle} data-tip data-for="emailTip"/>
                                            <ReactTooltip id="emailTip" anchorSelect="#emailHelp" place="right" effect="solid">
                                                Csak inf.elte.hu e-maileket címeket fogadunk el.
                                            </ReactTooltip>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="Email"
                                        onChange={e => setEmail(e.target.value)}
                                        className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${!emailIsValid ? 'border-red-500' : 'border-gray-600'}`}
                                        id="email"/>
                                        {!emailIsValid && <p className="text-xs text-red-500 mt-1">Kérjük, adjon meg egy érvényes inf.elte.hu e-mail címet.</p>}
                                </div>
                                <div className="mt-4">
                                    <label className="block text-gray-300">Jelszó</label>
                                    <input type="password" placeholder="Jelszó"
                                           onChange={handlePasswordChange}
                                           className="w-full px-4 py-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                           id="password"/>
                                </div>
                                <div className="flex items-baseline justify-between mt-4">
                                    <button type="submit" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Bejelentkezés</button>
                                    <a href="/algoritmizator/auth/forgot-password" className="text-sm text-purple-300 hover:underline">Elfelejtette jelszavát?</a>
                                </div>
                                <div className="mt-4 text-center">
                                    {loginAttempts > 1 && <p className="text-sm text-red-500">Gondjai vannak a bejelentkezéssel? Ellenőrizze hitelesítő adatait, és próbálja meg újra.</p>}
                                    <a href="/algoritmizator/auth/registration" className="text-purple-200 hover:text-purple-400">Nincs fiókja? Regisztráljon</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
};

export default Login;
