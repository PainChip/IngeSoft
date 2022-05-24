<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/Logo.png">
    <title>SportsPuzzle</title>
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsSeleccionado.css">

</head>


<body>
    <?php
    include 'navbar.php';
    ?>
    <br>

    <div class="container">

        <div class="row">

            <div class="col-lg-9">

                <div class="card mt-4">
                    <div id="cursoData">
                    </div>
                    <div class="card-body">
                        <br><br>
                        <button id="ComprarCurso" class="btn btn-success" style="margin-right:15px;">Añadir al carrito</button>
                        <button id="CompartirCurso" class="btn btn-success" disabled>Compartir</button>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                    <div class="card-header"> Comentarios </div>
                    <div class="card-body">
                        <div id="LosComentarios">

                        </div>
                        <div>
                            <input type="text" class="form-control" id="Input-Comentar">
                            <br>
                            <button id="btn-Comentar" class="btn btn-success">Dejar Comentario</button>
                            <hr>
                            <input type="number" class="form-control" id="Input-Calificar" disabled>
                            <br>
                            <button id="btn-Calificar" class="btn btn-success" disabled>Calificar Producto</button>

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-lg-3 -->
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
        var token = localStorage.getItem("token");

        let searchParams = new URLSearchParams(window.location.search) //Busca si fue mandado algun parametro
        var idDelProd = searchParams.get('idProd'); //Revisa el valor del id del curso
        getInfoProd(idDelProd);

        function getInfoProd(param) {
            debugger
            $.ajax({
                url: urlglobal.url + "/getProduct/" + param,
                async: true,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'Authorization': token
                },
                success: function(datos) {

                    debugger
                    var html = '<div>';
                    html += '<img width="500" height="600" class="card-img-top" src="' + datos.image + '" alt="">';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h3 class="card-title">' + datos.name + '</h3>';
                    html += '<h4> Precio: $' + datos.price + '</h4>';
                    html += '<p class="card-text">' + datos.description + '</p>';
                    html += '</div>';
                    $('#cursoData').append(html);

                },
                error: function(datos) {
                    console.log(datos);
                    debugger
                    alert("Error con los cursos mas recientes");
                }
            })
        };
        $('#ComprarCurso').on('click', (event) => {
            AgregaEnCarrito();
        });
        $('#btn-Comentar').on('click', (event) => {
            if ($('#Input-Comentar').val() != "") {

                debugger
                var html = '<p>' + $('#Input-Comentar').val() + '</p>';
                html += '<small class="text-muted">Posted by Usuario</small>';
                html += '<hr>';
                $('#LosComentarios').append(html);

            }
        });

        function AgregaEnCarrito(idDelCurso) {
            var cart = {
                productId: idDelProd,
                cantidad: 1
            };

            var dataToSendJson = JSON.stringify(cart);
            debugger
            $.ajax({
                url: urlglobal.url + "/addToCart",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'Authorization': token
                },
                success: function(data) {
                    console.log(data);
                    debugger
                    alert("Curso agregado al Carrito");
                    $('#ComprarCurso').attr("disabled", true);
                },
                error: function(data) {
                    console.log(data);
                    debugger
                    alert("Error agregando al Carrito");
                }
            });

        };

    });
</script>

</html>