<?php
session_start();    //se inicia la sesion
if (!isset($_SESSION['rol'])) //Si entra sin un rol, lo manda a login.php
{
  header('Location: login.php');
} elseif ($_SESSION['rol'] == "admin") //Si el rol no es admin
{
  header('Location: index.php'); //Lo envia para login.php, podemos hacer otro php para los users comunes
}

//relacionar el config.php
require_once "config/config.php";

function getCon()   //funcion para obtener la conexion
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

$con = getCon(); // Obtén la conexión a la base de datos

try {
  $query = "SELECT * FROM Procesos WHERE userid = :userid"; // Consulta las transacciones del usuario actual
  $statement = $con->prepare($query);
  $statement->bindParam(':userid', $_SESSION['id'], PDO::PARAM_INT);
  $statement->execute();
  $transactions = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage() . "<br>";
  die();
}

// Cierra la conexión a la base de datos
$statement->closeCursor();
$con = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/usuario.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
  
</head>

<body>

  <div class="header"> <!--se crea el header-->
    <div class="row">
      <div class="col-1 inicio">
        <!--se crea el boton de inicio-->
        <a href="index.php"><i class="fas fa-home"></i></a>
      </div>
      <div class="col-3 bienvenida">

        <h4 style="color:white" name="autor"><?= "Bienvenido " . $_SESSION['user']; ?></h4> <!--se crea el nombre del usuario-->
      </div>
      <div class="col-4 botones">

      </div>
      <div class="col-2">
        <!--Total de montos-->
        <?php
        //si el tipo es ingreso se suma el monto, si es egreso se resta
        $total = 0;
        foreach ($transactions as $transaction) {
          if ($transaction['tipo'] == 'Ingreso') {
            $total += $transaction['monto'];
          } else {
            $total -= $transaction['monto'];
          }
        }

        echo "<h4 style='color:white'>Total:$  $total</h4>";

        ?>
      </div>
      <div class="col-1 d-flex justify-content-end">
        <div class="dropdown">
          <button class="btn botonp dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> <!--se crea el boton de opciones-->
            <i class="fa-solid fa-gear"></i>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="users/editar.php?">Perfil</a></li>
            <li><a class="dropdown-item" href="users/singin.php?logout">Cerrar Sesion</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>

  <h1>Mi aplicacion para gastos</h1>
  <div class="row">
    <div class="col l5 offset-l1 s12">
      <table id="transactionTable">
        <h4>Historial de transacciones</h4>
        <thead>
          <tr>
            <th scope="col">Tipo</th>
            <th scope="col">Descripción</th>
            <th scope="col">Monto</th>
            <th scope="col">Categoria</th>
            <th scope="col">Eliminar</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($transactions as $transaction) : ?>
            <tr>

              <td><?= $transaction['tipo'] ?></td>
              <td><?= $transaction['descripcion'] ?></td>
              <td><?= $transaction['monto'] ?></td>
              <td>
                <?= 
                //si tipo es ingreso se pone en verde, si es egreso se pone en rojo
                $transaction['tipo'] == 'Ingreso' ? '<span class="green-text">' . $transaction['categoria'] . '</span>' : '<span class="red-text">' . $transaction['categoria'] . '</span>'
                 ?>
            </td>
              <td>
                <form action="users/eliminar.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
                  <button type="submit" name="eliminar">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="col l5 s12">
      <div class="col s8 offset-s2">
        <form action="users/procesar.php" method="POST">
          <p>
            <span>Transaccion</span>
            <label>
              <i class="material-icons">add</i>
              <input value="Ingreso" class="with-gap" name="transactionType" type="radio" checked />
              <span>Ingreso</span>
            </label>
            <label>
              <i class="material-icons">indeterminate_check_box</i>
              <input value="Egreso" class="with-gap" name="transactionType" type="radio" />
              <span>Egreso</span>
            </label>
          </p>
          <label for="descripcion">Descripción:</label>
          <input type="text" name="descripcion" id="descripcion" required>

          <label for="monto">Monto:</label>
          <input type="text" name="monto" id="monto" required>

          <label for="categoria">Categoría:</label>
          <input type="text" name="categoria" id="categoria" required>

          <button type="submit">Guardar</button>
        </form>

      </div>
    </div>
  </div>



  <script src="https://kit.fontawesome.com/2aad3a5418.js" crossorigin="anonymous" async></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>