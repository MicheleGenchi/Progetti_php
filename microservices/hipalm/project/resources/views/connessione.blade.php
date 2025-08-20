<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>

<body>
    <h3>Test connessione al database</h3>
    <hr>
    <div>
        <?php
            use GuzzleHttp\Client;
            use GuzzleHttp\Psr7\Request;
            use GuzzleHttp\Exception\RequestException;
            try {
                $client = new Client();
                $response = $client->get('http://localhost:8000/testconnessione');
                echo $response->getBody();
            } catch (RequestException $e) {
                echo $e->getMessage() . "\n";
                var_dump($e->getRequest());
                if ($e->hasResponse()) {
                    var_dump($e->getResponse());
                }
            }
        ?>
    </div>
</body>

</html>