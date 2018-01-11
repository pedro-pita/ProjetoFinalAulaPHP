<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/style_1.css">

        <title>Home</title>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    </head>
    <body>
        <!--Formulário de Login -->
        <form action = "validacao_1.php" method = "post">
            <fieldset>
                <legend>Dados de Login</legend>
                <label for = "txUser">User</label>
                <input type = "text" name = "user" id = "txUser" maxlength = "25" />
                <label for = "txPassword">Password</label>
                <input type = "password" name = "password" id = "txPassword" />
                <input type = "submit" value = "Entrar" />
            </fieldset>
        </form>
    </body>
</html>
