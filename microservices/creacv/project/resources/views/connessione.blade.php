<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        #full {
            margin: auto;
            padding: 40px;
            background: #0f0;
            height: 100%;
            vertical-align: middle;
        }

        th,
        td {
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px 10px;
            margin: 7px 7px;
            font-size: 26px;
        }
        th {
            font-weight:bold;
            background-color: darkgreen;
            color:limegreen;
        }
        td:first-child, th:first-child {
            width:200px;
        }
        td:nth-child(2), th>td {
            width:250px;
            background-color: white;
        }
    </style>
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