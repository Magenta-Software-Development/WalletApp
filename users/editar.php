<?php
session_start();
if (!isset($_SESSION['rol'])) //Si entra sin un rol, lo manda a login.php
{
    header('Location: login.php');
} elseif ($_SESSION['rol'] == "admin") //Si el rol no es admin
{
    header('Location: index.php'); //Lo envia para login.php, podemos hacer otro php para los users comunes
}

$error=NULL;
if (!empty($_GET) && isset($_GET['status'])&& $_GET['status'] == "error") {
    $error = '<div class = "alert alert-danger">Usuario o email repetido </div>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/usuario.css">
</head>

<body>

    <div class="header">
        <div class="row">
            <div class="col-1 inicio">
                <!--Home-->
                <a href="../usuario.php"><i class="fas fa-home"></i></a>
            </div>

            <div class="col-6 bienvenida">

                <h4 style="color:white" name="autor"><?= "Bienvenido " . $_SESSION['user']; ?></h4>
            </div>
            <div class="col-4 botones">

            </div>
            <div class="col-1">
                <div class="dropdown">
                    <button class="btn botonp dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="editar.php">Perfil</a></li>
                        <li><a class="dropdown-item" href="singin.php?logout">Cerrar Sesion</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="cuerpo">

        <form action="guardarCambios.php" method="POST" onsubmit="return checkPassword()">
            <input type="text" name="userid" readonly style="opacity:0" value="<?= $_SESSION['id'] ?>">
            <div class="mb-3">
                <label for="User" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $_SESSION['nombre'] ?>"required>
            </div>
            <div class="mb-3">
                <label for="User" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $_SESSION['apellido'] ?>"required>
            </div>
            <div class="mb-3">
                <label for="User" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="user" name="usuario" value="<?= $_SESSION['user'] ?>"required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="correo" type="email" class="form-control" id="email" value="<?= $_SESSION['email'] ?>"required >
                <div id="emailHelp" class="form-text">Tu correo estara bien resguardado con nosotros!</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input name="pass" type="password" class="form-control" id="pass" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
        <br>
        <?= $error ?>
    </div>

    <script>
        function checkPassword(pass) {  // verificar que la contraseña sea mayor a 8 caracteres

            var password = document.getElementById("pass").value;

            if (password.length < "8") {

                document.getElementById("pass").style.border = "1px solid red";
                alert("La contraseña debe ser de al menos 8 caracteres como minimo");
                document.getElementById("pass").value = "";
                return false
            } else if (password.indexOf(" ") > -1) {
                document.getElementById("pass").style.border = "1px solid red";
                alert("La contraseña no puede contener espacios");
                document.getElementById("pass").value = "";
                return false;
            } else if (!password.includes("+") && !password.includes("*") && !password.includes(".")) {
                document.getElementById("pass").style.border = "1px solid red";
                alert("La contraseña debe incluir +,* o .")
                document.getElementById("pass").value = "";
                return false
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/2aad3a5418.js" crossorigin="anonymous" async></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>