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
export const Lessons = memo(({ title, activeTab, user }) => {
    const [lessons, setLessons] = useState([]);
    const [selectedLesson, setSelectedLesson] = useState([]);
    const [selectedSublesson, setSelectedSublesson] = useState([]);
    const [codeBlocks, setCodeBlocks] = useState([]);

    const codeByLanguage = {
        'python': '',
        'javascript': '',
        'java': '',
        'cpp': ''
    };

    useEffect(() => {
        axios.get('/algoritmizator/api/lessons')
            .then(response => {
                setLessons(response.data);
                setSelectedLesson(response.data[0]);
                setSelectedSublesson(response.data[0].sublessons[0]);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    useEffect(() => {
        const blocks = Array.from(document.querySelectorAll('pre code')).map(codeElement => {
            const languageClass = codeElement.className.match(/language-(\w+)/);
            const language = languageClass ? languageClass[1] : 'plaintext';
            return {
                code: codeElement.textContent,
                language: language
            };
        });

        setCodeBlocks(blocks);

    }, [selectedSublesson]);

    const CodeEditorTabs = ({ codeBlocks }) => {
        const editorsRef = useRef({});
        const tabPanelRefs = useRef({}); // Create a ref for each TabPanel
        const [activeTab, setActiveTab] = useState('python'); // State for active tab
        const languageExtensions = {
            'python': python(),
            'javascript': javascript(),
            'java': java(),
            'cpp': cpp()
        }

        useEffect(() => {
            // Process each code block and assign it to the correct language
            codeBlocks.forEach(block => {
                const language = block.language;
                if (codeByLanguage.hasOwnProperty(language)) {
                    codeByLanguage[language] += block.code + '\n'; // Concatenate code if multiple blocks
                }
            });

            // Setup editors for each language
            Object.keys(codeByLanguage).forEach(language => {
                const container = document.createElement('div');

                const editor = new EditorView({
                    state: EditorState.create({
                        doc: codeByLanguage[language],
                        extensions: [basicSetup, oneDarkModified, languageExtensions[language] || []],
                    }),
                    parent: container
                });

                // Append the editor to the corresponding TabPanel
                if (tabPanelRefs.current[language]) {
                    tabPanelRefs.current[language].appendChild(container);
                }

                // Store reference for cleanup
                editorsRef.current[language] = editor;
            });

            return () => {
                // Cleanup editors on component unmount
                Object.values(editorsRef.current).forEach(editor => {
                    editor.destroy();
                });
            };
        }, [selectedSublesson]); // Effect runs on initial mount and when codeBlocks changes

        return (
            <div>
                <div className="flex space-x-2 pb-4 rounded-lg font-mono">
                    <button onClick={() => setActiveTab('python')}
                            className={`px-4 py-2 text-white rounded-lg ${activeTab === 'python' ? 'bg-gray-700' : 'bg-gray-900'}`}>Python
                    </button>
                    <button onClick={() => setActiveTab('javascript')}
                            className={`px-4 py-2 text-white rounded-lg ${activeTab === 'javascript' ? 'bg-gray-700' : 'bg-gray-900'}`}>JavaScript
                    </button>
                    <button onClick={() => setActiveTab('java')}
                            className={`px-4 py-2 text-white rounded-lg ${activeTab === 'java' ? 'bg-gray-700' : 'bg-gray-900'}`}>Java
                    </button>
                    <button onClick={() => setActiveTab('cpp')}
                            className={`px-4 py-2 text-white rounded-lg ${activeTab === 'cpp' ? 'bg-gray-700' : 'bg-gray-900'}`}>C++
                    </button>
                </div>
                {Object.keys(codeByLanguage).map((language, index) => (
                    <div key={index} ref={el => tabPanelRefs.current[language] = el}
                         style={{display: activeTab === language ? 'block' : 'none', borderRadius: '20px', padding: '20px', backgroundColor: '#111827'}}></div>
                ))}
            </div>
        );
    };

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
                                                 selectedSublesson === sublesson ? "text-purple-500 font-bold" : "text-white"
                                             }`}>
                                            {sublesson.title}
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
                            <div>
                                {selectedSublesson && codeBlocks.length > 0 && <CodeEditorTabs codeBlocks={codeBlocks} />}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Lessons;
