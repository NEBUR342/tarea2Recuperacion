<?php
// Página Index donde veremos todos los usuarios en una tabla y podremos crear, editar y borrar
// Controlaremos errores de validación en el lado de servido, mostraremos mensajes de alerta con sweetalert2.
session_start();

use Src\Usuario;
require "./../vendor/autoload.php";
$usuarios = Usuario::read();
if (isset($_POST['id'])) {
  if (isset($_POST['u'])) {
    $_SESSION['id'] = $_POST['id'];
    header("Location:editar.php?id={$_SESSION['id']}");
    die();
  }
  if (isset($_POST['d'])) {
    Usuario::delete($_POST['id']);
    $_SESSION['mensaje']="Usuario borrado";
    header("Location:{$_SERVER['PHP_SELF']}");
    die();
  }
} else {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CDN FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN SeetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Portal</title>
</head>
<body style="background-color:darkgrey">
    <h5 class="text-center my-4">Listado de usuarios</h5>
    <a href="nuevo.php" class="btn btn-success float-end me-5"><i class="fa-solid fa-plus"> NUEVO </i></a>
    <div class="container">
        <table class="table rounded-3 text-light" style="background-color:black">
            <thead>
                <tr class="text-center text-uppercase">
                    <th scope="col">id</th>
                    <th scope="col">nombre</th>
                    <th scope="col">email</th>
                    <th scope="col">sueldo</th>
                    <th scope="col">permisos</th>
                    <th scope="col">acciones</th>
                </tr>
            </thead>
            <tbody>
              <?php
              foreach($usuarios as $usuario){
                echo <<<TXT
                <tr class="text-center">
                    <th scope="row">{$usuario->id}</th>
                    <td>{$usuario->nombre} {$usuario->apellidos}</td>
                    <td>{$usuario->email}</td>
                    <td>{$usuario->sueldo}</td>
                TXT;
                if($usuario->is_admin=="SI"){
                  echo <<<TXT
                    <td>Admin</td>
                  TXT;
                } else {
                  echo <<<TXT
                    <td>Usuario</td>
                  TXT;
                }
                echo <<<TXT
                    <td>
                    <form method='POST' action='index.php'>
                      <input type="hidden" value="{$usuario->id}" name='id'/>
                      <button type='submit' name='u' class='btn btn-info'>
                          <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <button type='submit' name='d' class='btn btn-danger'>
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                    </td>
                  </tr>
                TXT;
              }
              ?>
            </tbody>
        </table>
    </div>
    <script>
      <?php 
        if(isset($_SESSION['mensaje'])){
          echo <<<TXT
            Swal.fire({
              icon: 'success',
              title: '{$_SESSION['mensaje']}',
              showConfirmButton: false,
              timer: 1500
            })
          TXT;
          unset($_SESSION['mensaje']);
        }
      ?>
    </script>
</body>

</html>
<?php } ?>