import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Dashboard component
 *
 * This is a functional component that renders the dashboard page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Dashboard component
 */
const Dashboard = memo(({title, activeTab, user}) => {
    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-2xl text-center">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Vezérlőpult</h2>
                        <p className="text-lg text-gray-300">Üdvözöljük újra! Készen állsz a mai tanulásra?</p>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-white mb-4">Legújabb leckék</h3>
                        <p className="text-lg text-gray-300 mb-4">Nemrég fejezte be a "Bevezetés az algoritmusokba" című leckét.</p>
                        <a href="/algoritmizator/app/algorithms" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Leckék megtekintése</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Dashboard;
