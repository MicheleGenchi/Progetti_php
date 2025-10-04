<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scelta Xml</title>
    <link rel="stylesheet" href="/css/mystyles.css" />
</head>

<body>
    <div id="full">
        <h1 style="text-align:center;">Scelta xml file</h1>
        <form action="uploadXml" id="formid" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
            <div class="line">
                <label for="file">Xml : </label>
                <input type="file" accept=".xml" name="file" id="file">
            </div>
            <input type="submit" name="upload" value="Carica file">
        </form>
    </div>
</body>

</html>