<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header('Location: ../login.php');
    exit();
}

require_once "../database/conexion.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['id'];
    $tipo = $_POST['transactionType'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];

    // Abre una conexión a la base de datos
    $con = getCon();

    // Prepara la consulta SQL de inserción
    $query = "INSERT INTO procesos (userid, tipo, descripcion, monto, categoria) VALUES (:userid, :tipo, :descripcion, :monto, :categoria)";
    $statement = $con->prepare($query);
    $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $statement->bindParam(':monto', $monto, PDO::PARAM_STR);
    $statement->bindParam(':categoria', $categoria, PDO::PARAM_STR);

    // Ejecuta la consulta SQL de inserción
    $statement->execute();

    // Cierra la conexión a la base de datos
    $con = null;

    // Luego, redirecciona a la página donde deseas mostrar la tabla de transacciones
    header('Location: ../usuario.php');
}
?>
