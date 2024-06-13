<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo nội dung với TinyMCE</title>
    <!-- Include TinyMCE from jsDelivr CDN -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
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
    <script>
      function initTinyMCE(paperSize) {
        tinymce.init({
          selector: '#mytextarea',
          plugins: 'print preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons draggable',
          toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist checklist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl | papersize',
          menubar: 'file edit view insert format tools table help',
          toolbar_sticky: true,
          height: 800,
          content_style: `
            @page {
              size: ${paperSize};
              margin: 20mm;
            }
            body {
              font-family:Helvetica,Arial,sans-serif;
              font-size:16px;
              margin: 0;
              padding: 20mm;
              width: ${paperSize === 'A4' ? '170mm' : '297mm'}; /* Adjusted for padding */
              height: ${paperSize === 'A4' ? '257mm' : '420mm'}; /* Adjusted for padding */
              box-sizing: border-box;
              overflow: hidden;
            }
            .mce-content-body {
              height: 100%;
            }
          `,
          setup: function (editor) {
            editor.on('init', function () {
              editor.getContainer().style.width = paperSize === 'A4' ? '210mm' : '297mm';
              editor.getContainer().style.height = paperSize === 'A4' ? '297mm' : '420mm';
              editor.getBody().style.padding = '20mm';
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

      document.addEventListener('DOMContentLoaded', function () {
        initTinyMCE('A4');

        var draggables = document.querySelectorAll('.draggable-button');
        
        draggables.forEach(function(draggable) {
          draggable.addEventListener('dragstart', function (e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.item);
          });
        });

        var editorBody = document.querySelector('.mce-content-body');

        editorBody.addEventListener('dragover', function (e) {
          e.preventDefault();
        });

        editorBody.addEventListener('drop', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var dropContent = e.dataTransfer.getData('text/plain');
          tinymce.activeEditor.execCommand('mceInsertContent', false, dropContent);
        });
      });
    </script>
</head>