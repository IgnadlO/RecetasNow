<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "RecetasNow";

$conexion = mysqli_connect($servername, $username,$password, $database);

if ($conexion == false ) {
  die("Fallo la conexion a la base de datos" . $conexion->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
 <head>
 	<meta charset="utf-8">
 	<title>RecetaNow</title>
 	<meta name="Description" content="Mi contenedor personal de recetas">
 	<link rel="stylesheet" href="Css/Estilo.css" media="all"/>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
 		
 </head>
 	
 <body>
 		 <header class="header">
    <h1 class="logo">Recetas</h1>
    <div class="cabeza">  
      <span class="icon-menu"></span>
      <nav class="nav" id="nav-1">
      <ul class="menu">
        <li class="menu__item"><a class="menu__link" href="nuevaReceta.html">Nueva Receta</a></li>
      </ul>
      </nav>
    </div>
</header>
 		
 			<article class="article">
 					<h3 style="text-align: center;">Mi contenedor personal de recetas</h3>
 			</article>
      <div class="contenedor">
      <?php
    $sql = "SELECT * FROM recetas";
    mysqli_set_charset($conexion, "utf8"); 
    if(!$result = mysqli_query($conexion, $sql)) die();
    while($row = mysqli_fetch_array($result)){ 
      ?>
      <div class="receta">
       <a class="recetaLink" href="verReceta.php?id=<?php echo $row['id'] ?>">
        <span class="recetaContenido">
          <div class="contenedorFoto">
            <?php 
              $query = "SELECT * FROM fotos";
              mysqli_set_charset($conexion, "utf8"); 
              if(!$resultado = mysqli_query($conexion, $query)) die();
              $si = 0;
              while($row_2 = mysqli_fetch_array($resultado)){ 
                if ($row_2['idReceta'] == $row['id']){
                  $si++;
                echo '<img class="fotoReceta" src="'.$row_2['direccion'].'" alt="Receta01">';
                break;
              }
              } 
              if($si == 0) echo '<img class="fotoReceta" src="Img/comida3.png" alt="Receta01">';
              ?>  
          </div>
          <div class="contenedorCont">
         <h1><?php echo $row['nombre'] ?></h1>
         <p class="recetaLink" style="text-align: left;"><?php echo $row['descripcion'] ?></p>
         <p class="dura"><?php echo $row['duracion'] ?></p>
         </div>
      </span>
    </a>
      </div>
      <?php } ?>	
  </div>
 </body>
</html>

<?php $close = mysqli_close($conexion) ?>