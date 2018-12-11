<?php
if(!isset($_SESSION)){
    session_start();
}
include("conexiones/conexionLocalhost.php");
include("includes/codigoComun.php");
if(!isset($_SESSION['userId'])){
    header("Location: index.php?userLoggedIn=false");
}
if(isset($_POST['sent'])){
    foreach($_POST as $datos => $valor){
		if($valor == "") {
            $error[] = "El campo $datos se encuentra vacio"; 
        }
        if($datos == 'cantidad' OR $datos == 'precio'){
            if(!is_numeric($valor) OR $valor < 0){
                $error[] = "El campo $datos se acepta solo valores numericos positivos"; 
            }
        }	
    }
    if(!isset($error)){
        $queryLibroRegister = sprintf("INSERT INTO tbllibros(titulo, descripcion, fechaPublicacion, cantidad, precio, tipoProducto, img, idPublicador, autor, editorial) 
        VALUES ('%s', '%s', '%s', '%d', '%d', '%s', '%s', '%d', '%s', '%s')",
			mysql_real_escape_string(trim($_POST["titulo"])),
			mysql_real_escape_string(trim($_POST["descripcion"])),
			mysql_real_escape_string(trim($_POST["fechaPublicacion"])),
            mysql_real_escape_string(trim($_POST["cantidad"])),
            mysql_real_escape_string(trim($_POST["precio"])),
            mysql_real_escape_string(trim($_POST["tipoProducto"])),
            mysql_real_escape_string(trim($_POST["img"])),
            $_SESSION['userId'],
            mysql_real_escape_string(trim($_POST["autor"])),
            mysql_real_escape_string(trim($_POST["editorial"]))
        );
        $resQueryLibroRegister = mysql_query($queryLibroRegister, $conexionLocalhost) or die("No se pudo guardar el usuario en la BD... Revisa tu codigo plomo.");
        header("Location: libros.php");
    }else{
        header("Location: add_libro.php?error=true");
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
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="container">
<!-- Header -->
<?php include("includes/header.php");?>

<!-- Navbar -->
<?php include("includes/navbar.php");?>

<!-- Content -->
<div class="form-style-10">
<h1>Pon tu libro en venta!<span>Es requerido llenar todos los campos.</span></h1>
<form action="add_libro.php" method="post">
    <div class="section"><span>1</span>Titulo & Descripcion</div>
    <div class="inner-wrap">
        <label>Titulo <input type="text" name="titulo" /></label>
        <label>Descripcion <textarea name="descripcion"></textarea></label>
    </div>

    <div class="section"><span>2</span>Cantidad & Precio</div>
    <div class="inner-wrap">
        <label>Cantidad disponible <input type="text" name="cantidad" /></label>
        <label>Precio del libro <input type="text" name="precio" /></label>
    </div>

    <div class="section"><span>3</span>Detalles</div>
    <div class="inner-wrap">
        <label>Fecha de publicacion <input type="text" name="fechaPublicacion" /></label>
        <label>Autor <input type="text" name="autor" /></label>
        <label>Editorial <input type="text" name="editorial" /></label>
        <label>Imagen (URL) <input type="text" name="img" /></label>
        <label>Tipo de Publicacion <select name="tipoProducto" class="form-control">
				<option value="Libro">Libro</option>
				<option value="Revista">Revista</option>
                <option value="Comic">Comic</option>
	    </select></label>
    </div>
    <div class="button-section">
     <input type="submit" name="sent" />
     <span class="privacy-policy">
     <input type="checkbox" name="field10">You agree to our Terms and Policy. 
     </span>
    </div>
</form>
</div>
</div>
<!-- Footer -->
<?php include("includes/footer.php");?>

<!--Script -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>