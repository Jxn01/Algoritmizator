import React, { memo } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Logout component
 *
 * This component displays a confirmation message after the user has successfully logged out.
 * It includes a navbar, a message indicating successful logout, and a footer.
 * @param {Object} props - Component properties
 * @param {string} props.title - Title of the current page
 * @param {string} props.activeTab - Active tab of the navigation bar
 * @returns {JSX.Element} Logout component
 */
const Logout = memo(({ title, activeTab }) => {
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
                            className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800 animate-pulse"
                        />
                        <h2 className="text-3xl font-bold text-white mb-2">Sikeres kijelentkezés</h2>
                    </div>

                    {/* Logout confirmation message */}
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <p className="text-lg text-gray-300 mb-4">Kijelentkeztél. Térj vissza hamarosan!</p>
                        <a
                            href="/algoritmizator/app"
                            className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300"
                        >
                            Vissza a bejelentkezéshez
                        </a>
                    </div>
                </div>
            </div>

            {/* Footer component */}
            <Footer />
        </div>
    );
});

export default Logout;
