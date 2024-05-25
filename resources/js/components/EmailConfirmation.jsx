import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * EmailConfirmation component
 *
 * This is a functional component that renders the email confirmation page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The EmailConfirmation component
 */
const EmailConfirmation = memo(({title, activeTab}) => {
    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <img src="/algoritmizator/storage/logo.png" alt="Logo"
                             className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"/>
                        <h2 className="text-3xl font-bold text-white mb-2">Email megerősítve</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Sikeres megerősítés</h3>
                        <p className="text-lg text-gray-300 mb-4">Köszönjük, hogy megerősítetted az e-mail címed. Mostantól hozzáférhetsz fiókod minden funkciójához.</p>
                        <a href="/algoritmizator/app" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">Vissza a vezérlőpultra</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default EmailConfirmation;
