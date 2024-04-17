import React, { useEffect, useRef } from 'react';
import { EditorState } from '@codemirror/state';
import { EditorView, keymap } from '@codemirror/view';
import { defaultKeymap } from '@codemirror/commands';
import { javascript } from '@codemirror/lang-javascript';
import { oneDark } from '@codemirror/theme-one-dark';
import { lineNumbers } from '@codemirror/view';

const JSCodeEditorComponent = () => {
    const editor = useRef(null);
    const editorContainer = useRef(null);

    // Example JavaScript code
    const initialDoc = `function add(a, b) {
        return a + b;
    }

    console.log(add(2, 3));`;

    useEffect(() => {
        if (!editor.current && editorContainer.current) {
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

            editor.current = new EditorView({
                state: startState,
                parent: editorContainer.current
            });
        }

        return () => {
            if (editor.current) {
                editor.current.destroy();
                editor.current = null;
            }
        };
    }, []); // Dependency array is empty to ensure setup only runs once

    return <div ref={editorContainer} className="editor-container" />;
};

export default JSCodeEditorComponent;
