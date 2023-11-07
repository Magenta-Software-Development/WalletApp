<?php
$errorLogin = NULL;
if (!empty($_GET) && isset($_GET['status']) && $_GET['status'] == "error") {
    $errorLogin = '<div class = "alert alert-danger">Usuario o contraseña incorrecta </div>';
} else if (!empty($_GET) && isset($_GET['status']) && $_GET['status'] == "repetido") {
    $errorLogin = '<div class = "alert alert-danger">Usuario o correo no disponible </div>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>
<br>
<br>

<body class="cuerpo">
    <div class="contenedor">
        <div class="title-text">
            <div class="title login">
                Iniciar sesion
            </div>
            <div class="title signup">
                Registrarse
            </div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Iniciar sesion</label>
                <label for="signup" class="slide signup">Registrarse</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form action="users/singin.php" method="post" class="login">
                    <div class="field">
                        <input type="text" name="user" placeholder="Usuario" required>
                    </div>
                    <div class="field">
                        <input type="password" name="pass" placeholder="Contraseña" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Iniciar sesion">
                    </div>
                    <div class="signup-link">
                        ¿No esta registrado? <a href="">Registrese ahora</a>
                    </div>
                    <br><br>
                    <?= $errorLogin; ?>
                </form>

                <form action="users/registro.php" method="POST" class="signup" onsubmit="return checkPassword()">
                    <div class="field">
                        <input type="text" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="field">
                        <input type="text" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Correo" required>
                    </div>
                    <div class="field">
                        <input type="text" name="user" placeholder="Usuario" required>
                    </div>
                    <div class="field">
                        <input type="password" id="pass2" name="pass" placeholder="Contraseña" required>
                    </div>
                    <div id="rol" name="rol" contenteditable="false" style="display: none;">
                       usuario
                    </div>

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Registrase">
                        <input class="form-check-input rol" type="checkbox" name="rol" value="usuario" id="flexCheckDefault" style="visibility:hidden" checked>
                    </div>
                    <br><br>
                </form>

            </div>
        </div>
    </div>



<script src="js/scripts.js"></script> 


</body>

</html>