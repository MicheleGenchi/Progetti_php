<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compila Dcoumento</title>
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
        <h1 style="text-align:center;">Compila Documento</h1>
        <h4 style="text-align:center;">Seleziona un template e seleziona un file xml con i dati compilativi</h4>
        <form action="compilaDocumento" id="formid" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
            <div class="line">
                <label for="filedoc">Documento : </label>
                <input type="file" accept=".docx, .doc" name="filedoc" id="filedoc">
            </div>
            <div class="line">
                <label for="filexml">Xml : </label>
                <input type="file" accept=".xml" name="filexml" id="filexml">
            </div>
            <input type="submit" name="upload" value="Carica file">
        </form>
    </div>
</body>

</html>