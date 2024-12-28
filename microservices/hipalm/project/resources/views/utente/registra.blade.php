<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registra Utente</title>
    <!-- <link href="/stile.css" rel="stylesheet" type="text/css"> -->
    <!--<script src="../../resources/js/miojavascript.js" type="text/javascript" ></script> -->
    @vite(['resources/css/stile.css', 'resources/js/miojs.js']);
</head>

<body>
    <div class="form">
        <form>
            <div class="item"
                <label>UserID</label>
                <input type="text" />
            </div>
            <div class="item">
                <label>nome</label>
                <input type="text" />
            </div>
            <div class="item">
                <label>cognome</label>
                <input type="text" />
            </div>
            <div class="item">
                <label>email</label>
                <input type="email" />
            </div>
            <div class="item">
                <label>password</label>
                <input type="password" />
            </div>
        </form>
    </div>
</body>

</html>