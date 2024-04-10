import './bootstrap';
import CodeMirror from 'codemirror';


// Initialize CodeMirror
const myCodeMirror = CodeMirror(document.body, {
    value: "function myScript(){return 100;}\n",
    mode:  "javascript",
    lineNumbers: true
});
