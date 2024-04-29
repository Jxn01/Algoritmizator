import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const Forbidden = memo(() => {
    return (
        <div>
            <Navbar />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <div className="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                            <span className="text-xl font-semibold text-white">Logo</span>
                        </div>
                        <h2 className="text-3xl font-bold text-white mb-2">Hozzáférés megtagadva</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-white mb-4">403 Tiltott</h3>
                        <p className="text-lg text-gray-300 mb-4">Sajnáljuk, nincs jogosultsága az oldal eléréséhez. Ha úgy gondolja, hogy ez hiba, kérjük, lépjen kapcsolatba az ügyfélszolgálattal.</p>
                        <a href="/algoritmizator/auth/login" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Tovább a főoldalra</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Forbidden;
