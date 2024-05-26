import React, { memo, useEffect, useState } from "react";
import axios from 'axios';

/**
 * Navbar component
 *
 * This component displays a navigation bar with links to different sections of the application.
 * It shows different links based on whether the user is authenticated or not.
 * The component also fetches user data to display the user's avatar and other details.
 * @param {Object} props - Component properties
 * @param {string} props.title - Title of the current page
 * @param {string} props.activeTab - Active tab of the navigation bar
 * @returns {JSX.Element} Navbar component
 */
const Navbar = memo(({ title, activeTab }) => {
    const [user, setUser] = useState(null);
    const [authenticated, setAuthenticated] = useState(false);
    const [avatar, setAvatar] = useState('default.png');

    // Fetch user data on component mount
    useEffect(() => {
        axios.get('/algoritmizator/api/user')
            .then(response => {
                setUser(response.data);
                if(response.data.id !== undefined){
                    setAuthenticated(true);
                    setAvatar(response.data.avatar);
                }
            })
            .catch(error => {
                alert("Hiba történt az adatok betöltése közben. Kérlek, próbáld újra később!");
            });
    }, []);

    return (
        <nav className="bg-gray-800 text-white w-full">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <div className="flex">
                        <div className="flex-shrink-0 flex items-center">
                            <img
                                src="/algoritmizator/storage/logo.png"
                                alt="Logo"
                                className="h-10 w-10 rounded-full mr-3 object-cover border-2 border-purple-800"
                            />
                            <span className="text-lg font-bold">Algoritmizátor - {title}</span>
                        </div>
                    </div>
                    <div className="flex items-center">
                        {authenticated ? (
                            <>
                                <a
                                    href="/algoritmizator/app"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'dashboard' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Vezérlőpult
                                </a>
                                <a
                                    href="/algoritmizator/app/lessons"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'lessons' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Tananyag
                                </a>
                                <a
                                    href="/algoritmizator/app/socials"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'socials' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Közösség
                                </a>
                                <a
                                    href="/algoritmizator/auth/logout"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'logout' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Kijelentkezés
                                </a>
                                <a
                                    className={`flex items-center rounded-lg mx-5 my-2 pr-5 flex-1 hover:bg-gray-900 transition duration-300 ${activeTab === 'profile' ? 'bg-gray-900' : ''}`}
                                    href="/algoritmizator/app/profile"
                                >
                                    <div className="flex items-center text-white px-3 py-2 rounded-md text-sm font-medium">
                                        <img
                                            src={`/algoritmizator/storage/${avatar}`}
                                            alt="Profile"
                                            className="h-12 w-12 rounded-full mr-2 object-cover border-2 border-purple-800"
                                        />
                                    </div>
                                    <div>
                                        <h3 className="text-lg">{user.username}</h3>
                                        <p className="text-sm">LVL {user.level} - {user.total_xp} XP</p>
                                    </div>
                                </a>
                            </>
                        ) : (
                            <>
                                <a
                                    href="/algoritmizator/auth/login"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'login' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Bejelentkezés
                                </a>
                                <a
                                    href="/algoritmizator/auth/registration"
                                    className={`text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-900 transition duration-300 ${activeTab === 'registration' ? 'font-bold bg-gray-900' : 'font-medium'}`}
                                >
                                    Regisztráció
                                </a>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
});

export default Navbar;
