<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .text-red {
      color: red;
    }
    .font-large {
      font-size: 2em;
    }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function generateTailwind() {
      let inputHtml = document.getElementById('htmlInput').value;

      $.ajax({
        url: '/convert-to-tailwind',
        method: "POST",
        contentType: 'application/json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
          html: inputHtml
        }),
        success: function(response) {
          document.getElementById('tailwindOutput').innerText = response.convertedHtml;
        },
        error: function(error) {
          console.error('Error:', error);
        }
      });
    }
  </script>
</head>
<body>
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold underline bg-red-600 mb-4">
      Hello world!
    </h1>
    <textarea id="htmlInput" class="w-full h-40 p-2 border" placeholder="Nhập HTML/CSS thuần vào đây..."></textarea>
    <button onclick="generateTailwind()" class="mt-2 p-2 bg-blue-500 text-white">Generate Tailwind</button>
    <h2 class="mt-4 text-xl font-semibold">Mã Tailwind CSS:</h2>
    <pre id="tailwindOutput" class="w-full h-40 p-2 border bg-gray-100"></pre>
  </div>
</body>
</html>
