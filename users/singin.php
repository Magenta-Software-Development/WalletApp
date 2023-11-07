<?php

function inicioSesion()
{
    require_once '../database/conexion.php';
    $con = getCon(); //objeto con la conexion establecida

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM users WHERE user = :user";
    $statement = $con->prepare($query);

    $statement->execute([
        ':user' => $user

    ]);

    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($pass, $resultado['pass'])) {

        $query = "SELECT * FROM  users  WHERE  user = :user";
        $statement = $con->prepare($query);

        $statement->execute([
            ':user' => $user
        ]);

        $loginRow = $statement->fetch(PDO::FETCH_ASSOC);
        if ($loginRow != false) {
            session_start();
            setcookie('session_id', 'asdaseq2342awesdasd', time() + 3600, '/');

            $_SESSION['id'] = $loginRow['id'];
            $_SESSION['nombre'] = $loginRow['nombre'];
            $_SESSION['apellido'] = $loginRow['apellido'];
            $_SESSION['email'] = $loginRow['email'];
            $_SESSION['user'] = $loginRow['user'];
            $_SESSION['rol'] = $loginRow['rol'];

            $statement->closeCursor();
            $con = null;

            header('Location: ../index.php');
         }else {
            $statement->closeCursor();
            $con = null;
            header('Location: ../login.php?status=error');
        }
    } else {
        $statement->closeCursor();
        $con = null;
        header('Location: ../login.php?status=error');
    }
}

function logout()
{
    session_start();
    session_destroy();
    header('Location: ../login.php');
}

if (isset($_POST) && isset($_POST['user'])) {
    inicioSesion();
}

if (isset($_GET) && isset($_GET['logout'])) {
    logout();
}
