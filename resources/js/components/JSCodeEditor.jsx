import React, {memo, useEffect, useRef} from 'react';
import { EditorState } from '@codemirror/state';
import { EditorView, keymap } from '@codemirror/view';
import { defaultKeymap } from '@codemirror/commands';
import { javascript } from '@codemirror/lang-javascript';
import { oneDark } from '@codemirror/theme-one-dark';
import { lineNumbers } from '@codemirror/view';

/**
 * JSCodeEditor component
 *
 * This is a functional component that renders a JavaScript code editor using the CodeMirror library.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useRef hook to manage references to the editor and the editor container DOM elements.
 * It uses React's useEffect hook to set up the editor when the component is mounted and clean up when it is unmounted.
 *
 * @returns {JSX.Element} The JSCodeEditor component
 */
const JSCodeEditor = memo(() => {
    // References to the editor and the editor container DOM elements
    const editor = useRef(null);
    const editorContainer = useRef(null);

    // Example JavaScript code
    const initialDoc = `function add(a, b) {
        return a + b;
    }

    console.log(add(2, 3));`;

    // Effect hook to set up the editor when the component is mounted and clean up when it is unmounted
    useEffect(() => {
        if (!editor.current && editorContainer.current) {
            // Create the initial state of the editor
            const startState = EditorState.create({
                doc: initialDoc,
                extensions: [
                    keymap.of(defaultKeymap),
                    javascript(),
                    oneDark,
                    lineNumbers(),
                    EditorView.lineWrapping,
                    EditorView.updateListener.of(update => {
                        if (update.changes) {
                            console.log("Document updated", update.state.doc.toString());
                        }
                    })
                ]
            });

            // Create the editor view
            editor.current = new EditorView({
                state: startState,
                parent: editorContainer.current
            });
        }

        // Clean up function to destroy the editor when the component is unmounted
        return () => {
            if (editor.current) {
                editor.current.destroy();
                editor.current = null;
            }
        };
    }, []); // Dependency array is empty to ensure setup only runs once

    // Render the editor container
    return <div ref={editorContainer} className="editor-container" />;
});

export default JSCodeEditor;
