import React, {memo, useEffect, useRef, useState} from 'react';
import axios from 'axios';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import ReactMarkdown from 'react-markdown';
import injectCodeEditors from "@/CodeEditorInjector";

/**
 * Task component
 */
const Task = memo(({ id, title, activeTab }) => {
    const [assignment, setAssignment] = useState({});
    const [tasks, setTasks] = useState([]);
    const [currentTaskIndex, setCurrentTaskIndex] = useState(0);
    const [timerStarted, setTimerStarted] = useState(false);
    const [timePassed, setTimePassed] = useState(0);
    const [answers, setAnswers] = useState({});
    const isFirstRun = useRef(true);

    useEffect(() => {
        axios.get(`/algoritmizator/api/task/${id}`)
            .then(response => {
                setAssignment(response.data.assignment);
                setTasks(response.data.tasks);
                setCurrentTaskIndex(0);
            })
            .catch(error => {
                alert("Hiba történt a feladat betöltése közben. Kérlek, próbáld újra később!");
            });
    }, [id]);

    useEffect(() => {
        if (isFirstRun.current) {
            isFirstRun.current = false;
            return;
        }

        injectCodeEditors();

    }, [currentTaskIndex]);


    useEffect(() => {
        let timer;
        if (timerStarted) {
            timer = setInterval(() => {
                setTimePassed(prev => prev + 1);
            }, 1000);
        }
        return () => clearInterval(timer);
    }, [timerStarted]);

    const handleStartTask = () => {
        setTimerStarted(true);
    };

    const handleNextTask = () => {
        if (!validateCurrentTask()) {
            alert('Kérlek az összes kérdésre válaszolj!');
            return;
        }

        if (currentTaskIndex < tasks.length - 1) {
            setCurrentTaskIndex(currentTaskIndex + 1);
        } else {
            const data = {
                assignment_id: assignment.id,
                tasks: tasks.map(task => ({
                    id: task.id,
                    questions: task.questions.map(question => ({
                        id: question.id,
                        answer: answers[question.id]
                    }))
                })),
                time: timePassed
            };
            axios.post('/algoritmizator/api/task/submit', data)
                .then(response => {
                    window.location.href = `/algoritmizator/lessons/task/attempt/${response.data.attempt_id}`;
                })
                .catch(error => {
                    alert('Hiba történt a feladat beküldése közben. Kérlek, próbáld újra később!');
                });
        }
    };

    const validateCurrentTask = () => {
        const currentTask = tasks[currentTaskIndex];
        return currentTask.questions.every(question => {
            const answer = answers[question.id];
            if (currentTask.type === 'result') {
                return answer !== undefined && answer.trim() !== '';
            }
            return answer !== undefined;
        });
    };

    const handleAnswerChange = (questionId, value) => {
        setAnswers({
            ...answers,
            [questionId]: value
        });
    };

    const renderTaskContent = (task) => {
        return (
            <div>
                <div className="mb-6">
                    <ReactMarkdown className="break-all">{task.markdown}</ReactMarkdown>
                </div>
                {task.questions.map((question, qIndex) => (
                    <div key={qIndex} className="mb-8 bg-gray-900 rounded-lg pb-4 pl-5 pr-5">
                        <div className="mb-8 pt-1 border-b-2 border-white">
                            <ReactMarkdown className="break-all">{question.markdown}</ReactMarkdown>
                        </div>
                        {task.type === 'true_false' && (
                            question.answers.map((answer, aIndex) => (
                                <label key={aIndex} className="block mb-2">
                                    <input
                                        type="radio"
                                        name={`question-${qIndex}`}
                                        value={answer.id}
                                        checked={answers[question.id] === answer.id}
                                        onChange={() => handleAnswerChange(question.id, answer.id)}
                                        className="mr-2"
                                    />
                                    {answer.answer}
                                </label>
                            ))
                        )}
                        {task.type === 'quiz' && (
                            question.answers.map((answer, aIndex) => (
                                <label key={aIndex} className="block mb-2">
                                    <input
                                        type="radio"
                                        name={`question-${qIndex}`}
                                        value={answer.id}
                                        checked={answers[question.id] === answer.id}
                                        onChange={() => handleAnswerChange(question.id, answer.id)}
                                        className="mr-2"
                                    />
                                    {answer.answer}
                                </label>
                            ))
                        )}
                        {task.type === 'checkbox' && (
                            question.answers.map((answer, aIndex) => (
                                <label key={aIndex} className="block mb-2">
                                    <input
                                        type="checkbox"
                                        name={`question-${qIndex}`}
                                        value={answer.id}
                                        checked={Array.isArray(answers[question.id]) && answers[question.id].includes(answer.id)}
                                        onChange={(e) => {
                                            const checked = e.target.checked;
                                            setAnswers({
                                                ...answers,
                                                [question.id]: checked
                                                    ? [...(answers[question.id] || []), answer.id]
                                                    : (answers[question.id] || []).filter(id => id !== answer.id)
                                            });
                                        }}
                                        className="mr-2"
                                    />
                                    {answer.answer}
                                </label>
                            ))
                        )}
                        {task.type === 'result' && (
                            <input
                                type="text"
                                name={`question-${qIndex}`}
                                value={answers[question.id] || ''}
                                onChange={(e) => handleAnswerChange(question.id, e.target.value)}
                                className="px-4 py-2 w-full text-2xl rounded-lg bg-gray-700 text-white"
                                placeholder="Válasz..."
                            />
                        )}
                    </div>
                ))}
            </div>
        );
    };

    const currentTask = tasks[currentTaskIndex];
    const progress = (currentTaskIndex) / (tasks.length - 1) * 100;

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="markdown w-full max-w-4xl bg-gray-800 text-white rounded-lg shadow-lg p-8">
                    <div className="w-full h-2 relative">
                        <div className="flex justify-between absolute top-0 left-0 w-full">
                            {tasks.map((task, index) => (
                                <div className="z-20">
                                    <br></br>
                                    <div key={index}
                                         className={`w-4 h-4 rounded-full ${index <= currentTaskIndex ? 'bg-green-500' : 'bg-gray-300'}`}
                                         style={{marginLeft: index === 0 ? '0' : '-8px'}}></div>
                                </div>
                            ))}
                        </div>
                        <div className="w-full bg-gray-300 h-2 absolute top-0 left-0 mt-7"></div>
                    </div>
                    <div className="w-full bg-green-500 h-2 relative mt-5 mb-5" style={{width: `${progress}%`}}></div>
                    {!timerStarted ? (
                        <div className="text-center mt-5 mb-8">
                            <h2 className="text-3xl font-bold mb-4">{assignment.title}</h2>
                            <div className="mb-4">
                                <ReactMarkdown className="break-all">{assignment.markdown}</ReactMarkdown>
                            </div>
                            <button onClick={handleStartTask}
                                    className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">Feladat
                                indítása
                            </button>
                        </div>
                    ) : (
                        <div>
                            <div className="mb-8">
                                <h3 className="text-2xl font-bold mb-4">{currentTask.title}</h3>
                                <p className="text-lg text-gray-300 mb-4">Eltelt
                                    idő: {new Date(timePassed * 1000).toISOString().substring(11, 19)}</p>
                            </div>
                            {renderTaskContent(currentTask)}
                            <div className="text-center mt-8">
                                <button onClick={handleNextTask}
                                        className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300">
                                    {currentTaskIndex < tasks.length - 1 ? 'Következő feladat' : 'Feladat beküldése'}
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Task;
