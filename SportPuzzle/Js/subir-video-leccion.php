<?php 

$video=$_FILES["video"]["name"];

if($video) {
    ////Para guardar de forma unica
    // $string1 = $video;
    // $string2 = time();
    // $name_str = $string2 . '' . $string1;
    // echo $name_str;
    $ruta=$_FILES["video"]["tmp_name"];
    $destino="../videos/Lecciones/".$video;
    move_uploaded_file($ruta, $destino);
    echo $destino;
}

?>