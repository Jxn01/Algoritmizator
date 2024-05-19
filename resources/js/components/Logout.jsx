import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Logout component
 *
 * This is a functional component that handles user logout and renders a logout confirmation page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * On component render, it makes a POST request to the '/algoritmizator/api/logout' endpoint to log out the user.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Logout component
 */
const Logout = memo(({title, activeTab}) => {
    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Sikeres kijelentkezés</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <p className="text-lg text-gray-300 mb-4">Kijelentkeztél. Térj vissza hamarosan!</p>
                        <a href="/algoritmizator/app" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Vissza a főoldalra</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Logout;
