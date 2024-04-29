import {memo} from "react";

const Navbar = memo(({ title, activeTab, user }) => {

    const authenticated = user !== null;
    return (
        <nav className="bg-gray-800 text-white w-full">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <div className="flex">
                        <div className="flex-shrink-0 flex items-center">
                            <span className="text-lg font-bold">Algoritmizátor - {title}</span>
                        </div>
                    </div>
                    <div className="flex items-center">
                        <a href="/algoritmizator/app/"
                           className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'dashboard' ? 'font-bold' : 'font-medium'}`}>
                            Vezérlőpult
                        </a>
                        <a href="/algoritmizator/app/lessons"
                           className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'lessons' ? 'font-bold' : 'font-medium'}`}>
                            Tananyag
                        </a>
                        {authenticated && (
                            <>
                                <a href="/algoritmizator/app/socials"
                                   className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'socials' ? 'font-bold' : 'font-medium'}`}>
                                    Közösség
                                </a>
                                <a href="/algoritmizator/app/profile"
                                   className={`flex items-center text-white px-3 py-2 rounded-md text-sm ${activeTab === 'profile' ? 'font-bold' : 'font-medium'}`}>
                                    <img src="profile-pic-url.jpg" alt="Profile" className="h-8 w-8 rounded-full"/>
                                    Profil
                                </a>
                                <a href="/algoritmizator/auth/logout" className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'logout' ? 'font-bold' : 'font-medium'}`}>
                                    Kijelentkezés
                                </a>
                            </>
                        )}
                        {!authenticated && (
                            <>
                                <a href="/algoritmizator/auth/login" className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'login' ? 'font-bold' : 'font-medium'}`}>
                                    Bejelentkezés
                                </a>
                                <a href="/algoritmizator/auth/registration" className={`text-white px-3 py-2 rounded-md text-sm ${activeTab === 'registration' ? 'font-bold' : 'font-medium'}`}>
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
