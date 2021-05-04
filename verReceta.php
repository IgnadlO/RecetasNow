<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "RecetasNow";
$nReceta = $_REQUEST['id'];

$conexion = mysqli_connect($servername, $username,$password, $database);

if ($conexion == false ) {
  die("Fallo la conexion a la base de datos" . $conexion->connect_error);
}
?>
<?php

   if($_POST)
      {
         $sql = "UPDATE recetas SET nombre = '".$_POST['nombreForm']."',
                        descripcion = '".$_POST['descForm']."',
                        duracion = '".$_POST['duraForm']."',
                        ingrediente = '".$_POST['ingrForm']."',
                        proceso = '".$_POST['procForm']."'
                        WHERE ID = ".$_POST['idForm'].";"; 
         $result = mysqli_query($conexion, $sql); 
      }

  $sql = "SELECT * FROM recetas";
  mysqli_set_charset($conexion, "utf8"); 
  if(!$result = mysqli_query($conexion, $sql)) die();
  while($row = mysqli_fetch_array($result)){ 
    if ($nReceta == $row['id']) {
      $nombre = $row['nombre'];
      $desc = $row['descripcion'];
      $dura = $row['duracion'];
      $ingr = $row['ingrediente'];
      $proc = $row['proceso'];
      break;
    }
  }
?>
<!DOCTYPE html>
<html lang="es">
 <head>
 	<meta charset="utf-8">
 	<title><?php echo $nombre ?></title>
 	<meta name="Description" content="Mi contenedor personal de recetas">
 	<link rel="stylesheet" href="Css/Estilo.css" media="all"/>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
 		
 </head>
 	
 <body>

  <header class="header">
    <h1 class="logo"><?php echo $nombre ?></h1>
    <div class="cabeza">  
      <nav class="nav" id="nav-1">
      <ul class="menu">
        <li class="menu__item"><a class="menu__link" href="Index.php">Inicio</a></li>
      </ul>
      </nav>
      <nav class="nav" id="nav-2">
      <ul class="menu">
        <li class="menu__item"><a class="menu__link" onclick="crearImagen()">Nueva Foto</a></li>
        <li class="menu__item"><a class="menu__link" onclick="editar()">Editar</a></li>
      </ul>
      </nav>
    </div>
  </header>

  <div class="contenedor" id="contVer">
 			<article class="article" style="padding-left: 10px;">
 					<h3><?php echo $desc ?></h3>
 			</article>
      <div class="contenedorDatos">
       <div class="receta-2" id="rec01">
        <h1>Ingredientes</h1>
        <ul>
        <?php
        $sepIngr = explode("_-_", $ingr);
        for ($i = 0; $i < count($sepIngr); $i++) { 
        ?>
        <li><?php echo $sepIngr[$i] ?></li>
      <?php } ?>
      </ul>
      </div>
       <div class="receta-2" id="rec02">
        <h1>Proceso</h1>
        <ul>
        <?php
        $sepProc = explode("_-_", $proc);
        for ($i = 0; $i < count($sepProc); $i++) { 
        ?>
        <li><?php echo $sepProc[$i] ?></li>
      <?php } ?>
      </ul>
      </div>
      </div>

      <div class="editor" id="editor">
      </div>	

      <div class="contenedor-2" id="cajaImagen">
      </div>
		 <div class="clearfix">
      <h1>Imagenes</h1>
		  <section id="content">
        <?php
          $array = array();
          $sql = "SELECT * FROM fotos";
          mysqli_set_charset($conexion, "utf8"); 
          if(!$result = mysqli_query($conexion, $sql)) die();
          while($row = mysqli_fetch_array($result)){ 
            if ($nReceta == $row['idReceta']) {
                array_push ($array , $row['direccion']);
            }
          }
          foreach ($array as $rutasa) {
        ?>
 			  <img class="imagenComida" src="<?php echo $rutasa ?>" alt="Receta01">
        <?php } ?>
 		   </section>
    </div>
  </div>
  <script type="text/javascript">

  function crearImagen(){
     var cajaImagen = document.getElementById("cajaImagen");
     if (cajaImagen.getElementsByTagName('div').length == 0){
        cajaImagen.insertAdjacentHTML("beforeend",'<form method="POST" id="Formulario" action="subirImagen.php" enctype="multipart/form-data"><input type="hidden" name="id" value="<?php echo $nReceta ?>"><div id="cuadroImagen"></div><div id="contenedor_imagen"><input type="file" name="imagen" id="imagen" onchange="validarImagen(this);" required multiple><a id="texto_imagen">Elegir Imagen</a></div><div id="botones"></div></form>');
     }
  }


  function validarImagen(obj){
    var uploadFile = obj.files[0];

    if (!window.FileReader) {
        alert('El navegador no soporta la lectura de archivos');
        document.getElementById("imagen").value = "";
        return;
    }

    if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
        alert('El archivo a adjuntar no es una imagen');
         document.getElementById("imagen").value = "";
    }
    else {
        var img = new Image();
        img.onload = function () {
            if (uploadFile.size > 500000)
            {
                alert('El peso de la imagen no puede exceder los 5mb')
                document.getElementById("imagen").value = "";
            }
            else {
               previsualizar(obj);            
            }
        };
        img.src = URL.createObjectURL(uploadFile);
    }                 
}

