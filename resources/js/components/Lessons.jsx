import React, {memo, useEffect, useState, useRef} from 'react';
import ReactMarkdown from 'react-markdown';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import { EditorView, basicSetup} from 'codemirror';
import { EditorState } from '@codemirror/state';
import { oneDarkModified } from "../CodeMirrorTheme.ts";
import { python } from '@codemirror/lang-python';
import { javascript } from '@codemirror/lang-javascript';
import { java } from '@codemirror/lang-java';
import { cpp } from '@codemirror/lang-cpp';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faFileAlt, faCheck} from "@fortawesome/free-solid-svg-icons";

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
export const Lessons = memo(({title, activeTab}) => {
    const [lessons, setLessons] = useState([]);
    const [selectedLesson, setSelectedLesson] = useState([]);
    const [selectedSublesson, setSelectedSublesson] = useState([]);
    const [successfulAttempts, setSuccessfulAttempts] = useState([]);
    const isFirstRun = useRef(true);
    const languageExtensions = {
        'python': python(),
        'javascript': javascript(),
        'java': java(),
        'cpp': cpp()
    }

    useEffect(() => {
        axios.get('/algoritmizator/api/lessons')
            .then(response => {
                setLessons(response.data);
                setSelectedLesson(response.data[0]);
                setSelectedSublesson(response.data[0].sublessons[0]);
            })
            .catch(error => {
                alert('Failed to fetch lessons.')
            });

        axios.get('/algoritmizator/api/user')
            .then(r => {
                const id = r.data.id;
                axios.get(`/algoritmizator/api/task/attempts/successful/user/${id}`)
                    .then(response => {
                        setSuccessfulAttempts(response.data);
                    })
                    .catch(error => {
                        console.error('Error fetching completed assignments:', error);
                        setSuccessfulAttempts([]);
                    });
            })
            .catch(e => {
                console.log(e);
            });
    }, []);

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
    }, [selectedSublesson]);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex">
                <div className="w-64 min-h-screen bg-gray-800 text-white p-5">
                    <h2 className="text-xl font-bold mb-3">Leckék</h2>
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
                <div className="flex-grow bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-20 pt-10">
                    <div className="bg-gray-800 p-5 rounded-lg text-white">
                        <h1 className="text-3xl font-bold ml-7 mb-2">{selectedLesson ? selectedLesson.title : "Select a Lesson"}</h1>
                        <h2 className="text-2xl ml-7">{selectedSublesson ? selectedSublesson.title : 'Select a Sublesson'}</h2>
                        <hr className="border-purple-800 border-2 mt-4"/>
                        <div className="markdown">
                            {selectedSublesson ? <ReactMarkdown children={selectedSublesson.markdown} /> : 'Please select a sublesson to view the content.'}
                        </div>
                        {selectedSublesson && selectedSublesson.has_quiz ? (
                            <div className="mt-4 text-center items-center">
                                <button className="bg-purple-800 text-white px-4 py-2 rounded-lg" onClick={() => window.location.href = `/algoritmizator/lessons/task/${selectedSublesson.id}`}>Feladat megoldása</button>
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
