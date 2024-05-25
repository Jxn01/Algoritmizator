import {basicSetup, EditorView} from "codemirror";
import {EditorState} from "@codemirror/state";
import {oneDarkModified} from "@/CodeMirrorTheme.ts";
import {python} from "@codemirror/lang-python";
import {javascript} from "@codemirror/lang-javascript";
import {java} from "@codemirror/lang-java";
import {cpp} from "@codemirror/lang-cpp";

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

function injectCodeEditors() {
    const languageExtensions = {
        'python': python(),
        'javascript': javascript(),
        'java': java(),
        'cpp': cpp()
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
}

export default injectCodeEditors;
