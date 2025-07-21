import 'suneditor/dist/css/suneditor.min.css';
import suneditor from 'suneditor';
import plugins from 'suneditor/src/plugins';

import katex from 'katex';
import 'katex/dist/katex.min.css'


// let blogEditor;

// if (document.getElementById('blog-content')) {


//         blogEditor = suneditor.create('blog-content', {
//         minWidth:'100%',
//         minHeight: '100vh',
//         plugins: plugins,
//         katex: katex,
//         buttonList: [
//             ['undo', 'redo'],
//             ['font', 'fontSize', 'formatBlock'],
//             ['blockquote'],
//             ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
//             ['fontColor', 'hiliteColor', 'textStyle'],
//             ['removeFormat'],
//             '/', // Line break
//             ['outdent', 'indent'],
//             ['align', 'horizontalRule', 'list', 'lineHeight'],
//             ['table', 'link', 'image', 'video', 'audio' /** ,'math' */], // You must add the 'katex' library at options to use the 'math' plugin.
//             // ['imageGallery'], // You must add the "imageGalleryUrl".
//             ['fullScreen', 'showBlocks'],
//             ['preview', 'print'],
//             ['save'],
//             ['math'],
//         ]
//     });


// }

let textAreaEditor;
if (document.getElementById('text-area')) {

        textAreaEditor = suneditor.create('text-area', {
        minWidth:'100%',
        minHeight: '30vh',
        plugins: plugins,
        buttonList: [

        ]
    });


}


export default textAreaEditor ;
