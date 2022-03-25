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

    <link rel="stylesheet" href="../css/modsCursos.css">
    <script>
        $(document).ready(function() {});
    </script>

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="container" style="margin-top: 40px;">
        <ul class="nav nav-tabs" id="CategoriasNav">
        </ul>
        <div id="cursosSeleccionados">
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
        getCursosRecientesYCategorias();

        function getCursosRecientesYCategorias() {
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/get3CursosRecientes",
                async: true,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    for (let dato of datos) {
                        var html = '<a class="cursito" href="seleccionado.php?idcurso=' + dato.id_curso + '" style="text-decoration: none; color: black;">';
                        html += '<div class="card mb-3" style="max-width: 1200px;">';
                        html += '<div class="row no-gutters">';
                        html += '<div class="col-md-4">';
                        html += '<img  height="207" src="' + dato.foto + '" class="card-img" alt="...">';
                        html += '</div>';
                        html += '<div class="col-md-8">';
                        html += '<div class="card-body">';
                        html += '<h5 class="card-title">' + dato.nombre + '</h5>';
                        html += '<p class="card-text"> Descripcion: ' + dato.descripcion + '</p>';
                        html += '<p class="card-text"><small class="text-muted"> Precio: $' + dato.costo + '</small></p>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</a>';
                        $('#cursosSeleccionados').append(html);
                    }
                },
                error: function() {
                    alert("Error con los cursos mas recientes, posiblemente no hay ni uno");
                }
            });
            promise.then(() => {
                var promise2 = $.ajax({
                    url: urlglobal.url + "/getCategorias",
                    async: true,
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(datos) {
                        for (let dato of datos) {
                            var html = '<li class="nav-item">';
                            html += '<a class="nav-link categoriaSelect" idCategoria = "' + dato.id_categoria + '" style="cursor: pointer;">' + dato.categoria + '</a>';
                            html += '</li>';
                            $('#CategoriasNav').append(html);
                        }
                    },
                    error: function(x, y, z) {
                        alert("Error en la api: " + x + y + z);
                    }
                })

            });
        }
        $("body").on("click", ".categoriaSelect", function() {
            let dalepapu = $(this).attr("idCategoria");
            let cursos = document.getElementById('cursosSeleccionados'); //limpias el chat de con quien chateas
            while (cursos.firstChild) {
                cursos.removeChild(cursos.firstChild);
            }
            TraerCursosDeCategoria(dalepapu);
        });

        function TraerCursosDeCategoria(idCategoria) {
            // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
            var dataToSend = {
                idcategoria: idCategoria
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/TraerCursosDeCategoria",
                async: true,
                data: dataToSendJson,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    var muestrame = Object.keys(datos).length; //Obtienes el numero
                    if (muestrame > 0) {
                        for (let dato of datos) {
                            var html = '<a class="cursito" href="seleccionado.php?idcurso=' + dato.id_curso + '" style="text-decoration: none; color: black;">';
                            html += '<div class="card mb-3" style="max-width: 1200px;">';
                            html += '<div class="row no-gutters">';
                            html += '<div class="col-md-4">';
                            html += '<img  height="207" src="' + dato.foto + '" class="card-img" alt="...">';
                            html += '</div>';
                            html += '<div class="col-md-8">';
                            html += '<div class="card-body">';
                            html += '<h5 class="card-title">' + dato.nombre + '</h5>';
                            html += '<p class="card-text"> Descripcion: ' + dato.descripcion + '</p>';
                            html += '<p class="card-text"><small class="text-muted"> Precio: $' + dato.costo + '</small></p>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';
                            $('#cursosSeleccionados').append(html);
                        }

                    }
                },
                error: function() {
                    // alert("Error con los cursos mas recientes, posiblemente no hay ni uno");
                }
            });
        }

    });
</script>

</html>