import React, {memo, useEffect, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Dashboard component
 */
const Dashboard = memo(({ title, activeTab}) => {
    const [friends, setFriends] = useState([]);
    const [completedAssignments, setCompletedAssignments] = useState([]);
    useEffect(() => {
        axios.get(`/algoritmizator/api/socials/online_friends`)
            .then(response => {
                setFriends(response.data);
            })
            .catch(error => {
                console.error('Error fetching friends:', error);
                setFriends([]);
            });
    }, []);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex items-stretch min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col">
                    <h3 className="text-xl font-bold mb-3">Teljesített Feladatok</h3>
                    <hr className="border-2 border-purple-700 mb-3"/>
                    <ul className="flex-grow">
                        <li>Feladat 1 - Teljesítve</li>
                        <li>Feladat 2 - Teljesítve</li>
                        <li>Feladat 3 - Folyamatban</li>
                    </ul>
                </div>
                <div className="w-full text-center m-5">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Vezérlőpult</h2>
                        <p className="text-lg text-gray-300">Üdvözlünk újra! Készen állsz a mai tanulásra?</p>
                    </div>
                    <div className="flex flex-col items-center m-10">
                        <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-xl">
                            <h3 className="text-2xl font-bold text-white mb-4">Legutóbbi feladatok</h3>
                            <p className="text-lg text-gray-300 mb-4">Nemrég fejezte be a "Bevezetés az algoritmusokba" című feladatot.</p>
                            <a href="/algoritmizator/app/assignments" className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Feladatok megtekintése</a>
                        </div>
                    </div>
                </div>
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col">
                    <h3 className="text-xl font-bold mb-3">Online Barátok</h3>
                    <hr className="border-2 border-purple-700 mb-3"/>
                    <div className="overflow-auto" style={{maxHeight: 'calc(100vh)'}}>
                        {friends.length === 0 && <p>Nincsenek online barátok. :(</p>}
                        {friends.map(friend => (
                            <a key={friend.id} href={"/algoritmizator/app/socials/profile" + friend.id}
                                 className="flex items-center justify-between mx-4 p-3 border-b border-purple-500">
                                <div className="flex items-center flex-1">
                                    <img src={"/algoritmizator/storage/" + friend.avatar} alt={friend.name}
                                         className={`w-12 h-12 rounded-full mr-4 border-2 border-green-500`}/>
                                    <div>
                                        <h3 className="text-lg">{friend.name}</h3>
                                        <p className="text-gray-400">{friend.username}</p>
                                        <p>LVL {friend.level} - {friend.total_xp} XP</p>
                                    </div>
                                </div>
                            </a>
                        ))}
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Dashboard;
