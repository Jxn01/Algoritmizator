import React, {memo, useEffect, useRef, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import ReactMarkdown from "react-markdown";
import injectCodeEditors from "@/CodeEditorInjector";

/**
 * Dashboard component
 */
const Dashboard = memo(({ title, activeTab}) => {
    const [friends, setFriends] = useState([]);
    const [successfulAttempts, setSuccessfulAttempts] = useState([]);
    const [lesson, setLesson] = useState({});
    const isFirstRun = useRef(true);

    useEffect(() => {
        axios.get(`/algoritmizator/api/socials/online-friends`)
            .then(response => {
                setFriends(response.data);
            })
            .catch(error => {
                alert("Hiba történt a barátok lekérdezése során. :(");
                setFriends([]);
            });

        axios.get('/algoritmizator/api/user')
            .then(r => {
                const id = r.data.id;
                axios.get(`/algoritmizator/api/task/attempts/successful/user/${id}`)
                    .then(response => {
                        setSuccessfulAttempts(response.data);
                    })
                    .catch(error => {
                        alert("Hiba történt a feladatok lekérdezése során. :(");
                        setSuccessfulAttempts([]);
                    });
            })
            .catch(e => {
                alert("Hiba történt a feladatok lekérdezése során. :(");
            });

        axios.get('/algoritmizator/api/lesson-of-the-hour')
            .then(response => {
                setLesson(response.data);
            })
            .catch(error => {
                alert("Hiba történt a lecke lekérdezése során. :(");
                setLesson({});
            });
    }, []);

    useEffect(() => {
        if (isFirstRun.current) {
            isFirstRun.current = false;
            return;
        }

        injectCodeEditors();

    }, [lesson]);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex items-stretch min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col" style={{maxHeight: 'calc(85vh)', position: 'sticky', top: '20px'}}>
                    <h3 className="text-xl font-bold mb-3">Teljesített Feladatok</h3>
                    <hr className="border-2 border-purple-700 mb-3"/>
                    <div className="overflow-auto" style={{maxHeight: 'calc(80vh)'}}>
                        {successfulAttempts.length === 0 && <p>Még nem teljesítettél feladatot. :(</p>}
                        {successfulAttempts.map(attempt => (
                            <a key={attempt.id} href={`/algoritmizator/lessons/task/attempt/${attempt.id}`}
                                 className="flex items-center justify-between mx-4 p-3 border-b border-purple-500">
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
                            </a>
                        ))}
                    </div>
                </div>
                <div className="w-full m-5">
                    <div className="flex flex-col items-center text-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Vezérlőpult</h2>
                        <p className="text-lg text-gray-300">Üdvözlünk újra! Készen állsz a mai tanulásra?</p>
                    </div>
                    <div className="flex flex-col items-center m-10">
                        <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-xl">
                            <h1 className="text-2xl font-bold text-center text-white mb-4">Az óra leckéje</h1>
                            <hr className="border-2 border-purple-700 mb-4"/>
                            <div className="markdown">
                                <h1 className="text-xl font-bold text-center text-white mb-2">{lesson.title}</h1>
                                <div className="markdown">
                                    {lesson ? <ReactMarkdown
                                        children={lesson.markdown}/> : 'Nincs megjeleníthető tartalom. :('}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col" style={{maxHeight: 'calc(85vh)', position: 'sticky', top: '20px'}}>
                    <h3 className="text-xl font-bold mb-3">Online Barátok</h3>
                    <hr className="border-2 border-purple-700 mb-3"/>
                    <div className="overflow-auto" style={{maxHeight: 'calc(80vh)'}}>
                        {friends.length === 0 && <p>Nincsenek online barátok. :(</p>}
                        {friends.map(friend => (
                            <a key={friend.id} href={"/algoritmizator/app/socials/profile/" + friend.id}
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
