<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header('Location: login.php');
    exit();
}

require_once "../database/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $userid = $_SESSION['id'];
    $id = $_POST['id'];

    $con = getCon();

    // Prepara la consulta SQL para eliminar el registro
// Prepara la consulta SQL para eliminar el registro
$query = "DELETE FROM procesos WHERE id = :id AND userid = :userid";
$statement = $con->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->bindParam(':userid', $userid, PDO::PARAM_INT); // Cambia a :userid

$statement->execute();


   

    // Cierra la conexión a la base de datos
    $con = null;

    // Redirecciona de regreso a la página de usuario después de eliminar
    header('Location: ../usuario.php');
}
