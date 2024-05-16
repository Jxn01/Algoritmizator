import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import ReactMarkdown from 'react-markdown';

const TaskAttempt = ({ id, title, activeTab }) => {
    const [attempt, setAttempt] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get(`/algoritmizator/api/task/attempt/${id}`)
            .then(response => {
                setAttempt(response.data);
                setLoading(false);
            })
            .catch(error => {
                console.error('There was an error fetching the attempt:', error);
                alert('Failed to fetch attempt data.');
                setLoading(false);
            });
    }, [id]);

    if (loading) {
        return <div>Loading...</div>;
    }

    if (!attempt) {
        return <div>Failed to load attempt.</div>;
    }

    const formatTime = (timeString) => {
        // Assuming timeString is in 'HH:MM:SS' format (MySQL TIME format)
        return timeString;
    };

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} />
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="w-full max-w-4xl bg-gray-800 text-white rounded-lg shadow-lg p-8">
                    <h2 className="text-3xl font-bold mb-4">{attempt.assignment.title}</h2>
                    <div className="markdown mb-8">
                        <ReactMarkdown className="break-all">{attempt.assignment.markdown}</ReactMarkdown>
                    </div>
                    {attempt.tasks.map((task, tIndex) => (
                        <div key={tIndex} className="mb-8 border-t border-gray-500 pt-8">
                            <h3 className="text-2xl font-bold mb-4">{task.title}</h3>
                            <div className="markdown mb-4">
                                <ReactMarkdown className="break-all">{task.markdown}</ReactMarkdown>
                            </div>
                            {task.questions.map((question, qIndex) => (
                                <div key={qIndex} className="mb-6">
                                    <div className="markdown mb-2">
                                        <ReactMarkdown className="break-all">{question.markdown}</ReactMarkdown>
                                    </div>
                                    <div className="ml-4">
                                        {task.type === 'result' && (
                                            <div className="mb-2">
                                                <strong>Answer:</strong> {question.submitted_answers[0]?.custom_answer}
                                                <br />
                                                <strong>Correct:</strong> {question.answers[0].answer}
                                            </div>
                                        )}
                                        {task.type !== 'result' && (
                                            <div>
                                                {question.answers.map((answer, aIndex) => (
                                                    <div key={aIndex} className={`mb-2 ${question.submitted_answers.some(sa => sa.answer_id === answer.id) ? (answer.is_correct ? 'text-green-500' : 'text-red-500') : 'text-gray-300'}`}>
                                                        <strong>Answer:</strong> {answer.answer}
                                                        {question.submitted_answers.some(sa => sa.answer_id === answer.id) && (
                                                            <span className="ml-2">
                                                                {answer.is_correct ? '✔' : '✖'}
                                                            </span>
                                                        )}
                                                    </div>
                                                ))}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    ))}
                    <div className="mt-6 text-center">
                        <p><strong>Total Score:</strong> {attempt.total_score} / {attempt.max_score}</p>
                        <p><strong>Time Taken:</strong> {formatTime(attempt.time)}</p>
                        <p><strong>Status:</strong> {attempt.passed ? 'Passed' : 'Failed'}</p>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
};

export default TaskAttempt;
