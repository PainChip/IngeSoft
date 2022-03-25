<?php 

$archivo=$_FILES["archivo"]["name"];

if($archivo) {
    ////Para guardar de forma unica
    // $string1 = $archivo;
    // $string2 = time();
    // $name_str = $string2 . '' . $string1;
    // echo $name_str;
    $ruta=$_FILES["archivo"]["tmp_name"];
    $destino="../archivos/Lecciones/".$archivo;
    move_uploaded_file($ruta, $destino);
    echo $destino;
}

?>