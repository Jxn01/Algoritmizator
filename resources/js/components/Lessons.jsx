import React, {memo, useEffect, useState, useRef} from 'react';
import ReactMarkdown from 'react-markdown';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faFileAlt, faCheck} from "@fortawesome/free-solid-svg-icons";
import injectCodeEditors from "@/CodeEditorInjector";

/**
 * Lessons component
 *
 * This is a functional component that renders a list of lessons and their content.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState hook to manage the state of the selected lesson and subLesson.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Lessons component
 */
const Lessons = memo(({title, activeTab}) => {
    const [lessons, setLessons] = useState([]);
    const [selectedLesson, setSelectedLesson] = useState([]);
    const [selectedSublesson, setSelectedSublesson] = useState([]);
    const [successfulAttempts, setSuccessfulAttempts] = useState([]);
    const isFirstRun = useRef(true);

    useEffect(() => {
        axios.get('/algoritmizator/api/lessons')
            .then(response => {
                setLessons(response.data);
                setSelectedLesson(response.data[0]);
                setSelectedSublesson(response.data[0].sublessons[0]);
            })
            .catch(error => {
                alert("Hiba történt a leckék betöltése közben. Kérlek, próbáld újra később!");
            });

        axios.get('/algoritmizator/api/user')
            .then(r => {
                const id = r.data.id;
                axios.get(`/algoritmizator/api/task/attempts/successful/user/${id}`)
                    .then(response => {
                        setSuccessfulAttempts(response.data);
                    })
                    .catch(error => {
                        alert("Hiba történt az adatok betöltése közben. Kérlek, próbáld újra később!");
                        setSuccessfulAttempts([]);
                    });
            })
            .catch(e => {
                alert("Hiba történt az adatok betöltése közben. Kérlek, próbáld újra később!");
            });
    }, []);

    useEffect(() => {
        if (isFirstRun.current) {
            isFirstRun.current = false;
            return;
        }

        injectCodeEditors();

    }, [selectedSublesson]);

    return (
        <div className="bg-gray-800">
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex">
                <div className="min-w-64 min-h-screen bg-gray-800 text-white p-5">
                    <h2 className="text-xl font-bold mb-3 border-purple-800 border-b-3">Leckék</h2>
                    {lessons.map((lesson) => (
                        <div key={lesson.id}>
                            <button
                                onClick={() => {
                                    setSelectedLesson(lesson);
                                    setSelectedSublesson(lesson.sublessons[0]);
                                }}
                                className={`w-full text-left py-1 px-4 mb-1 rounded-lg cursor-pointer transition duration-300 ease-in-out transform hover:translate-x-1 hover:bg-purple-800 ${
                                    selectedLesson === lesson ? "bg-purple-800" : "bg-transparent"
                                }`}>
                                {lesson.title}
                            </button>
                            {selectedLesson === lesson && (
                                <div className="pl-4 overflow-hidden transition-max-height duration-700 ease-in-out">
                                    {lesson.sublessons.map(sublesson => (
                                        <div key={sublesson.id}
                                             onClick={() => setSelectedSublesson(sublesson)}
                                             className={`py-1 px-3 mb-1 text-sm rounded-lg cursor-pointer transition duration-300 ease-in-out transform hover:translate-x-1 ${
                                                 selectedSublesson === sublesson ? "text-purple-500 font-bold" : ""}`}>
                                            {sublesson.has_quiz ? <FontAwesomeIcon icon={faFileAlt} className="mr-2"/> : null}
                                            <span className={successfulAttempts.some(attempt => attempt.sublesson_id === sublesson.id) ? "text-green-500" : ""}>
                                                {sublesson.title}
                                                {successfulAttempts.some(attempt => attempt.sublesson_id === sublesson.id) ? <FontAwesomeIcon icon={faCheck} className="ml-2"/> : null}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    ))}
                </div>
                <div className="flex-grow bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-20 pt-10 rounded-lg">
                    <div className="bg-gray-800 p-5 rounded-lg text-white">
                        <h1 className="text-3xl font-bold ml-7 mb-2">{selectedLesson ? selectedLesson.title : "Válassz ki egy leckét!"}</h1>
                        <h2 className="text-2xl ml-7">{selectedSublesson ? selectedSublesson.title : 'Válassz ki egy alleckét!'}</h2>
                        <hr className="border-purple-800 border-2 mt-4"/>
                        <div className="markdown">
                            {selectedSublesson ? <ReactMarkdown children={selectedSublesson.markdown} /> : 'Válassz ki egy alleckét a tartalom megtekintéséhez!'}
                        </div>
                        {selectedSublesson && selectedSublesson.has_quiz ? (
                            <div className="mt-4 text-center items-center">
                                <button className="bg-purple-800 text-white px-4 py-2 rounded-lg hover:bg-purple-900 transition duration-300" onClick={() => window.location.href = `/algoritmizator/lessons/task/${selectedSublesson.id}`}>Feladat megoldása</button>
                            </div>
                        ) : null}
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Lessons;
