<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/mystyles.css" />
    <title>Connessione</title>
</head>

    <body>
        <div id="full">
            <h1>Prova connessione</h1>
            <?php
                use App\Http\Controllers\Controller;
                use Illuminate\Http\Request;
                echo "<table>";
                echo "<tr><th>RIFERIMENTO</th><th>VALORE</th></tr>";
                echo "<tr><td>driver</td><td>mysql</td></tr>";
                echo "<tr><td>DB_HOST</td><td>db-cv</td></tr>";
                echo "<tr><td>DB_PORT</td><td>3306</td></tr>";
                echo "<tr><td>DB_DATABASE</td><td>datacv</td></tr>";
                echo "<tr><td>DB_USERNAME</td><td>cv</td></tr>";
                echo "<tr><td>DB_PASSWORD</td><td>root</td></tr>";
                echo "</table>";
                $myHeaders = getAllHeaders();
                $connessione = new Controller();
                $dataTest = new Request();
                $dataConnection = $connessione->testconnessione($dataTest);
                echo "<table>";
                echo "<tr><th>STATUS</th><td>".$dataConnection->statusText()."</td></tr>";
                $data=json_decode($dataConnection->content(), true);
                echo "<tr><th>RESPONSE</th><td>".$data['response']."</td></tr>";
                echo "</table>";
            ?>
        </div>
    </body>
</html>