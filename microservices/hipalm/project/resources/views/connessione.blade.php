<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>
<body>
    <?php 
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://localhost:8000/testconnessione');
        echo $response->getStatusCode();
        echo $response->getBody();
    ?>
</body>
</html>