function previsualizar(obj){
  let reader = new FileReader();
  reader.readAsDataURL(obj.files[0]);
  reader.onload = function(){
    let preview = document.getElementById('cuadroImagen'),
            image = document.createElement('img');

    image.src = reader.result;
    image.id = "previsualizar";

    preview.innerHTML = '';
    preview.append(image);
  };
  var cajaBotones = document.getElementById("botones");
     if (cajaBotones.getElementsByTagName('input').length == 0){
        cajaBotones.insertAdjacentHTML("beforeend",'<input type="submit" class="boton" value="Aceptar"><input type="button" value="Cancelar" class="boton" onclick="cancelar();">');
  }
  document.getElementById("texto_imagen").innerHTML = "Elegir Otra";
}

  function cancelar(){
    document.getElementById("cajaImagen").innerHTML = "";
  }

function editar(){
  var cajaBotones = document.getElementById("editor");
     if (cajaBotones.getElementsByTagName('input').length == 0){
        cajaBotones.insertAdjacentHTML("beforeend", `<article class="article" style="padding-left: 10px;"><h3>Editor</h3></article><form method="POST" id="Formulario" action=""><h1>Caracteristicas</h1><div class="contenedor" id="cajaEditor"><input type="hidden" name="idForm" value="<?php echo $nReceta ?>"><div class="Ingreso"><input type="text" id="nombre" value="<?php echo $nombre ?>" name="nombreForm" maxlength="32" class="input" placeholder="Nombre" required=""> </div><div class="Ingreso"><input type="text" id="desc" name="descForm" value="<?php echo $desc ?>" class="input" placeholder="Descripcion" rows="2" maxlength="128" required=""></div><div class="Ingreso"><input type="text" id="dura" name="duraForm" size="16" value="<?php echo $dura ?>" class="input2" placeholder="Duracion" required=""> </div><div class="Ingreso" id="ingrClase"><input type="button" value="+" id="bIngr" onclick="sumar('ingr','Ingrediente')" class="Mas" ><input type="button" value="-" onclick="borrar('ingr')" class="Mas" ><br/><?php for ($i = 0; $i < count($sepIngr); $i++) { ?><input type="text" id="ingr<?php echo $i ?>" name="ingrForm" value="<?php echo $sepIngr[$i] ?>" size="160" class="input2" placeholder="Ingredientes" required=""><?php } ?></div><div class="Ingreso" id="procClase"><input type="button" value="+" onclick="sumar('proc','Proceso')" class="Mas" ><input type="button" value="-" onclick="borrar('proc')" class="Mas" ><br/><?php for ($i = 0; $i < count($sepProc); $i++) { ?><input type="text" id="proc<?php echo $i ?>" name="procForm" value="<?php echo $sepProc[$i] ?>" size="640" class="input2" placeholder="Proceso" required=""><?php } ?></div><br><br><input type="button" value="Subir" onclick="subir()" class="Boton" ><br/></div></form>`);
        }
    }
  function sumar(id, tipo){
        var lista = document.getElementById(id + "Clase");
        i = lista.getElementsByTagName('input').length;
        lista.insertAdjacentHTML("beforeend",'<input type="text" id="'+ id + (i - 2) +'" name="'+ id + (i - 2) +'" size="640" class="input2" placeholder="'+ tipo + ' ' + (i - 1) +'" required="">');
    }

    function borrar(id){
        var lista = document.getElementById(id + "Clase");
        i = lista.getElementsByTagName('input').length;
        if(i > 3){
        input = document.getElementById(id + (i - 3));
        padre = input.parentNode;
        padre.removeChild(input);
      }
      else{
        input = document.getElementById(id + "0");
        input.value = null;
      }
    }

    function subir(){
      tipo = ["ingr","proc"]
      for (var n = 0; n <= 1; n++){
        var lista = document.getElementById(tipo[n] + "Clase");
            largo = lista.getElementsByTagName('input').length;
            ingrediente = document.getElementById(tipo[n] + "0").value;
        for (var i = 1; i <= (largo - 3); i++) {
          if(document.getElementById(tipo[n] + i).value != ""){
          ingrediente = ingrediente + "_-_" + document.getElementById(tipo[n] + i).value;
          }
        }
        for (var i = 1; i <= (largo - 3); i++) {
          input = document.getElementById(tipo[n] + i);
            padre = input.parentNode;
            padre.removeChild(input);
        }
        document.getElementById(tipo[n] + "0").value = ingrediente;
      }
      
      
      document.forms["Formulario"].submit()
      for (var i = 0; i <= 1; i++){
        document.getElementById(tipo[i] + "0").value = null;
      }
  }
</script>
 </body>
</html>

<?php $close = mysqli_close($conexion) ?>