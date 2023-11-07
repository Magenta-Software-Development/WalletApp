<?php
session_start();
if (!isset($_SESSION['rol'])) //Si entra sin un rol, lo manda a login.php
{
    header('Location: login.php');
} elseif ($_SESSION['rol'] == "usuario") //Si el rol no es admin
{
    header('Location: usuario.php'); //Lo envia para login.php, podemos hacer otro php para los users comunes
}


define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB_NAME', 'usuarios');
define('DB_CHARSET', 'utf8');

function getCon()
{


    try {
        $con = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER,  PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->exec("SET CHARACTER SET " . DB_CHARSET);

        return $con;
    } catch (Exception $e) {
        print "Error: " . $e->getMessage()  . "<br>";
        die();
    }
}


$con = getCon();

try {
    $query = "SELECT * FROM users";
    $statement = $con->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    //Cerrar flujo de base de datos
    $statement->closeCursor();
    $con = null;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "<br>";;
    die();
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
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <div class="header">
        <div class="row">
            <div class="col-1 inicio">
                <!--boton home-->
                <a href="index.php"><i class="fas fa-home"></i></a>
            </div>

            <div class="col-6 bienvenida">
                <h4 style="color:white"><?= "Bienvenido " . $_SESSION['user']; ?></h4>
            </div>
            <div class="col-2 ml-auto ">
                <a href="users/singin.php?logout" class="btn btn-danger">Cerrar sesion</a>
            </div>
        </div>
    </div>

    <div class="row fila">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Usuarios
                </div>
                <div class="card-body">
                    <table id="users" class="table table-striped">
                        <thead>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Usuario</th>
                            <th>Rol</th>

                        </thead>
                        <?php foreach ($results as $user) :
                            echo
                            '<tr> 
                                <td>' . $user["id"] . '</td>' .
                                '<td>' . $user["nombre"] . '</td>' .
                                '<td>' . $user["apellido"] . '</td>' .
                                '<td>' . $user["email"] . '</td>' .
                                '<td>' . $user["user"] . '</td>' .
                                '<td>' . $user["rol"] . '</td>' .

                                '</tr>';
                        endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

    </div>




    <script src="https://kit.fontawesome.com/2aad3a5418.js" crossorigin="anonymous" async></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>