import React, {memo} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";


const Logout = memo(({title, activeTab, user}) => {
    console.log("Logout.jsx: Logging out...")
    axios.post('/algoritmizator/api/logout').then(r => {
        console.log('Logout successful:', r.data);
    }).catch(e => {
        console.error('Logout failed:', e.response.data);
    })
    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={null}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Sikeres kijelentkezés</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <p className="text-lg text-gray-300 mb-4">Önt kijelentkezték. Térjen vissza hamarosan!</p>
                        <a href="/algoritmizator/app" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Vissza a főoldalra</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default Logout;
