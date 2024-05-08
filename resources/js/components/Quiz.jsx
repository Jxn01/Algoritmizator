import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Quiz component
 *
 * This is a functional component that renders a quiz page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Quiz component
 */
const Quiz = memo(({title, activeTab, user}) => {
    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Kvíz az 1. leckéhez</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <div className="mb-4">
                            <p className="text-lg text-gray-300 mb-4">Kérdés: Mi 2 + 2?</p>
                            <button className="px-4 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">1</button>
                            <button className="px-4 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">2</button>
                            <button className="px-4 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">3</button>
                            <button className="px-4 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">4</button>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Quiz;
