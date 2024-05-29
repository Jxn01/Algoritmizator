import React, { memo } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Loading component
 *
 * This component displays a message indicating that the page is loading.
 * It includes a navbar, a main message, and a footer.
 * @returns {JSX.Element} Loading component
 */
const Loading = memo(() => {
    return (
        <div>
            {/* Navbar component */}
            <Navbar />

            {/* Main content area */}
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    {/* Logo and title */}
                    <div className="flex flex-col items-center mb-8">
                        <img
                            src="/algoritmizator/storage/logo.png"
                            alt="Logo"
                            className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800 animate-bounce"
                        />
                        <h2 className="text-3xl font-bold text-white mb-2">Betöltés...</h2>
                    </div>
                </div>
            </div>

            {/* Footer component */}
            <Footer />
        </div>
    );
});

export default Loading;
