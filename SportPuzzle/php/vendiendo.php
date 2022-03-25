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
    <link rel="stylesheet" href="../css/modsVendiendo.css">
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <br>

    <h1 style="text-align: center;">Mi Carrito</h1>

    <div id="insertarAlCarro" class="container" style="margin-top: 40px;">

    </div>
    <br>
    <div class="container">
        <button id="APagar" type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#exampleModalCenter">Comprar</button>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPrize"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="NumeroTarjeta" class="form-label">Numero de Tarjeta</label>
                        <input type="text" class="form-control" id="NumeroTarjeta">
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label for="MesTarjeta" class="form-label">Mes</label>
                            <input type="text" class="form-control" id="MesTarjeta">
                        </div>
                        <div class="col-4">
                            <label for="AñoTarjeta" class="form-label">Año</label>
                            <input type="text" class="form-control" id="AñoTarjeta">
                        </div>
                        <div class="col-4">
                            <label for="CCVTarjeta" class="form-label">CCV</label>
                            <input type="text" class="form-control" id="CCVTarjeta">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="TitularTarjeta" class="form-label">Titular de la tarjeta</label>
                        <input type="text" class="form-control" id="TitularTarjeta">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="PagarFinal" type="button" class="btn btn-primary" id="btn-crearcategoria" data-dismiss="modal">Pagar</button>
                </div>
            </div>
        </div>
    </div>
    <br>
</body>
<!-- Si son 3 cursos, cambiar el position del footer a relative -->
<?php
include 'footer.php';
?>
<script type="module">
    import {
        urlglobal
    } from '../Js/urlglobal.js'
    var cursosarray = [];
    $(document).ready(function() {
        var idactual = <?php echo $_SESSION['id_usuario'] ?>;
        getCarritoPersona(idactual);
        var preciototal = 0;

        function getCarritoPersona(param) {
            var dataToSend = {
                iduser: param
            };
            var dataToSendJson = JSON.stringify(dataToSend);

            debugger
            $.ajax({
                url: urlglobal.url + "/getCarritoPersona",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    cursosarray = [];
                    cursosarray = datos;
                    debugger
                    var muestrame = Object.keys(datos).length; //Obtienes el numero
                    if (muestrame > 0) {
                        if (muestrame >= 3) {
                            document.getElementById("footer").style.position = "relative";
                        }
                        debugger
                        for (let dato of datos) {
                            preciototal += parseInt(dato.PrecioCurso);
                            var html = '<a class="" style="text-decoration: none; color: black;">';
                            html += '<div class="card mb-3" style="max-width: 1200px;">';
                            html += '<div class="row ">';
                            html += '<div class="col-md-4">';
                            html += '<img height="197" src="' + dato.FotoCurso + '" class="card-img" alt="...">';
                            html += '</div>';
                            html += '<div class="col-md-4">';
                            html += '<div class="card-body">';
                            html += '<h5 class="card-title">' + dato.NombreCurso + '</h5>';
                            html += '<p class="card-text">' + dato.DescripcionCurso + '</p>';
                            html += '<p class="card-text"><small class="text-muted"> Precio: $' + dato.PrecioCurso + '</small></p>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="col-md-4 ">';
                            html += '<div class="card-body ">';
                            html += '<button class="btn btn-primary buttondelete" valor="' + dato.id_carrito + '" >Eliminar</button>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';

                            $('#insertarAlCarro').append(html);
                        }
                        $('#APagar').removeAttr("disabled");
                        document.getElementById("exampleModalPrize").innerHTML = "Total a Pagar: $" + preciototal;
                    } else {
                        $('#APagar').attr("disabled", true);
                    }

                },
                error: function() {
                    alert("Error agregando al carro");
                }

            });
        };
        $("body").on("click", ".buttondelete", function() {
            let dalepapu = $(this).attr("valor");
            EliminaCursoCarro(dalepapu);
        });
        $("body").on("click", "#PagarFinal", function() {
            var NumeroTarjeta = $('#NumeroTarjeta').val();
            var MesTarjeta = $('#MesTarjeta').val();
            var AñoTarjeta = $('#AñoTarjeta').val();
            var CCVTarjeta = $('#CCVTarjeta').val();
            var TitularTarjeta = $('#TitularTarjeta').val();
            if (NumeroTarjeta != "" && MesTarjeta != "" && AñoTarjeta != "" &&
                CCVTarjeta != "" && TitularTarjeta != "") {
                $('#NumeroTarjeta').val("");
                $('#MesTarjeta').val("");
                $('#AñoTarjeta').val("");
                $('#CCVTarjeta').val("");
                $('#TitularTarjeta').val("");
                AgregarContratado();
            } else {
                alert("Asegurate que los datos esten completos");
            }
        });

        function EliminaCursoCarro(param) {
            var dataToSend = {
                id_carrito: param
            };
            var dataToSendJson = JSON.stringify(dataToSend);

            debugger

            $.ajax({
                url: urlglobal.url + "/EliminaCursoCarro",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    let carro = document.getElementById('insertarAlCarro'); //limpias el chat de con quien chateas
                    while (carro.firstChild) {
                        carro.removeChild(carro.firstChild);
                    }
                    preciototal = 0;

                    getCarritoPersona(idactual);
                    debugger

                },
                error: function() {
                    alert("Error eliminando del carro");
                    debugger
                }

            });
        };

        function AgregarContratado() {
            var muestrame = cursosarray.length;
            var salimos = 0;
            debugger
            for (let i = 0; i < muestrame; i++) {
                var dataToSend = {
                    cursoid: cursosarray[i].cursoid,
                    usuarioid: cursosarray[i].usuarioid
                };
                var dataToSendJson = JSON.stringify(dataToSend);

                debugger

                var promise = $.ajax({
                    url: urlglobal.url + "/AgregaContrata",
                    async: true,
                    type: 'POST',
                    data: dataToSendJson,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(datos) {
                        salimos += 1;
                    },
                    error: function() {
                        alert("Error contratando curso");
                        debugger
                    }
                });
                promise.then(() => {
                    if (salimos = muestrame) {
                        let carro = document.getElementById('insertarAlCarro'); //limpias el chat de con quien chateas
                        while (carro.firstChild) {
                            carro.removeChild(carro.firstChild);
                        }
                        preciototal = 0;
                        getCarritoPersona(idactual);
                    }
                });
            };


        }

    });
</script>

</html>