<?php
?>
<html>

    <head>
        <title>Sportello1</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link rel="stylesheet" href="{{ asset('resources/css/sportello.css') }}">
        <script>
            var data = {};
        </script>
    </head>

    <body>
        <div class="tabellone">
            <h1>Prenotazione</h1>
            <div class="sportello">
                <h1 id="valore"></h1>
            </div>
            <button id="incrementa">INCREMENTA</button>
            <button id="azzera">AZZERA</button>
        </div>
    </body>

</html>