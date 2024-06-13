<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tạo nội dung với TinyMCE</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .container {
      display: flex;
      flex-direction: row;
    }
    .card {
      width: 200px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f4f4f4;
      margin-right: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .draggable-container {
      display: flex;
      flex-direction: column;
    }
    .draggable-button {
      cursor: move;
      padding: 10px;
      margin: 5px 0;
      border: none;
      border-radius: 4px;
      background-color: #007bff;
      color: white;
      text-align: left;
      font-size: 14px;
    }
    .tinymce-editor-container {
      flex-grow: 1;
      padding: 20px;
    }
    .tinymce-editor {
      width: 100%;
      height: 800px;
    }
    .options {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <button id="exportButton" class="draggable-button" style="background-color: green;" onclick="exportContent()">Export Content</button>
      <button id="convertButton" class="draggable-button" style="background-color: orange;" onclick="convertToTailwind()">Convert to Tailwind</button>
      
      <div class="draggable-container">
        <button class="draggable-button" draggable="true" data-item="$name">Name: $name</button>
        <button class="draggable-button" draggable="true" data-item="$id">ID: $id</button>
        <button class="draggable-button" draggable="true" data-item="$phone_number">Phone Number: $phone_number</button>
        <button class="draggable-button" draggable="true" data-item="$gmail">Gmail: $gmail</button>
      </div>
    </div>
    <div class="tinymce-editor-container">
      <textarea id="mytextarea" class="tinymce-editor"></textarea>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      initTinyMCE('A4');

      var draggables = document.querySelectorAll('.draggable-button');
      
      draggables.forEach(function(draggable) {
        draggable.addEventListener('dragstart', function (e) {
          e.dataTransfer.setData('text/plain', e.target.dataset.item);
        });
      });

      document.querySelector('.tinymce-editor-container').addEventListener('dragover', function (e) {
        e.preventDefault();
      });

      document.querySelector('.tinymce-editor-container').addEventListener('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var dropContent = e.dataTransfer.getData('text/plain');
        tinymce.activeEditor.execCommand('mceInsertContent', false, dropContent);
      });
    });

    function initTinyMCE(paperSize) {
      tinymce.init({
        selector: '#mytextarea',
        license_key: 'gpl',
        plugins: 'print preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist checklist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl | papersize',
        menubar: 'file edit view insert format tools table help',
        toolbar_sticky: true,
        height: 800,
        content_css: 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
        content_style: `
          @page {
            size: ${paperSize};
            margin: 20mm;
          }
          body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
          }
          .mce-content-body {
            @apply p-8 bg-white shadow rounded-lg;
          }
        `,
        setup: function (editor) {
          editor.on('init', function () {
            editor.getContainer().style.width = paperSize === 'A4' ? '210mm' : '297mm';
            editor.getContainer().style.height = paperSize === 'A4' ? '297mm' : '420mm';
          });

          editor.ui.registry.addMenuButton('papersize', {
            text: 'Paper Size',
            fetch: function (callback) {
              var items = [
                {
                  type: 'menuitem',
                  text: 'A4',
                  onAction: function () {
                    changePaperSize('A4');
                  }
                },
                {
                  type: 'menuitem',
                  text: 'A3',
                  onAction: function () {
                    changePaperSize('A3');
                  }
                }
              ];
              callback(items);
            }
          });
        }
      });
    }

    function changePaperSize(size) {
      tinymce.remove();
      initTinyMCE(size);
    }

    function exportContent() {
      const content = tinymce.activeEditor.getContent();
      const blob = new Blob([content], { type: 'text/html' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'content.html';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }

 function convertToTailwind() {
            const editor = tinymce.activeEditor;

            if (!editor) {
                console.error('TinyMCE editor is not initialized or not found.');
                return;
            }

            let content = editor.getContent();
            console.log('Editor Content:', content);

            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenMeta) {
                console.error('CSRF token meta tag not found.');
                return;
            }

            const csrfToken = csrfTokenMeta.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token is missing in the meta tag.');
                return;
            }

            console.log('CSRF Token:', csrfToken);

            fetch('http://127.0.0.1:8000/convert-to-tailwind', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ content: content })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
  </script>
</body>
</html>
