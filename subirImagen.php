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

$id = $_POST['id'];
$archivo = $_FILES['imagen']['tmp_name'];
$ruta = "Img";
$carpeta = $ruta."/";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
$x = 0;
$i = -1;
while ($x == 0) {
$i ++;
$nombreImagen = "comida" . $i . ".png";
$ruta = "Img/".$nombreImagen;
if (!file_exists($ruta)) {
move_uploaded_file($archivo,$ruta);
$x ++;
}
}

$consulta = "INSERT INTO fotos (idReceta, direccion) VALUES ('".$id ."' , '" .$ruta . "')";

$resultado = mysqli_query($enlace,$consulta);
mysqli_close($enlace);

if($resultado){
    echo '<script language="javascript">
    window.location="verReceta.php?id='.$id.'";
    </script>';
}
else{
    echo '<script language="javascript">
    	alert("No se ha subido su Imagen. Por favor, intentelo más tarde.");
    	window.location="verReceta.php?id='.$id.'";
        </script>';
}

?>