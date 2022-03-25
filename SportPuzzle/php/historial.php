<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CurSOS</title>
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsbusqueda.css">
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <br>
    <center>
        <h1>Resultados</h1>
    </center>
    <div class="container" id="CursosEncontrados">
    </div>
    <br>
    <?php
    include 'footer.php';
    ?>
</body>
<script type="module">
    import {
        urlglobal
    } from '../Js/urlglobal.js'
    $(document).ready(function() {
        debugger
        var idactual = <?php echo $_SESSION['id_usuario'] ?>;
        HistorialDeCursos(idactual);

        function HistorialDeCursos(idactual) {
            // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
            var dataToSend = {
                UsuarioIDHistorial: idactual
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/HistorialDeCursos",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    var muestrame = Object.keys(datos).length; //Obtienes el numero de cursos
                    if (muestrame > 0) {
                        if (muestrame >= 3) {
                            document.getElementById("footer").style.position = "relative";
                        }
                        for (let dato of datos) {
                            var html = '<a class="cursito" href="seleccionado.php?idcurso=' + dato.id_curso + '" style="text-decoration: none; color: black;">';
                            html += '<div class="card mb-3" style="max-width: 1200px;">';
                            html += '<div class="row no-gutters">';
                            html += '<div class="col-md-4">';
                            html += '<img height="207" src="' + dato.foto + '" class="card-img" alt="...">';
                            html += '</div>';
                            html += '<div class="col-md-8">';
                            html += '<div class="card-body">';
                            html += '<h5 class="card-title">'+ dato.nombre +'</h5>';
                            html += '<p class="card-text">' + dato.descripcion + '</p>';
                            html += '<br>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';
                            $('#CursosEncontrados').append(html);
                        }
                    }
                },
                error: function() {
                    alert("Error Buscando los Cursos");
                }
            });
        }
    });
</script>

</html>