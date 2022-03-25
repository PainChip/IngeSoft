<?php 

$foto=$_FILES["foto"]["name"];

if($foto) {
    ////Para guardar de forma unica
    // $string1 = $foto;
    // $string2 = time();
    // $name_str = $string2 . '' . $string1;
    // echo $name_str;
    $ruta=$_FILES["foto"]["tmp_name"];
    $destino="../imagenes/Lecciones/".$foto;
    move_uploaded_file($ruta, $destino);
    echo $destino;
}

?>