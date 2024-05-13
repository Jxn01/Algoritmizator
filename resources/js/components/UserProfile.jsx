import React, {memo, useEffect, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * UserProfile component
 *
 * This is a functional component that renders a user's profile page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 *
 * @returns {JSX.Element} The UserProfile component
 */
const UserProfile = memo(({title, activeTab, id}) => {
    const [profileUser, setProfileUser] = useState({});

    useEffect(() => {
        axios.get('/algoritmizator/api/users/' + id)
            .then(response => {
                setProfileUser(response.data);
            }).catch(error => {
                console.error(error);
            });
    }, []);

    // Render the Navbar, user profile page, and Footer
    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div
                className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-4xl bg-gray-800 p-6 rounded-lg shadow-lg text-white space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <div className="relative inline-block">
                                <img
                                    src={"/algoritmizator/storage/" + profileUser.avatar}
                                    alt="Profile"
                                    className="w-32 h-32 rounded-full object-cover border-4 border-purple-800 cursor-pointer"
                                />
                            </div>

                            <h1 className="text-3xl font-bold">{profileUser.name}</h1>
                            <p className="text-xl">{profileUser.username}</p>
                            <p className="text-md">{profileUser.email}</p>
                            <p className="text-sm">Regisztráció
                                dátuma: {new Date(profileUser.created_at).toLocaleString('hu-HU', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</p>
                            <p className="text-sm text-gray-500">ID: {profileUser.id}</p>
                        </div>
                        <div>
                            <h2 className="text-2xl font-bold">Statisztikák</h2>
                            <p className="text-xl">Tapasztalatpontok: {profileUser.total_xp} XP</p>
                            <p className="text-xl">Szint: LVL {profileUser.level}</p>
                        </div>
                    </div>
                    <hr className="border-purple-600 border-2 mx-auto"/>
                    <div className="flex flex-col items-center justify-center">
                        <h2 className="text-2xl font-bold">Teljesített leckék</h2>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                    </div>
                    <hr className="border-purple-600 border-2 mx-auto"/>
                    <div className="flex w-full">
                        <a href="/algoritmizator/app/socials"
                           className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Vissza</a>
                        <div className="flex-grow"></div>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default UserProfile;
