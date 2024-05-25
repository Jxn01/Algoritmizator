import React, {memo, useEffect, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * Socials component
 *
 * This is a functional component that renders a socials page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState hook to manage the state of the active social tab.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Socials component
 */
const Socials = memo(({title, activeTab}) => {
    const [activeSocialTab, setActiveSocialTab] = useState('friends');

    return (
        <div>
        <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-2xl mt-5 text-center">
                    <div className="flex space-x-2 mb-4">
                        <button onClick={() => setActiveSocialTab('friends')}
                                className={`px-4 py-2 text-white rounded-lg hover:bg-gray-800 transition duration-300 ${activeSocialTab === 'friends' ? 'bg-gray-800' : 'bg-purple-800'}`}>Barátok
                        </button>
                        <button onClick={() => setActiveSocialTab('requests')}
                                className={`px-4 py-2 text-white rounded-lg hover:bg-gray-800 transition duration-300 ${activeSocialTab === 'requests' ? 'bg-gray-800' : 'bg-purple-800'}`}>Kérelmek
                        </button>
                        <button onClick={() => setActiveSocialTab('search')}
                                className={`px-4 py-2 text-white rounded-lg hover:bg-gray-800 transition duration-300 ${activeSocialTab === 'search' ? 'bg-gray-800' : 'bg-purple-800'}`}>Keresés
                        </button>
                    </div>
                    {activeSocialTab === 'friends' && <FriendsComponent/>}
                    {activeSocialTab === 'requests' && <FriendRequestsComponent/>}
                    {activeSocialTab === 'search' && <SearchComponent/>}
                </div>
            </div>
            <Footer/>
        </div>
    );
});

/**
 * FriendsComponent component
 *
 * This is a functional component that fetches and renders the user's friends.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState and useEffect hooks to manage the state of the friends and to fetch the friends when the component is mounted.
 *
 * @returns {JSX.Element} The FriendsComponent component
 */
export const FriendsComponent = memo(() => {
    const [friends, setFriends] = useState([]);

    useEffect(() => {
        axios.get(`/algoritmizator/api/socials/friends`)
            .then(response => {
                setFriends(response.data.sort((a, b) => (a.is_online < b.is_online) ? 1 : -1));
            })
            .catch(error => {
                alert("Hiba történt a barátok betöltése közben. Kérlek, próbáld újra később!");
                setFriends([]);
            });
    }, []);

    const handleUnfriend = (friendId) => {
        axios.post(`/algoritmizator/api/socials/remove-friend`, { friendId })
            .then(response => {
                alert('Barát eltávolítva')
            })
            .catch(error => {
                alert('Hiba történt a barát eltávolítása közben')
            });
        setFriends(friends.filter(friend => friend.id !== friendId));
    };

    return (
        <div className="min-h-screen bg-gray-800 rounded-lg text-white mb-5">
            <h1 className={'text-3xl pl-7 text-start text-white py-4'}>Barátok</h1>
            <hr className={'border-purple-600 border-2 w-11/12 mx-auto'}/>
            <div className="max-w-4xl py-4">
                    <div className="overflow-auto" style={{ maxHeight: 'calc(100vh)' }}>
                        {friends.map(friend => (
                            <div key={friend.id}
                                 className="flex items-center justify-between mx-4 p-3 border-b border-purple-500 rounded-lg hover:bg-gray-900 transition duration-300">
                                <div className="flex items-center flex-1">
                                    <img src={"/algoritmizator/storage/"+friend.avatar} alt={friend.name}
                                            className={`w-12 h-12 rounded-full mr-4 ${friend.is_online ? 'border-2 border-green-500' : ''}`}/>
                                    <div>
                                        <h3 className="text-lg">{friend.name}</h3>
                                        <p className="text-gray-400">{friend.username}</p>
                                        <p>LVL {friend.level} - {friend.total_xp} XP</p>
                                    </div>
                                    <div className="text-xs text-left ml-3">
                                        <p className={friend.is_online ? 'text-green-600' : 'text-gray-400'}>{friend.is_online ? 'Online' : 'Offline'}</p>
                                        <p className="text-gray-400">{friend.is_online ? '' : `Utoljára aktív: ${friend.last_online}`}</p>
                                        <p className="text-gray-400">{`Utoljára itt járt: ${friend.last_seen_at}`}</p>
                                        <p className="text-gray-400">{`Legutóbbi tevékenység: ${friend.last_activity}`}</p>
                                    </div>
                                </div>
                                <div>
                                    <a href={`/algoritmizator/app/socials/profile/${friend.id}`}
                                       className="px-6 py-2 mr-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition duration-300">Profil</a>
                                    <button onClick={() => handleUnfriend(friend.id)}
                                            className="px-4 py-2 bg-red-600 rounded-lg hover:bg-red-700 transition duration-300">Eltávolítás
                                    </button>
                                </div>
                            </div>
                        ))}
                        {friends.length === 0 && <p className="text-center">Nincsenek barátok. :(</p>}
                    </div>
            </div>
        </div>
    );
});

/**
 * FriendRequestsComponent component
 *
 * This is a functional component that fetches and renders the user's friend requests.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState and useEffect hooks to manage the state of the friend requests and to fetch the friend requests when the component is mounted.
 *
 * @returns {JSX.Element} The FriendRequestsComponent component
 */
export const FriendRequestsComponent = memo(() => {
    const [requests, setRequests] = useState([]);

    useEffect(() => {
        axios.get(`/algoritmizator/api/socials/friend-requests`)
            .then(response => {
                setRequests(response.data);
            })
            .catch(error => {
                alert("Hiba történt a barátkérelmek betöltése közben. Kérlek, próbáld újra később!");
                setRequests([]);
            });
    }, []);

    const handleAccept = (friendId) => {
        axios.post(`/algoritmizator/api/socials/accept-friend-request`, { friendId })
            .then(response => {
                alert('Barátkérelem elfogadva')
                setRequests(requests.filter(request => request.id !== friendId));
            })
            .catch(error => {
                alert('Hiba történt a barátkérelem elfogadása közben')
            });
    };

    const handleDeny = (friendId) => {
        axios.post(`/algoritmizator/api/socials/reject-friend-request`, { friendId })
            .then(response => {
                alert('Barátkérelem elutasítva')
                setRequests(requests.filter(request => request.id !== friendId));
            })
            .catch(error => {
                alert('Hiba történt a barátkérelem elutasítása közben')
            });
    };

    return (
        <div className="min-h-screen bg-gray-800 rounded-lg text-white mb-5">
            <h1 className={'text-3xl pl-7 text-start text-white py-4'}>Bejövő kérelmek</h1>
            <hr className={'border-purple-600 border-2 w-11/12 mx-auto'}/>
            <div className="max-w-4xl py-4">
                <div className="overflow-auto" style={{maxHeight: 'calc(100vh)'}}>
                    {requests.map(request => (
                        <div key={request.id}
                             className="flex items-center justify-between p-3 mx-4 border-b border-purple-500 rounded-lg hover:bg-gray-900 transition duration-300">
                            <div className="flex items-center flex-1">
                                <img src={"/algoritmizator/storage/"+request.avatar} alt={request.name}
                                     className="w-12 h-12 rounded-full mr-4"/>
                                <div>
                                    <h3 className="text-lg">{request.name}</h3>
                                    <p className="text-gray-400">{request.username}</p>
                                    <p>LVL {request.level} - {request.total_xp} XP</p>
                                </div>
                            </div>
                            <div>
                                <a href={`/algoritmizator/app/socials/profile/${request.id}`}
                                   className="px-6 py-2 mr-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition duration-300">Profil</a>
                                <button onClick={() => handleAccept(request.id)}
                                        className="px-4 py-2 mr-3 bg-green-600 rounded-lg hover:bg-green-700 transition duration-300">Elfogadás
                                </button>
                                <button onClick={() => handleDeny(request.id)}
                                        className="px-4 py-2 bg-red-600 rounded-lg hover:bg-red-700 transition duration-300">Elutasítás
                                </button>
                            </div>
                        </div>
                    ))}
                    {requests.length === 0 && <p className="text-center">Nincsenek bejövő barátkérelmek. :(</p>}
                </div>
            </div>
        </div>
    );
});

/**
 * SearchComponent component
 *
 * This is a functional component that allows the user to search for other users.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState hook to manage the state of the search query and the search results.
 *
 * @returns {JSX.Element} The SearchComponent component
 */
export const SearchComponent = memo(() => {
    const [query, setQuery] = useState('');
    const [results, setResults] = useState([]);

    const handleSearch = async (query) => {
        setQuery(query);
        if (query.trim() === '') {
            setResults([]);
            return;
        }

        await axios.get(`/algoritmizator/api/socials/search?query=${query}`)
            .then(response => {
                setResults(response.data);
            })
            .catch(error => {
                alert("Hiba történt a keresés közben. Kérlek, próbáld újra később!");
                setResults([]);
            });
    }

    const sendFriendRequest = (friendId, e) => {
        axios.post(`/algoritmizator/api/socials/send-friend-request`, { friendId })
            .then(response => {
                alert('Barátkérelem elküldve')
                e.target.disabled = true;
                e.target.innerText = 'Barátkérelem elküldve';
                e.target.classList.remove('bg-green-600');
                e.target.classList.remove('hover:bg-green-700');
                e.target.classList.add('bg-gray-600');

            })
            .catch(error => {
                alert('Hiba történt a barátkérelem elküldése közben')
            });
    }

    return (
        <div className="min-h-screen bg-gray-800 rounded-lg text-white mb-5">
            <h1 className={'text-3xl pl-7 text-start text-white py-4'}>Keresés</h1>
            <hr className={'border-purple-600 border-2 w-11/12 mx-auto'}/>
            <div className="max-w-4xl py-4">
                <div className="mx-7">
                    <input type="text" placeholder="Felhasználók keresése..."
                           value={query}
                           onChange={e => handleSearch(e.target.value)}
                           className="px-4 py-2 w-full text-2xl rounded-lg bg-gray-700 text-white"/>
                </div>

                <div className="space-y-4">
                    <div className="overflow-auto" style={{maxHeight: 'calc(100vh)'}}>
                        {results.map(user => (
                            <div key={user.id}
                                 className="flex items-center justify-between p-3 mx-4 border-b border-purple-500 rounded-lg hover:bg-gray-900 transition duration-300">
                                <div className="flex items-center flex-1">
                                    <img src={"/algoritmizator/storage/"+user.avatar} alt={user.name}
                                         className="w-12 h-12 rounded-full mr-4"/>
                                    <div>
                                        <h3 className={`text-lg ${user.is_friend ? 'text-purple-500' : 'text-white'}`}>{user.name}</h3>
                                        <p className={`${user.is_friend ? 'text-purple-600' : 'text-gray-400'}`}>{user.username}</p>
                                        <p className={`${user.is_friend ? 'text-purple-500' : 'text-white'}`}>LVL {user.level} - {user.total_xp} XP</p>
                                    </div>
                                </div>
                                <div>
                                    <a href={`/algoritmizator/app/socials/profile/${user.id}`}
                                       className="px-6 py-2 mr-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition duration-300">Profil
                                    </a>
                                    {!user.is_friend &&
                                        <button disabled={user.friend_request_sent || user.friend_request_received}
                                                onClick={(e) => sendFriendRequest(user.id, e)}
                                                className={`px-4 py-2 ${user.friend_request_sent || user.friend_request_received ? 'bg-gray-600' : 'bg-green-600 hover:bg-green-700 transition duration-300'} rounded-lg`}> {user.friend_request_sent ? 'Barátkérelem elküldve' : user.friend_request_received ? 'Barátkérelem fogadva' : 'Barátkérelem küldése'}
                                        </button>
                                    }
                                </div>
                            </div>
                        ))}
                        {results.length === 0 && <p className="text-center mt-10">Nincs találat. :(</p>}
                    </div>
                </div>
            </div>
        </div>
    );
});

export default Socials;
