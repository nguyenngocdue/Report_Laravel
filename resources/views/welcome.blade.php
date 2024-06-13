<!DOCTYPE html>
<html>
<head>
    <title>Laravel Trumbowyg Example</title>
    <!-- Include Trumbowyg CSS -->
    <link rel="stylesheet" href="{{ asset('/css/trumbowyg.min.css') }}">
</head>
<body>
    <!-- Textarea to be transformed into a WYSIWYG editor -->
    <textarea id="editor"></textarea>

    <!-- Include jQuery and Trumbowyg JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/trumbowyg.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Trumbowyg on the textarea
            $('#editor').trumbowyg();
        });
    </script>
</body>

</html>
