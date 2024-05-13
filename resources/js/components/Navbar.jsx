import React, {memo, useEffect, useState} from "react";

/**
 * Navbar component
 *
 * This is a functional component that renders a navigation bar.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Navbar component
 */
const Navbar = memo(({ title, activeTab}) => {
    const [user, setUser] = useState(null);

    useEffect(() => {
        // Fetch the currently logged in user
        axios.get('/algoritmizator/api/user')
            .then(response => {
                setUser(response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }, []);

    // The avatar of the user or a default avatar if the user is not logged in
    const avatar = user ? user.avatar : 'storage/default.png';
    // Whether the user is authenticated (logged in)
    const authenticated = user !== null;

    // Render the navigation bar with links to different pages
    // The active tab is highlighted with a bold font
    // If the user is authenticated, links to the socials, logout, and profile pages are shown
    // If the user is not authenticated, links to the login and registration pages are shown
    return (
        <nav className="bg-gray-800 text-white w-full">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <div className="flex">
                        <div className="flex-shrink-0 flex items-center">
                            <img src="/algoritmizator/storage/logo.png" alt="Logo"
                                 className="h-10 w-10 rounded-full mr-3 object-cover border-2 border-purple-800"/>
                            <span className="text-lg font-bold">Algoritmizátor - {title}</span>
                        </div>
                    </div>
                    <div className="flex items-center">
                        {authenticated && (
                            <>
                                <a href="/algoritmizator/app"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'dashboard' ? 'font-bold' : 'font-medium'}`}>
                                    Vezérlőpult
                                </a>
                                <a href="/algoritmizator/app/lessons"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'lessons' ? 'font-bold' : 'font-medium'}`}>
                                    Tananyag
                                </a>
                                <a href="/algoritmizator/app/socials"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'socials' ? 'font-bold' : 'font-medium'}`}>
                                    Közösség
                                </a>
                                <a href="/algoritmizator/auth/logout"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'logout' ? 'font-bold' : 'font-medium'}`}>
                                    Kijelentkezés
                                </a>
                                <a className="flex items-center flex-1" href="/algoritmizator/app/profile">
                                    <div
                                       className={`flex items-center text-white px-3 py-2 rounded-md text-sm ${activeTab === 'profile' ? 'font-bold' : 'font-medium'}`}>
                                        <img src={"/algoritmizator/storage/" + avatar} alt="Profile"
                                             className="h-12 w-12 rounded-full mr-2 object-cover border-2 border-purple-800"/>
                                    </div>
                                    <div>
                                        <h3 className="text-lg">{user.username}</h3>
                                        <p className="text-sm">LVL {user.level} - {user.total_xp} XP</p>
                                    </div>
                                </a>

                            </>
                        )}
                        {!authenticated && (
                            <>
                                <a href="/algoritmizator/auth/login"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'login' ? 'font-bold' : 'font-medium'}`}>
                                    Bejelentkezés
                                </a>
                                <a href="/algoritmizator/auth/registration"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'registration' ? 'font-bold' : 'font-medium'}`}>
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
