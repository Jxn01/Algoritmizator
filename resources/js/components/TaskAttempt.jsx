import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import ReactMarkdown from 'react-markdown';
import injectCodeEditors from "@/CodeEditorInjector";
import Loading from "@/components/Loading.jsx";
import FailedToLoad from "@/components/FailedToLoad.jsx";

/**
 * TaskAttempt component
 *
 * This component displays the details of a user's attempt at a task, including their answers, scores, and status.
 * @param {object} props - The component props
 * @param {string} props.id - The ID of the task attempt
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The active tab in the navigation
 * @returns {JSX.Element} TaskAttempt component
 */
const TaskAttempt = ({ id, title, activeTab }) => {
    const [attempt, setAttempt] = useState(null);
    const [loading, setLoading] = useState(true);
    const isFirstRun = useRef(true);

    // Fetch task attempt data from the API when the component mounts or the attempt ID changes
    useEffect(() => {
        axios.get(`/algoritmizator/api/task/attempt/${id}`)
            .then(response => {
                setAttempt(response.data);
                setLoading(false);
            })
            .catch(error => {
                alert('Hiba történt az adatok betöltése közben. Kérlek, próbáld újra később!');
                setLoading(false);
            });
    }, [id]);

    // Inject code editors once the loading is complete (but not on first run)
    useEffect(() => {
        if (isFirstRun.current) {
            isFirstRun.current = false;
            return;
        }

        injectCodeEditors();
    }, [loading]);

    // Display a loading message while data is being fetched
    if (loading) {
        return <Loading />;
    }

    // Display an error message if the attempt data could not be fetched
    if (!attempt) {
        return <FailedToLoad />;
    }

    /**
     * Format the given time string.
     * @param {string} timeString - The time string to format
     * @returns {string} - The formatted time string
     */
    const formatTime = (timeString) => {
        return timeString;
    };

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="w-full max-w-4xl bg-gray-800 text-white rounded-lg shadow-lg p-8">
                    <h2 className="text-3xl font-bold mb-4">{attempt.assignment.title}</h2>
                    <div className="mb-8">
                        <ReactMarkdown className="break-all">{attempt.assignment.markdown}</ReactMarkdown>
                    </div>
                    {attempt.tasks.map((task, tIndex) => (
                        <div key={tIndex} className="mb-8 border-t border-gray-500 pt-8">
                            <h3 className="text-2xl font-bold mb-4">{task.title}</h3>
                            <div className="mb-6">
                                <ReactMarkdown className="break-all">{task.markdown}</ReactMarkdown>
                            </div>
                            {task.questions.map((question, qIndex) => (
                                <div key={qIndex} className="mb-8 bg-gray-900 rounded-lg pb-4 pl-5 pr-5">
                                    <div className="mb-8 pt-4 pb-3 border-b-2 border-white">
                                        <ReactMarkdown className="break-all">{question.markdown}</ReactMarkdown>
                                    </div>
                                    <div>
                                        {task.type === 'result' && (
                                            <div className="mb-2">
                                                <strong>Helyes válasz:</strong> {question.answers[0].answer}
                                                <br/>
                                                <span className={`text-${question.answers[0].answer === question.submitted_answers[0].custom_answer ? 'green' : 'red'}-500`}>
                                                    <strong>A Te válaszod: </strong>
                                                    {question.submitted_answers[0].custom_answer}
                                                </span>
                                                <span className="ml-2">
                                                    {question.answers[0].answer === question.submitted_answers[0].custom_answer ? '✔' : '✖'}
                                                </span>
                                            </div>
                                        )}
                                        {task.type !== 'result' && (
                                            <div>
                                                {question.answers.map((answer, aIndex) => {
                                                    const isSubmitted = question.submitted_answers.some(sa => sa.answer_id === answer.id);
                                                    const isCorrect = answer.is_correct;
                                                    const className = isSubmitted
                                                        ? (isCorrect ? 'text-green-500' : 'text-red-500')
                                                        : (task.type === 'checkbox' && isCorrect ? 'text-yellow-500' : 'text-gray-300');

                                                    return (
                                                        <div key={aIndex} className={`mb-2 ${className}`}>
                                                            <strong>Válasz:</strong> {answer.answer}
                                                            {isSubmitted && (
                                                                <span className="ml-2">
                                                                    {isCorrect ? '✔' : '✖'}
                                                                </span>
                                                            )}
                                                        </div>
                                                    );
                                                })}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    ))}
                    <div className="mt-6 text-center border-t border-gray-500 pt-6 flex justify-between items-center">
                        <button className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition duration-300" onClick={() => window.location.href = '/algoritmizator/app/lessons'}>
                            Vissza a leckékhez
                        </button>
                        <div>
                            <p><strong>Pontszám:</strong> {attempt.total_score} / {attempt.max_score}</p>
                            <p><strong>Eltelt idő:</strong> {formatTime(attempt.time)}</p>
                            <p><strong>Státusz:</strong> {attempt.passed ? 'Sikeres' : 'Sikertelen'}</p>
                            <p><strong>Kitöltés dátuma:</strong> {new Date(attempt.created_at).toLocaleString('hu-HU')}</p>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
};

export default TaskAttempt;
