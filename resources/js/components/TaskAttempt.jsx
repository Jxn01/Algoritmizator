import React, {useEffect, useRef, useState} from 'react';
import axios from 'axios';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import ReactMarkdown from 'react-markdown';
import {python} from "@codemirror/lang-python";
import {javascript} from "@codemirror/lang-javascript";
import {java} from "@codemirror/lang-java";
import {cpp} from "@codemirror/lang-cpp";
import {basicSetup, EditorView} from "codemirror";
import {EditorState} from "@codemirror/state";
import { oneDarkModified } from "../CodeMirrorTheme.ts";

const TaskAttempt = ({ id, title, activeTab }) => {
    const [attempt, setAttempt] = useState(null);
    const [loading, setLoading] = useState(true);
    const isFirstRun = useRef(true);
    const languageExtensions = {
        'python': python(),
        'javascript': javascript(),
        'java': java(),
        'cpp': cpp()
    }

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

    function resetEditors(){
        const editorContainers = document.querySelectorAll('.editor');
        editorContainers.forEach(editor => {
            editor.remove();
        });
    }

    function resetButtons(){
        const buttons = document.querySelectorAll('.buttonDiv');
        buttons.forEach(button => {
            button.remove();
        });
    }

    function groupCodeBlocks(){
        const codeElements = Array.from(document.querySelectorAll('pre code'));
        const groupedBlocks = [];
        let group = [];
        let placeholder = null;

        codeElements.forEach((codeElement, index) => {
            const languageClass = codeElement.className.match(/language-(\w+)/);
            const language = languageClass ? languageClass[1] : 'plaintext';
            const segment = {
                code: codeElement.textContent,
                language: language
            };

            if (group.length === 0) {
                placeholder = document.createElement('div');
                placeholder.className = 'editor';
                codeElement.parentNode.parentNode.insertBefore(placeholder, codeElement.parentNode);
            }

            group.push(segment);

            if (!codeElement.parentNode.nextElementSibling || !codeElements[index + 1] || codeElement.parentNode.nextElementSibling !== codeElements[index + 1].parentNode) {
                groupedBlocks.push({ location: placeholder, segments: group });
                group = [];
                placeholder = null;
            }
        });

        return groupedBlocks;
    }

    useEffect(() => {
        if (isFirstRun.current) {
            isFirstRun.current = false;
            return;
        }

        resetEditors();
        resetButtons();

        groupCodeBlocks().forEach((block, blockIndex) => {
            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'flex space-x-2 pb-4 rounded-lg font-mono buttonDiv';
            block.location.parentNode.insertBefore(buttonDiv, block.location);

            block.segments.forEach((segment, segmentIndex) => {
                const language = segment.language;
                const code = segment.code;

                const button = document.createElement('button');
                buttonDiv.appendChild(button);
                button.setAttribute('id', `editor-button-${blockIndex}-${segmentIndex}`);
                button.textContent = language;

                if(segmentIndex === 0) {
                    button.className = `px-4 py-2 text-white rounded-lg bg-gray-700`;
                } else {
                    button.className = `px-4 py-2 text-white rounded-lg bg-gray-900`;
                }

                button.addEventListener('click', () => {
                    if(!button.classList.contains('bg-gray-700')) {
                        document.querySelectorAll('.buttonDiv button').forEach((button) => {
                            if(button.id.includes(`editor-button-${blockIndex}`)) {
                                button.classList.remove('bg-gray-700');
                                button.classList.add('bg-gray-900');
                            }
                        });

                        button.classList.remove('bg-gray-900');
                        button.classList.add('bg-gray-700');

                        document.querySelectorAll('.editor-container').forEach((editor) => {
                            if(editor.id === `editor-container-${blockIndex}-${segmentIndex}`) {
                                editor.style.display = 'block';
                            } else if(editor.id.includes(`editor-container-${blockIndex}`)) {
                                editor.style.display = 'none';
                            }
                        });
                    }
                });

                const container = document.createElement('div');
                container.setAttribute('id', `editor-container-${blockIndex}-${segmentIndex}`);
                container.className = 'editor-container';
                container.style.borderRadius = '20px';
                container.style.padding = '20px';
                container.style.backgroundColor = '#111827';

                if(segmentIndex !== 0){
                    container.style.display = 'none';
                }

                new EditorView({
                    state: EditorState.create({
                        doc: code,
                        extensions: [basicSetup, oneDarkModified, languageExtensions[language] || []],
                    }),
                    parent: container
                });

                block.location.appendChild(container);
            });
        });
    }, [loading]);

    if (loading) {
        return <div>Betöltés...</div>;
    }

    if (!attempt) {
        return <div>Betöltés sikertelen.</div>;
    }

    const formatTime = (timeString) => {
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
                                                            {!isSubmitted && task.type === 'checkbox' && isCorrect && (
                                                                <span className="ml-2">✖</span>
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
                        <button className="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800" onClick={() => window.location.href = '/algoritmizator/app/lessons'}>
                            Vissza a leckékhez
                        </button>
                        <div>
                            <p><strong>Pontszám:</strong> {attempt.total_score} / {attempt.max_score}</p>
                            <p><strong>Eltelt idő:</strong> {formatTime(attempt.time)}</p>
                            <p><strong>Státusz:</strong> {attempt.passed ? 'Sikeres' : 'Sikertelen'}</p>
                        </div>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
};

export default TaskAttempt;
