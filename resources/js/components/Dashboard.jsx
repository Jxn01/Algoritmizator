import React, {memo, useEffect, useRef, useState} from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import {basicSetup, EditorView} from "codemirror";
import {EditorState} from "@codemirror/state";
import {oneDarkModified} from "@/CodeMirrorTheme.ts";
import {python} from "@codemirror/lang-python";
import {javascript} from "@codemirror/lang-javascript";
import {java} from "@codemirror/lang-java";
import {cpp} from "@codemirror/lang-cpp";
import ReactMarkdown from "react-markdown";

/**
 * Dashboard component
 */
const Dashboard = memo(({ title, activeTab}) => {
    const [friends, setFriends] = useState([]);
    const [successfulAttempts, setSuccessfulAttempts] = useState([]);
    const [algorithm, setAlgorithm] = useState({});
    const isFirstRun = useRef(true);
    const languageExtensions = {
        'python': python(),
        'javascript': javascript(),
        'java': java(),
        'cpp': cpp()
    }

    useEffect(() => {
        axios.get(`/algoritmizator/api/socials/online-friends`)
            .then(response => {
                setFriends(response.data);
            })
            .catch(error => {
                console.error('Error fetching friends:', error);
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
                        console.error('Error fetching completed assignments:', error);
                        setSuccessfulAttempts([]);
                    });
            })
            .catch(e => {
                console.log(e);
            });

        axios.get('/algoritmizator/api/algorithm-of-the-hour')
            .then(response => {
                setAlgorithm(response.data);
            })
            .catch(error => {
                console.error('Error fetching algorithm of the hour:', error);
                setAlgorithm({});
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
    }, [algorithm]);

    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex items-stretch min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-5">
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col" style={{maxHeight: 'calc(80vh)'}}>
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
                            <h1 className="text-2xl font-bold text-center text-white mb-4">Az óra algoritmusa</h1>
                            <hr className="border-2 border-purple-700 mb-4"/>
                            <div className="markdown">
                                <h1 className="text-xl font-bold text-center text-white mb-2">{algorithm.title}</h1>
                                <div className="markdown">
                                    {algorithm ? <ReactMarkdown
                                        children={algorithm.markdown}/> : 'Nincs megjeleníthető tartalom. :('}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="w-1/4 p-4 bg-gray-800 text-white rounded-xl shadow-lg m-2 flex flex-col" style={{maxHeight: 'calc(80vh)'}}>
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
