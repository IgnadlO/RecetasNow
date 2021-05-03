<?php

$servername = "192.168.1.58";
$username = "root";
$password = "";
$database = "recetasNow";

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

$consulta = "INSERT INTO prendas (nombre, descripcion, duracion, ingrediente, proceso) VALUES ('".$nombre ."' , '" .$desc . "','".$dura ."','".$ingr ."' , '" .$proc . "')";


$resultado = mysqli_query($enlace,$consulta);
mysqli_close($enlace);

if($resultado){
    echo '<script language="javascript">
    alert("La informacion se ha cargado en el servidor correctamente");
    window.location="index.html";
    </script>';
}
else{
    echo '<script language="javascript">
    	alert("No se ha subido su prenda. Por favor, intentelo más tarde.");
    	window.location="index.html";
        </script>';
}

?>