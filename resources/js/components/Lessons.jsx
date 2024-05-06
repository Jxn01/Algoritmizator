import React, {memo, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const lessons = [
    {
        id: 1,
        title: "Bevezetés",
        subLessons: [
            { title: "Áttekintés", content: "Az adatszerkezetek és algoritmusok áttekintése." },
            { title: "Történelem", content: "A tudományág történelmi fejlődése." }
        ]
    },
    {
        id: 2,
        title: "Alapvető adatszerkezetek",
        subLessons: [
            { title: "Verem", content: "A verem (stack) működése és alkalmazásai." },
            { title: "Sor", content: "A sor (queue) felépítése és használata." },
            { title: "Linkelt listák", content: "Linkelt listák különböző típusai és jellemzőik." }
        ]
    },
    {
        id: 3,
        title: "Haladó adatszerkezetek",
        subLessons: [
            { title: "Fák", content: "Fák és fákon alapuló adatszerkezetek." },
            { title: "Gráfok", content: "Gráfok és azok algoritmusai." },
            { title: "Hash táblák", content: "Hash táblák és használatuk a gyakorlatban." }
        ]
    },
    {
        id: 4,
        title: "Algoritmusok",
        subLessons: [
            { title: "Rendezési algoritmusok", content: "Különböző rendezési technikák." },
            { title: "Keresési algoritmusok", content: "Hatékony keresési módszerek." },
            { title: "Gráf algoritmusok", content: "Algoritmusok gráfok feldolgozására." }
        ]
    },
    {
        id: 5,
        title: "Komplexitás és Big O notáció",
        subLessons: [
            { title: "Bevezetés a komplexitásba", content: "Komplexitáselmélet alapjai." },
            { title: "Big O notáció", content: "Az algoritmusok futási idejének elemzése Big O notációval." },
            { title: "Példák és elemzés", content: "Komplexitáselemzés gyakorlati példákon keresztül." }
        ]
    }
];

const Lessons = memo(({title, activeTab, user}) => {
    const [selectedLesson, setSelectedLesson] = useState(lessons[0]);
    const [selectedSubLesson, setSelectedSubLesson] = useState(lessons[0].subLessons[0]);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div className="flex">
                <div className="w-64 min-h-screen bg-gray-800 text-white p-5">
                    <h2 className="text-xl font-bold mb-3">Leckék</h2>
                    {lessons.map((lesson) => (
                        <div key={lesson.id}>
                            <button
                                onClick={() => {
                                    setSelectedLesson(lesson);
                                    setSelectedSubLesson(lesson.subLessons[0]);
                                }}
                                className={`w-full text-left py-1 px-4 mb-1 rounded-lg cursor-pointer transition duration-300 ease-in-out transform hover:translate-x-1 hover:bg-purple-800 ${
                                    selectedLesson === lesson ? "bg-purple-800" : "bg-transparent"
                                }`}>
                                {lesson.title}
                            </button>
                            {selectedLesson === lesson && (
                                <div className="pl-4 overflow-hidden transition-max-height duration-700 ease-in-out">
                                    {lesson.subLessons.map(subLesson => (
                                        <div key={subLesson.title}
                                             onClick={() => setSelectedSubLesson(subLesson)}
                                             className={`py-1 px-3 mb-1 text-sm rounded-lg cursor-pointer transition duration-300 ease-in-out transform hover:translate-x-1 ${
                                                 selectedSubLesson === subLesson ? "text-purple-500 font-bold" : "text-white"
                                             }`}>
                                            {subLesson.title}
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    ))}
                </div>
                <div className="flex-grow bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                    <div className="bg-gray-800 p-5 rounded-lg text-white">
                        <h1 className="text-2xl font-bold">{selectedLesson ? selectedLesson.title : "Select a Lesson"}</h1>
                        <h2 className="text-xl">{selectedSubLesson ? selectedSubLesson.title : 'Select a Sub-Lesson'}</h2>
                        <p className="mt-4">
                            {selectedSubLesson ? selectedSubLesson.content : 'Please select a sub-lesson to view the content.'}
                        </p>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Lessons;
