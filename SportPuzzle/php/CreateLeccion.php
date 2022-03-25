<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/Logo.png">
    <title>CurSOS</title>
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsCreate.css">
    <script type="text/javascript" src="../Js/modelosJS/leccion.js"></script>
    <script type="text/javascript" src="../Js/modelosJS/curso.js"></script>


</head>
<?php
include 'navbar.php';
?>

<body>

    <!-- Page Content -->
    <div class="noticiamarco">
        <h1 style="text-align: center;">Nueva Leccion</h1>

        <form>
            <h4>Nombre de la leccion:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <input type="text" class="form-control" id="nombreleccion" placeholder="Titulo">
            </div>
            <h4>Curso que agregas leccion:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <select class="form-control" id="cursos">

                </select>
            </div>
        </form>
        <h4 style="margin-top: 10px;">Miniatura:</h4>
        <form style="margin-bottom: 50px;">
            <div class="form-group-imagen">
                <label for="imagenleccion">Agregar miniatura</label>
                <input type="file" accept=".jpg,.png" class="form-control-file" name="imagenleccion" id="imagenleccion">
            </div>
        </form>
        <h4 style="margin-top: 10px;">Video:</h4>
        <form style="margin-bottom: 50px;">
            <div class="form-group-video">
                <label for="videoleccion">Agregar vídeo</label>
                <input type="file" accept=".mp4" class="form-control-file" name="videoleccion" id="videoleccion">
            </div>
        </form>
        <h4 style="margin-top: 10px;">Archivo:</h4>
        <form style="margin-bottom: 50px;">
            <div class="form-group-video">
                <label for="archivoleccion">Agregar archivo</label>
                <input type="file" accept=".pdf" class="form-control-file" name="archivoleccion" id="archivoleccion">
            </div>
        </form>
        <h4>Notas Extras:</h4>
        <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
            <textarea class="form-control" id="notaextraleccion" placeholder="NotaExtra" rows="4"></textarea>
        </div>
        <center>
            <button id="btn-crearleccion" type="button" class="btn btn-success">Añadir Leccion</button>
        </center>
        <br>
    </div>
    <!--Marco-->
    <?php
    include 'footer.php';
    ?>

</body>
<script type="module">
    import {
        urlglobal
    } from '../Js/urlglobal.js'

    $(document).ready(function() {
        var idactual = <?php echo $_SESSION['id_usuario'] ?>;
        debugger
        getCursos(idactual);
        //Obtenemos la información del curso
        $('#btn-crearleccion').on('click', (event) => {
            event.preventDefault();
            if ($('#nombreleccion').val() == "" ||$('#notaextraleccion').val() == "" ||
                $('input[name="archivoleccion"]')[0].files[0] == null || $('input[name="imagenleccion"]')[0].files[0] == null ||
                $('input[name="videoleccion"]')[0].files[0] == null || document.getElementById("cursos").selectedIndex == null) {
                debugger
                alert("Asegurate que los campos este completos");
            } else {
                var course = document.getElementById("cursos").selectedIndex;
                let coursevalue = document.getElementsByTagName("option")[course].value;

                var fotoleccion = $('input[name="imagenleccion"]')[0].files[0];
                var videoleccion = $('input[name="videoleccion"]')[0].files[0];
                var archivoleccion = $('input[name="archivoleccion"]')[0].files[0];
                debugger
                let leccionData = new Leccion(null, $('#nombreleccion').val(), coursevalue, 1, archivoleccion, fotoleccion, videoleccion, $('#notaextraleccion').val(), null, null);
                debugger
                crearLeccion(leccionData);
            }


        });
        //Funcion CreamosCurso
        function crearLeccion(LaLeccion) {
            var dataToSend = {
                cursoid: LaLeccion.cursoid,
                nombre: LaLeccion.nombre,
                nivel: LaLeccion.nivel,
                archivo: LaLeccion.archivo,
                foto: LaLeccion.foto,
                video: LaLeccion.video,
                extra: LaLeccion.extra
            };
            //Agregamos la imagen de la lecccion
            // Create an FormData object 
            var imageCourse = document.getElementById('imagenleccion');
            var myFormData = new FormData();
            myFormData.append('foto', imageCourse.files[0]);
            debugger
            var promise = $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "../Js/subir-imagen-leccion.php",
                data: myFormData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function(data) {
                    dataToSend.foto = data;
                    alert("Imagen agregada");
                    debugger
                },
                error: function(data) {
                    console.log(data);
                    debugger
                }
            });
            var videoCourse = document.getElementById('videoleccion');
            var myFormData2 = new FormData();
            myFormData2.append('video', videoCourse.files[0]);
            //Agregamos el video de la leccion
            promise.then(() => {

                var promise2 = $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "../Js/subir-video-leccion.php",
                    data: myFormData2,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function(data) {
                        dataToSend.video = data;
                        alert("Video agregado");
                        debugger
                    },
                    error: function(data) {
                        console.log(data);
                        debugger
                    }
                });
                var archivoLesson = document.getElementById('archivoleccion');
                var myFormData3 = new FormData();
                myFormData3.append('archivo', archivoLesson.files[0]);
                //Agregamos el archivo de la leccion
                promise2.then(() => {

                    var promise3 = $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: "../Js/subir-archivo-leccion.php",
                        data: myFormData3,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 800000,
                        success: function(data) {
                            dataToSend.archivo = data;
                            alert("Archivo agregado");
                            debugger
                        },
                        error: function(data) {
                            console.log(data);
                            debugger
                        }
                    });
                    //Mandamos la info a la BD
                    promise3.then(() => {
                        var dataToSendJson = JSON.stringify(dataToSend);
                        debugger
                        $.ajax({
                            url: urlglobal.url + "/addLeccion",
                            async: true,
                            type: 'POST',
                            data: dataToSendJson,
                            dataType: 'json',
                            contentType: 'application/json; charset=utf-8',
                            success: function(data) {
                                alert("Leccion agregada correctamente");
                            },
                            error: function() {
                                alert("Error agregando leccion");
                            }
                        });
                    });
                });

            });
        }

        function getCursos(idactual) {
            var dataToSend = {
                iduser: idactual    
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            $.ajax({
                url: urlglobal.url + "/getCursos",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    for (let dato of datos) {
                        var curso = new Curso(dato.id_curso, dato.nombre, null, null, null, null, null, null, null, null)
                        $('#cursos').append($('<option>', {
                            value: curso.id_curso,
                            text: curso.nombre
                        }));
                    }
                },
                error: function() {
                    alert("Error agregando curso");
                }
            })
        }

    });
</script>

</html>