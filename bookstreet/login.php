<?php
if(!isset($_SESSION)){
    session_start();
}
include("conexiones/conexionLocalhost.php");
include("includes/codigoComun.php");
if(isset($_POST['sent'])){
    foreach($_POST as $datosUsuario => $valor){
        if($valor == "") { $error[] = "Error en el campo $datosUsuario"; }
    }
    if(!isset($error)){
        $queryLoginUser = sprintf("SELECT id, nombre, email, password, rol, date_created, img, telefono FROM tblUsuarios WHERE email = '%s' AND password = '%s'",
        mysql_real_escape_string(trim($_POST["email"])),
        mysql_real_escape_string(trim($_POST["password"]))
        );
        $resQueryLoginUser = mysql_query($queryLoginUser, $conexionLocalhost) or die("No se pudo ejecutar el query para login de usuario");
        if(mysql_num_rows($resQueryLoginUser)){
            $userData = mysql_fetch_assoc($resQueryLoginUser);
            $_SESSION["userId"] = $userData["id"];
            $_SESSION["userEmail"] = $userData["email"];
            $_SESSION["userNombre"] = $userData["nombre"];
            $_SESSION["userFecha"] = $userData["date_created"];
            $_SESSION["userRol"] = $userData["rol"];
            $_SESSION["userImagen"] = $userData["img"];
            $_SESSION["userTelefono"] = $userData["telefono"];
            header("Location: index.php?registroUsuario=true");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bookstreet - Libreria Electronica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
</head>

<body>
<div class="container">
<!-- Header -->
<?php include("includes/header.php");?>

<!-- Navbar -->
<?php include("includes/navbar.php");?>

<!-- Content -->
<form action="login.php" method="post" class="form-signin">
      <img class="mb-4" src="images/userLogin.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesion</h1>
      <label for="inputEmail" class="sr-only">Correo Electronico</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Correo Electronico" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="sent" value="Log in">Log in</button>
      <p class="mt-5 mb-3 text-muted">&copy;Bookstreet 2018</p>
</form>
</div>
<!-- Footer -->
<?php include("includes/footer.php");?>

<!--Script -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>