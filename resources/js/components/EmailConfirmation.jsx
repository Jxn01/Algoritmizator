import React, { memo } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * EmailConfirmation component
 *
 * This component displays a confirmation message after a user successfully confirms their email address.
 * It includes a navbar, a confirmation message, and a footer.
 * @param {Object} props - Component properties
 * @param {string} props.title - Title of the current page
 * @param {string} props.activeTab - Active tab of the navigation bar
 * @returns {JSX.Element} EmailConfirmation component
 */
const EmailConfirmation = memo(({ title, activeTab }) => {
    return (
        <div>
            {/* Navbar component with title and active tab */}
            <Navbar title={title} activeTab={activeTab} />

            {/* Main content area */}
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <img
                            src="/algoritmizator/storage/logo.png"
                            alt="Logo"
                            className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"
                        />
                        <h2 className="text-3xl font-bold text-white mb-2">Email megerősítve</h2>
                    </div>

                    {/* Confirmation message box */}
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Sikeres megerősítés</h3>
                        <p className="text-lg text-gray-300 mb-4">
                            Köszönjük, hogy megerősítetted az e-mail címed. Mostantól hozzáférhetsz fiókod minden funkciójához.
                        </p>
                        <a
                            href="/algoritmizator/app"
                            className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300"
                        >
                            Vissza a vezérlőpultra
                        </a>
                    </div>
                </div>
            </div>

            {/* Footer component */}
            <Footer />
        </div>
    );
});

export default EmailConfirmation;
