<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scelta Xml</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        #full {
            margin: 0px;
            padding: 0px;
            background: #0f0;
            height: 100%;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div id="full">
        <h1 style="text-align:center;">Scelta xml file</h1>
        <form action="uploadXml" id="formid" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
            <input type="file" accept=".xml" name="file" id="file">
            <input type="submit" name="upload" value="Carica file">
        </form>
    </div>
</body>

</html>