import React, { memo, useState } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const UserProfile = memo(({title, activeTab, user, profileUser}) => {

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div
                className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-4xl bg-gray-800 p-6 rounded-lg shadow-lg text-white space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <div className="relative inline-block">
                                <img
                                    src={"/storage/" + profileUser.avatar}
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
