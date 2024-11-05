<?php
?>
<html>

    <head>
        <title>Tabellone</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link rel="stylesheet" href="{{ asset('resources/css/tabellone.css') }}">
    </head>

    <body>
        <div class="tabellone">
            <div class='sportello'>
                <h1> Numero Prenotazione</h1>
                <h1 class="value">
                    <script>
                        document.write(sportello1);
                    </script>
                </h1>
            </div>
        </div>
        <script>
            setTimeout(function() {
                window.location.replace(location.href);
            }, 2000);
        </script>
    </body>

</html>