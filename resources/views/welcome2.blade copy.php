<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quill Editor with Table Support</title>
    <!-- Include Quill styles -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- Include quill-table styles and library -->
    <link href="https://cdn.jsdelivr.net/npm/quill-table-ui@1.0.5/dist/index.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill-table-ui@1.0.5/dist/index.js"></script>
    <style>
        .ql-editor {
            height: 210mm; /* Height for A4 size */
            max-height: 297mm; /* Width for A4 size */
            margin: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 20mm;
            background: white;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <h1>Quill Editor with Table Support</h1>
    <!-- Create the editor container -->
    <div id="editor-container"></div>
    <!-- Initialize Quill editor -->
    <script>
        // Register table module
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'super' }, { 'script': 'sub' }],
                    [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }, { 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean'], // remove formatting button
                    ['table'],
                    [{ 'table': 'insertTable' }, { 'table': 'insertColumnRight' }, { 'table': 'insertColumnLeft' }],
                    [{ 'table': 'insertRowAbove' }, { 'table': 'insertRowBelow' }],
                    [{ 'table': 'deleteColumn' }, { 'table': 'deleteRow' }, { 'table': 'deleteTable' }]
                ],
                table: true
            }
        });
    </script>
</body>
</html>
