import React, { useState } from 'react';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';

const PasswordReset = () => {
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [passwordsMatch, setPasswordsMatch] = useState(true);
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [resetSuccess, setResetSuccess] = useState(false);

    const handleSubmit = (event) => {
        event.preventDefault();
        if (password !== confirmPassword) {
            setPasswordsMatch(false);
            return;
        }
        setPasswordsMatch(true);
        if (calculatePasswordStrength(password) >= 2) {
            console.log('Password reset successfully to:', password);
            setResetSuccess(true);
            // Here you would typically make an API call to the backend to save the new password
        }
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
        <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
            <div className="w-full max-w-md">
                <div className="flex flex-col items-center mb-8">
                    <div className="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                        <span className="text-xl font-semibold text-white">Logo</span>
                    </div>
                    <h2 className="text-3xl font-bold text-white mb-2">Jelszó visszaállítása</h2>
                </div>
                <div className="px-8 py-6 text-left bg-gray-800 shadow-lg rounded-lg">
                    <h3 className="text-2xl font-bold text-center text-white mb-4">Új jelszó beállítása</h3>
                    <form onSubmit={handleSubmit}>
                        <div className="mt-4">
                            <label className="block text-gray-300" htmlFor="password">Új jelszó
                                <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="newPasswordTip" />
                                <ReactTooltip anchorSelect="#newPasswordTip" place="right" effect="solid">
                                    Adjon meg egy erős jelszót, amely betűk, számok és szimbólumok keverékét tartalmazza.
                                </ReactTooltip>
                            </label>
                            <input type="password" placeholder="New Password"
                                   onChange={(e) => { setPassword(e.target.value); setPasswordStrength(calculatePasswordStrength(e.target.value)); }}
                                   className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                   id="password"/>
                        </div>
                        <div className="mt-4">
                            <label className="block text-gray-300" htmlFor="confirmPassword">Új jelszó megerősítése</label>
                            <input type="password" placeholder="Confirm New Password"
                                   onChange={(e) => setConfirmPassword(e.target.value)}
                                   className="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                   id="confirmPassword"/>
                            {!passwordsMatch && <p className="text-xs text-red-500 mt-1">A jelszavak nem egyeznek.</p>}
                        </div>
                        {password && (
                            <div className="mt-2">
                                <div className="bg-gray-300 w-full h-2 rounded-full">
                                    <div className={`h-2 rounded-full ${passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-yellow-500' : passwordStrength === 3 ? 'bg-green-500' : passwordStrength === 4 ? 'bg-blue-500' : 'bg-gray-300'} w-${passwordStrength * 25}%`}></div>
                                </div>
                                <p className="text-xs text-gray-500 mt-1">Jelszó erőssége: {["Nincs", "Gyenge", "Mérsékelt", "Erős", "Nagyon erős"][passwordStrength]}</p>
                            </div>
                        )}
                        <div className="flex items-center justify-between mt-6">
                            <button type="submit" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Jelszó visszaállítása</button>
                        </div>
                        {resetSuccess && <p className="text-green-500 mt-2">A jelszavát sikeresen visszaállítottuk.</p>}
                    </form>
                </div>
            </div>
        </div>
    );
};

export default PasswordReset;
