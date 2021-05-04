<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "RecetasNow";

$enlace = mysqli_connect($servername, $username,$password, $database);

if ($enlace == false ) {
  die("Fallo la conexion a la base de datos" . $enlace->connect_error);
}
if(isset($_POST["submit"])){
    echo "Error con el submit";
}
else{
    echo "Conexion con el servidor establecida";
}

$nombre = $_POST['nombre'];
$desc = $_POST['desc'];
$dura = $_POST['dura'];
$ingr = $_POST['ingr'];
$proc = $_POST['proc'];

$consulta = "INSERT INTO recetas (nombre, descripcion, duracion, ingrediente, proceso) VALUES ('".$nombre ."' , '" .$desc . "','".$dura ."','".$ingr ."' , '" .$proc . "')";


$resultado = mysqli_query($enlace,$consulta);
mysqli_close($enlace);

if($resultado){
    echo '<script language="javascript">
    window.location="index.php";
    </script>';
}
else{
    echo '<script language="javascript">
    	alert("No se ha subido su prenda. Por favor, intentelo más tarde.");
    	window.location="index.php";
        </script>';
}

?>