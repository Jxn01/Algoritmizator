import React, { useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';

const ForgotPassword = () => {
    const [email, setEmail] = useState('');
    const [emailSent, setEmailSent] = useState(false);
    const [emailIsValid, setEmailIsValid] = useState(true);

    const handleSubmit = (event) => {
        event.preventDefault();
        const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i;
        if (emailRegex.test(email)) {
            setEmailIsValid(true);
            setEmailSent(true);
            // Simulate sending email process
            console.log('Password reset email sent to:', email);
        } else {
            setEmailIsValid(false);
        }
    };

    return (
        <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
            <div className="w-full max-w-md">
                <div className="flex flex-col items-center mb-8">
                    <div className="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                        <span className="text-xl font-semibold text-white">Logo</span>
                    </div>
                    <h2 className="text-3xl font-bold text-white mb-2">Jelszó alaphelyzetbe állítása</h2>
                </div>
                <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                    <h3 className="text-2xl font-bold text-center text-white mb-4">Elfelejtett jelszó</h3>
                    <form onSubmit={handleSubmit}>
                        <div className="mt-4">
                            <label className="block text-gray-300" htmlFor="email">Email
                                <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="emailTip" />
                                <ReactTooltip anchorSelect="#emailTip" place="right" effect="solid">
                                    Adja meg a fiókjához tartozó e-mail címet.
                                </ReactTooltip>
                            </label>
                            <input type="email" placeholder="Email"
                                   onChange={e => setEmail(e.target.value)}
                                   className={`w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white ${!emailIsValid ? 'border-red-500' : 'border-gray-600'}`}
                                   id="email"/>
                            {!emailIsValid && <p className="text-xs text-red-500 mt-1">Az e-mail érvénytelen. Csak inf.elte.hu e-maileket fogadunk el.</p>}
                        </div>
                        {emailSent ?
                            <div className="mt-4 text-center text-green-500">
                                Jelszó-visszaállítási e-mailt küldtünk az Ön e-mail címére.
                            </div>
                            :
                            <div className="flex items-center justify-between mt-6">
                                <button type="submit" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Visszaállítási e-mail küldése</button>
                            </div>
                        }
                        <div className="mt-4 text-center">
                            <a href="/algoritmizator/auth/login" className="text-purple-200 hover:text-purple-400">Vissza a bejelentkezéshez</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default ForgotPassword;
