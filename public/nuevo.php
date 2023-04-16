<?php
session_start();
require "./../vendor/autoload.php";

use Src\Usuario;

if (isset($_POST['cancelar'])) {
    header("Location:index.php");
    die();
}
if (isset($_POST['create'])) {
    // comprobamos los errores
    $errores = false;
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $sueldo = trim($_POST['sueldo']);
    $isAdmin = trim($_POST['permisos']);
    if (strlen($nombre)<2) {
        $errores=true;
        $_SESSION['err_nombre'] = "Debes introducir un nombre valido (2 caracteres o mas)";
    }
    if (strlen($apellidos)<5) {
        $errores=true;
        $_SESSION['err_apellidos'] = "Debes introducir apellidos validos (5 caracteres o mas)";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores = true;
        $_SESSION['err_email'] = "Debes introducir un email valido";
    } else if(Usuario::existeEmail($email)){
        $errores = true;
        $_SESSION['err_email'] = "El email ya existe";
    }
    if (strlen($sueldo)==0) {
        $_SESSION['err_sueldo'] = "El campo debe estar relleno";
        $errores = true;
    } else if(is_numeric($sueldo)){
        $longitud=0;
        for ($x = strlen($sueldo) - 1; ($sueldo[$x] != "." && $sueldo[$x] != ",") && ($x >= 0); $x--) {
            $longitud++;
        }
        if ($longitud > 2 && $longitud != strlen($sueldo)) {
            $_SESSION['err_sueldo'] = "La cantidad de centimos no es posible, solo va de 0-99";
            $errores = true;
        } else {
        $sueldo = (int) $sueldo;
            if ($sueldo <= 0) {
                $_SESSION['err_sueldo'] = "El campo debe ser mayor a 0";
                $errores = true;
            } 
        } 
    } else {
        $_SESSION['err_sueldo'] = "El campo debe ser un numero";
        $errores = true;
    }
    if($isAdmin!="NO" && $isAdmin!="SI"){
        $_SESSION['err_isAdmin'] = "No hagas travesuras";
        $errores = true;
    }
    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    } else {
        $_SESSION['mensaje'] = "Usuario creado";
        (new Usuario)->setNombre($nombre)
            ->setApellidos($apellidos)
            ->setEmail($email)
            ->setIsAdmin($isAdmin)
            ->setSueldo($sueldo)
            ->create();
        header("Location:index.php");
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
        <title>Crear</title>
    </head>

    <body style="background-color:darkgray">
        <div class="container">
            <form name="crear" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h5 class="text-center my-4">Crear usuario</h5>
                <div class="mb-3">
                    <label for="nombreUsuario" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombre">
                    <?php
                    if (isset($_SESSION['err_nombre'])) {
                        echo "<small class='mb-2 text-danger text-sm italic'>{$_SESSION['err_nombre']}</small>";
                        unset($_SESSION['err_nombre']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="apellidosUsuario" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidosUsuario" name="apellidos">
                    <?php
                    if (isset($_SESSION['err_apellidos'])) {
                        echo "<small class='mb-2 text-danger text-sm italic'>{$_SESSION['err_apellidos']}</small>";
                        unset($_SESSION['err_apellidos']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="emailUsuario" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailUsuario" name="email">
                    <?php
                    if (isset($_SESSION['err_email'])) {
                        echo "<small class='mb-2 text-danger text-sm italic'>{$_SESSION['err_email']}</small>";
                        unset($_SESSION['err_email']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="sueldoUsuario" class="form-label">Sueldo</label>
                    <input type="number" step="0.01" class="form-control" id="sueldoUsuario" name="sueldo">
                    <?php
                    if (isset($_SESSION['err_sueldo'])) {
                        echo "<small class='mb-2 text-danger text-sm italic'>{$_SESSION['err_sueldo']}</small>";
                        unset($_SESSION['err_sueldo']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                <label for="sueldoUsuario" class="form-label">Permisos</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permisos" id="flexRadioDefault2" value="NO" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Usuario
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permisos" id="flexRadioDefault1" value="SI">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Administrador
                        </label>
                    </div>
                    <?php
                    if (isset($_SESSION['err_isAdmin'])) {
                        echo "<small class='mb-2 text-danger text-sm italic'>{$_SESSION['err_isAdmin']}</small>";
                        unset($_SESSION['err_isAdmin']);
                    }
                    ?>
                </div>
                <div class="float-end">
                    <button class="btn btn-outline-success btn-lg px-4" type="submit" name="create"><i class="fa-solid fa-floppy-disk"> Create</i></button>
                    <button class="btn btn-outline-danger btn-lg px-4" type="submit" name="cancelar"><i class="fa-solid fa-xmark"> Cancelar</i></button>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php } ?>