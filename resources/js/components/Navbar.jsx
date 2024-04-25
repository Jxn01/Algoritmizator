const Navbar = () => {
    const currentPage = window.currentPage;
    return (
        <nav className="bg-gray-800 text-white w-full">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <div className="flex">
                        <div className="flex-shrink-0 flex items-center">
                            <span className="text-lg font-bold">Algoritmizátor - {currentPage}</span>
                        </div>
                    </div>
                    <div className="flex items-center">
                        {/* Dashboard Link */}
                        <a href="/algoritmizator/app/" className="text-white px-3 py-2 rounded-md text-sm font-medium">Vezérlőpult</a>
                        {/* Lessons Link */}
                        <a href="/algoritmizator/app/lessons" className="text-white px-3 py-2 rounded-md text-sm font-medium">Tananyag</a>
                        {/* Socials Link */}
                        <a href="/algoritmizator/app/socials" className="text-white px-3 py-2 rounded-md text-sm font-medium">Közösség</a>
                        {/* Profile Link */}
                        <a href="/algoritmizator/app/profile" className="flex items-center text-white px-3 py-2 rounded-md text-sm font-medium">
                            <img src="profile-pic-url.jpg" alt="Profile" className="h-8 w-8 rounded-full"/>
                            Profil
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
