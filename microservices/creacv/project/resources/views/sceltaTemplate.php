<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
            vertical-align:middle;
        }
    </style>
</head>

<body>
    <div id="full">
        <h1 style="text-align:center;">Scelta template</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" name="upload" value="Carica file">
        </form>
    </div>
</body>