<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scelta template</title>
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
        <h1 style="text-align:center;">Scelta docx template</h1>
        <form action="upload" id="formid" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
            <div class="line"> 
                <label for="file">Documento : </label>
                <input type="file" accept=".docx, .doc" name="file" id="file">
            </div>
            <input type="submit" name="upload" value="Carica file">
        </form>
    </div>
</body>

</html>