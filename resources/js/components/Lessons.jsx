import React, { useState } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";

const Lessons = () => {
    const [activeLesson, setActiveLesson] = useState('Lecke 1');
    const lessons = ['Lecke 1', 'Lecke 2', 'Lecke 3']; // Extendable array

    return (
        <div>
            <Navbar />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-2xl text-center">
                    <div className="flex flex-col items-center mb-8">
                        <h2 className="text-3xl font-bold text-white mb-2">Leckék</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <div className="mb-4 flex justify-around">
                            {lessons.map(lesson => (
                                <button key={lesson} onClick={() => setActiveLesson(lesson)} className={`px-4 py-2 ${activeLesson === lesson ? 'bg-purple-900' : 'bg-purple-800'} text-white rounded-lg`}>{lesson}</button>
                            ))}
                        </div>
                        <div>
                            <p className="text-lg text-gray-300 mb-4">{`${activeLesson} tartalma.`}</p>
                            <a href={`/lesson/quiz`} className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Kvíz indítása</a>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
};

export default Lessons;
