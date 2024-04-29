import React, {memo, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const Socials = memo(({title, navActiveTab, user}) => {
    const [activeTab, setActiveTab] = useState('friends'); // 'friends', 'requests', 'search'

    return (
        <div>
        <Navbar title={title} activeTab={navActiveTab} user={user}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-2xl text-center">
                    <div className="flex flex-col items-center mb-8">
                        <div className="h-24 w-24 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                            <span className="text-xl font-semibold text-white">Közösség</span>
                        </div>
                        <h2 className="text-2xl font-bold text-white mb-2">Kapcsolatok kezelése</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <div className="mb-4 flex justify-between">
                            <button onClick={() => setActiveTab('friends')} className={`px-4 py-2 ${activeTab === 'friends' ? 'bg-purple-900' : 'bg-purple-800'} text-white rounded-lg`}>Barátok</button>
                            <button onClick={() => setActiveTab('requests')} className={`px-4 py-2 ${activeTab === 'requests' ? 'bg-purple-900' : 'bg-purple-800'} text-white rounded-lg`}>Kérelmek</button>
                            <button onClick={() => setActiveTab('search')} className={`px-4 py-2 ${activeTab === 'search' ? 'bg-purple-900' : 'bg-purple-800'} text-white rounded-lg`}>Keresés</button>
                        </div>
                        {activeTab === 'friends' && <FriendsComponent />}
                        {activeTab === 'requests' && <FriendRequestsComponent />}
                        {activeTab === 'search' && <SearchComponent />}
                    </div>
                </div>
            </div>
        <Footer />
    </div>
    );
});

export const FriendsComponent = memo(() => {
    const friends = [
        { id: 1, name: 'Alice', profileLink: '/profiles/alice' },
        { id: 2, name: 'Bob', profileLink: '/profiles/bob' }
    ];

    return (
        <div className="space-y-4">
            {friends.map(friend => (
                <div key={friend.id} className="flex justify-between items-center bg-gray-700 p-3 rounded">
                    <span className="text-white">{friend.name}</span>
                    <div>
                        <a href={friend.profileLink} className="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Profil megtekintése</a>
                        <button className="ml-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Eltávolítás</button>
                        <button className="ml-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Tiltás</button>
                    </div>
                </div>
            ))}
        </div>
    );
});

export const FriendRequestsComponent = memo(() => {
    const requests = [
        { id: 1, name: 'Charlie' },
        { id: 2, name: 'Dana' }
    ];

    return (
        <div className="space-y-4">
            {requests.map(request => (
                <div key={request.id} className="flex justify-between items-center bg-gray-700 p-3 rounded">
                    <span className="text-white">{request.name}</span>
                    <div>
                        <button className="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Elfogadás</button>
                        <button className="ml-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Elutasítás</button>
                        <button className="ml-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Tiltás</button>
                    </div>
                </div>
            ))}
        </div>
    );
});

export const SearchComponent = memo(() => {
    const users = [
        { id: 1, name: 'Eve' },
        { id: 2, name: 'Frank' }
    ];

    return (
        <div>
            <input type="text" placeholder="Felhasználók keresése..." className="mb-4 px-4 py-2 w-full rounded bg-gray-700 text-white" />
            <div className="space-y-4">
                {users.map(user => (
                    <div key={user.id} className="flex justify-between items-center bg-gray-700 p-3 rounded">
                        <span className="text-white">{user.name}</span>
                        <button className="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Barátkérelem elküldése</button>
                    </div>
                ))}
            </div>
        </div>
    );
});

export default Socials;
