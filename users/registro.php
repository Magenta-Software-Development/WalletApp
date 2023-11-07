<?php
require_once '../database/conexion.php';

try {
    $con = getCon();

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    // Utiliza una sentencia preparada para evitar inyección SQL
    $query = "INSERT INTO users (nombre, apellido, email, user, pass, rol) VALUES (:nombre, :apellido, :email, :user, :pass, :rol)";
    $statement = $con->prepare($query);
    $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $statement->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':user', $user, PDO::PARAM_STR);
    $statement->bindParam(':pass', $pass, PDO::PARAM_STR);
    $statement->bindParam(':rol', $rol, PDO::PARAM_STR);

    if ($statement->execute()) {
        // La inserción fue exitosa
        header('Location: ../index.php?status=ok');
        exit();
    } else {
        // Error al ejecutar la consulta
        header('Location: ../login.php?status=repetido');
    }
} catch (Exception $e) {
    // Manejo de errores, mostrar mensaje y redireccionar
    echo 'Error: ' . $e->getMessage() . "<br>";
    header('Location: ../login.php?status=repetido');
}
