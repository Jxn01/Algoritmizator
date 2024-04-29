import React, {memo} from 'react';

const InternalServerErrorPage = memo(() => {
    return (
        <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
            <div className="w-full max-w-md text-center">
                <div className="flex flex-col items-center mb-8">
                    <div className="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                        <span className="text-xl font-semibold text-white">Logo</span>
                    </div>
                    <h2 className="text-3xl font-bold text-white mb-2">Belső szerver hiba</h2>
                </div>
                <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                    <h3 className="text-2xl font-bold text-white mb-4">500-as hiba</h3>
                    <p className="text-lg text-gray-300 mb-4">Sajnáljuk, valami rosszul sült el nálunk. Kérjük, próbálja meg később újra, vagy lépjen kapcsolatba az ügyfélszolgálattal, ha a probléma továbbra is fennáll.</p>
                    <a href="/algoritmizator/app" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Tovább a főoldalra</a>
                </div>
            </div>
        </div>
    );
});

export default InternalServerErrorPage;
