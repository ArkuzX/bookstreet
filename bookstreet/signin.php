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
    if($_POST["password"]!=$_POST["confirmPassword"]){
        $error[] = "Error en confirmar contraseña";
    }
    $queryEmailUser = sprintf("SELECT email FROM tblUsuarios WHERE email = '%s'", mysql_real_escape_string(trim($_POST["email"])));
	$resQueryEmailUser = mysql_query($queryEmailUser, $conexionLocalhost) or die("No se pudo ejecutar el query para login de usuario");
    if(mysql_num_rows($resQueryEmailUser)){
        $error[] = "Email ya registrado";
    }
    //No se detecto error
    if(!isset($error)){
        //Registrar nuevo usuario
        $queryUserRegister = sprintf("INSERT INTO tblUsuarios (email, password, nombre, rol) VALUES ('%s', '%s', '%s', '%s')",
			mysql_real_escape_string(trim($_POST["email"])),
			mysql_real_escape_string(trim($_POST["password"])),
			mysql_real_escape_string(trim($_POST["nombre"])),
            mysql_real_escape_string(trim($_POST["rol"]))
        );
        $resQueryUserRegister = mysql_query($queryUserRegister, $conexionLocalhost) or die("No se pudo guardar el usuario en la BD... Revisa tu codigo plomo.");
        //Iniciar sesion despues de registrar
        if($resQueryUserRegister){
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
<form action="signin.php" method="post" class="form-signin">
      <img class="mb-4" src="images/userLogin.png" alt="" width="72" height="72">

      <h1 class="h3 mb-3 font-weight-normal">Nuevo Usuario</h1>

      <label for="inputEmail" class="sr-only">Correo Electronico</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Correo Electronico" required autofocus>
      <label for="inputNombre" class="sr-only">Nombre de Usuario</label>
      <input type="text" name="nombre" id="inputNombre" class="form-control" placeholder="Nombre de Usuario" required>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
      <label for="inputCPassword" class="sr-only">Confirmar contraseña</label>
      <input type="password" name="confirmPassword" id="inputCPassword" class="form-control" placeholder="Confirmar Contraseña" required>
      <label for="rol" class="sr-only">Tipo de Usuario</label>
      <select name="rol" class="form-control">
				<option value="lector" <?php if(isset($_POST['rol']) AND $_POST['rol'] == "lector") echo 'selected="selected"'; ?>>Lector</option>
				<option value="autor" <?php if(isset($_POST['rol']) AND $_POST['rol'] == "autor") echo 'selected="selected"'; ?>>Autor</option>
                <option value="editorial" <?php if(isset($_POST['rol']) AND $_POST['rol'] == "editorial") echo 'selected="selected"'; ?>>Editorial</option>
	  </select>

      <button class="btn btn-lg btn-primary btn-block" type="submit" name="sent" value="Sign in">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy;Bookstreet 2018</p>
      <?php
      if(isset($error)){
        if(is_array($error)){
            echo "<ul>";
            foreach($error as $caca){
                echo "<li>$caca</li>";
            }
            echo "</ul>";
        }else{
            echo $error;
        }
    }
      ?>
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