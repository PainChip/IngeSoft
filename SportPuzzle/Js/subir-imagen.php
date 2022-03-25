<?php 

require 'C:/xampp/htdocs/Progra-Web-de-Capa-Intermedia/CurSOS/apiRest/src/config/db.php';

$foto=$_FILES["foto"]["name"];

if($foto) {
    ////Para guardar de forma unica
    // $string1 = $foto;
    // $string2 = time();
    // $name_str = $string2 . '' . $string1;
    // echo $name_str;
    $ruta=$_FILES["foto"]["tmp_name"];
    $destino="../imagenes/Perfil".$foto;
    move_uploaded_file($ruta, $destino);

    session_start();

    $id = $_SESSION['id_usuario'];

    if($id) {
        $sql = "UPDATE Usuario SET avatar = '".$destino."' WHERE id_usuario = ".$id.";";
        echo $sql;
        $db = new db();
        $db = $db->connectionDB();
        $result = $db->query($sql);

        if (!$result) {
            echo "Problema al hacer un query: " . $db->error;								
        } else {
                        
            $_SESSION['avatar'] = $destino;
            echo '{"message" : { "status": "200" , "text": "Usuario modificado satisfactoriamente." } }';
        }

        $result = null;
        $db = null;
    }
}

header("location:../php/Perfil.php");
?>