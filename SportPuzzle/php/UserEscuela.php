<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/Logo.png">
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsUser.css">

    <script type="text/javascript" src="../Js/modelosJS/user.js"></script>

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <br>
    <!-- Page Content -->
    <div class="container">
        <div id="Banner" class="Banner">
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12 border-right border-left border-bottom">
                <h2>CURSOS CREADOS</h2>
                <hr>
                <div class="cursos" id="CursitosCreados">
                </div>
            </div>
        </div>
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
        BuscaUserSusCursos(idactual);

        function BuscaUserSusCursos(idactual) {
            var arrayIdCursos = [];
            // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
            var dataToSend = {
                usuarioid: idactual
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            var promise = $.ajax({
                url: urlglobal.url + "/SusCursosYData",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    debugger
                    for (let dato of datos) {
                        arrayIdCursos.push(dato.id_curso)
                    }
                },
                error: function() {}
            });
            promise.then(() => {
                var lenghtArray = arrayIdCursos.length;
                if (lenghtArray > 0) {
                    for (var j = 0; j < lenghtArray; j++) {
                        var dataToSend2 = {
                            idcurso: arrayIdCursos[j]
                        };
                        var dataToSendJson2 = JSON.stringify(dataToSend2);
                        debugger

                        $.ajax({
                            url: urlglobal.url + "/getCursoVentas",
                            async: true,
                            type: 'POST',
                            data: dataToSendJson2,
                            dataType: 'json',
                            contentType: 'application/json; charset=utf-8',
                            success: function(datos) {
                                for (let dato of datos) {
                                    var html = '<div class="border-bottom text-center">';
                                    html += '<br>';
                                    html += '<h4>'+ dato.nombre +'</h4>';
                                    html += '<br>';
                                    html += '<div class="row" >';
                                    html += '<div class="col-6">';
                                    html += '<label  class="form-label">Numero de Alumnos</label>';
                                    html += '<input type="text" class="form-control" value="'+ dato.cantidad_personas +'" disabled>';
                                    html += '</div>';
                                    html += '<div class="col-6">';
                                    html += '<label  class="form-label">Total de Ganancias</label>';
                                    html += '<input type="text" class="form-control" value="'+ dato.cantidad_total +'" disabled>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<br>';
                                    html += '<br>';
                                    html += '</div>';
                                    $('#CursitosCreados').append(html);
                                }
                            },
                            error: function() {}
                        });

                    }
                }
            });
        }
    });
</script>

</html>