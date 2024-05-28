import React, {memo, useEffect, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

/**
 * UserProfile component
 *
 * This component displays a user's profile information and their successful task attempts.
 * @param {object} props - The component props
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The active tab in the navigation
 * @param {string} props.id - The ID of the user whose profile is to be displayed
 * @returns {JSX.Element} UserProfile component
 */
const UserProfile = memo(({title, activeTab, id}) => {
    const [profileUser, setProfileUser] = useState({});
    const [successfulAttempts, setSuccessfulAttempts] = useState([]);

    // Fetch user profile data and their successful task attempts when the component mounts
    useEffect(() => {
        axios.get('/algoritmizator/api/users/' + id)
            .then(response => {
                setProfileUser(response.data);

                const id = response.data.id;
                axios.get(`/algoritmizator/api/task/attempts/successful/user/${id}`)
                    .then(attemptResponse => {
                        setSuccessfulAttempts(attemptResponse.data);
                    })
                    .catch(attemptError => {
                        alert("Hiba történt a feladatok betöltése közben. Kérlek, próbáld újra később!");
                        setSuccessfulAttempts([]);
                    });
            }).catch(error => {
            alert("Hiba történt az adatok betöltése közben. Kérlek, próbáld újra később!");
        });
    }, [id]);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-4xl bg-gray-800 p-6 rounded-lg shadow-lg text-white space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <div className="relative inline-block">
                                <img
                                    src={"/algoritmizator/storage/" + profileUser.avatar}
                                    alt="Profile"
                                    className="w-32 h-32 rounded-full object-cover border-4 border-purple-800"
                                />
                            </div>

                            <h1 className="text-3xl font-bold">{profileUser.name}</h1>
                            <p className="text-xl">{profileUser.username}</p>
                            <p className="text-md">{profileUser.email}</p>
                            <p className="text-sm">
                                Regisztráció dátuma: {new Date(profileUser.created_at).toLocaleString('hu-HU', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}
                            </p>
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
                        <div className="overflow-auto w-full mt-2" style={{maxHeight: 'calc(50vh)'}}>
                            {successfulAttempts.length === 0 && <p className="text-center">Még nem teljesített feladatot. :(</p>}
                            {successfulAttempts.map(attempt => (
                                <div key={attempt.id}
                                     className="flex items-center justify-between mx-4 p-3 border-t border-purple-500 hover:bg-gray-900 transition duration-300 rounded-lg">
                                    <div className="flex items-center flex-1">
                                        <div>
                                            <h3 className="text-lg">{attempt.title}</h3>
                                        </div>
                                    </div>
                                    <div className="flex flex-col items-end">
                                        <p className="text-gray-400 text-sm">{attempt.total_score}/{attempt.max_score} pont</p>
                                        <p className="text-green-500 font-bold text-sm">+{attempt.assignment_xp} XP</p>
                                        <p className="text-gray-400 text-sm">Idő: {attempt.time}</p>
                                        <p className="text-gray-400 text-sm">{new Date(attempt.created_at).toLocaleString('hu-HU', {
                                            year: 'numeric',
                                            month: '2-digit',
                                            day: '2-digit',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        })}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                    <hr className="border-purple-600 border-2 mx-auto"/>
                    <div className="flex w-full">
                        <a href="/algoritmizator/app/socials"
                           className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">Vissza</a>
                        <div className="flex-grow"></div>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default UserProfile;
