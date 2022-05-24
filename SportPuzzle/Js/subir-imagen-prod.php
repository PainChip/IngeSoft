<?php 

$foto=$_FILES["image"]["name"];

if($foto) {
    $ruta=$_FILES["image"]["tmp_name"];
    $destino="../imagenes/Productos/".$foto;
    move_uploaded_file($ruta, $destino);
    echo $destino;
}

?>