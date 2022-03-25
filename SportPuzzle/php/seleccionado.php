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
    <link rel="stylesheet" href="../css/modsSeleccionado.css">

    <script type="text/javascript" src="../Js/modelosJS/carrito.js"></script>
    <script type="text/javascript" src="../Js/modelosJS/leccion.js"></script>
    <script type="text/javascript" src="../Js/modelosJS/contrata.js"></script>
    <script type="text/javascript" src="../Js/modelosJS/comentario.js"></script>

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
                        <button id="ComprarCurso" class="btn btn-success" style="margin-right:15px;" disabled>Añadir al carrito</button>
                        <button id="CursoCertificado" class="btn btn-success" style="margin-right:15px;" disabled>Obtener Certificado</button>
                        <button id="CompartirCurso" class="btn btn-success">Compartir</button>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                    <div class="card-header"> Comentarios </div>
                    <div class="card-body">
                        <div id="LosComentarios">

                        </div>
                        <div>
                            <input type="text" class="form-control" id="Input-Comentar" disabled>
                            <br>
                            <button id="btn-Comentar" class="btn btn-success" disabled>Dejar Comentario</button>
                            <hr>
                            <input type="number" class="form-control" id="Input-Calificar" disabled>
                            <br>
                            <button id="btn-Calificar" class="btn btn-success" disabled>Calificar Curso</button>

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-lg-3">
                <h1 class="my-4">Lecciones</h1>
                <div id="laslecciones" class="list-group">
                </div>
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

    var SeleccionoLeccion = false; //True significa que si esta contratado, podemos traer lecciones
    var queLeccionEs;
    var LeccionesVistas;

    $(document).ready(function() {
        let searchParams = new URLSearchParams(window.location.search) //Busca si fue mandado algun parametro
        var idDelCurso = searchParams.get('idcurso'); //Revisa el valor del id del curso
        getInfoCurso(idDelCurso);

        // Revisa si esta logueado, en caso de que si, se agrega la funcionalidad
        <?php
        if (isset($_SESSION['id_usuario'])) { ?>

            var idactual = <?php echo $_SESSION['id_usuario'] ?>;
            var nombreactual = <?php echo json_encode($_SESSION['nombre']) ?>;
            var CarritoData = new Carrito(null, idDelCurso, idactual)
            RevisaCarro(CarritoData);
        <?php } ?>

        function getInfoCurso(param) {
            var dataToSend = {
                id_curso: param
            };
            var dataToSendJson = JSON.stringify(dataToSend);

            debugger
            $.ajax({
                url: urlglobal.url + "/getInfoCurso",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {

                    debugger
                    var html = '<div class="embed-responsive embed-responsive-16by9">';
                    html += '<video  controls><source src="' + datos.video + '" type="video/mp4"></video>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h3 class="card-title">' + datos.nombre + '</h3>';
                    html += '<h4> Precio: $' + datos.costo + '</h4>';
                    html += '<p class="card-text">' + datos.descripcion + '</p>';
                    html += '</div>';
                    $('#cursoData').append(html);
                    getComentarios(idDelCurso);

                },
                error: function() {
                    alert("Error con los cursos mas recientes");
                }
            })
        };
        $('#ComprarCurso').on('click', (event) => {
            AgregaEnCarrito(idDelCurso);
        });
        $('#btn-Comentar').on('click', (event) => {
            if ($('#Input-Comentar').val() != "") {

                debugger
                var elComentario = new ComentarioCurso(null, idDelCurso, $('#Input-Comentar').val(), idactual)
                $('#Input-Comentar').val("");
                AgregaComentario(elComentario);

            }
        });
        $('#btn-Calificar').on('click', (event) => {
            if ($('#Input-Calificar').val() != "") {
                let calificacion = parseInt($('#Input-Calificar').val());
                if (calificacion > 0 && calificacion <= 100) {
                    debugger
                    var CalificacionData = new Contrata(null, idactual, idDelCurso, calificacion, null)
                    $('#Input-Calificar').val("");
                    CalificaCurso(CalificacionData);
                }
            }
        });

        $('#CursoCertificado').on('click', (event) => {
            window.location.href = "../Diplomaservice/DiplomaGenerate.php?user=" + nombreactual;
        });
        $("body").on("click", ".botonLeccion", function() {
            queLeccionEs = $(this).attr("idLeccion");
            debugger
            SeleccionoLeccion = true;
            RevisaSiYaTienesLasLecciones(idDelCurso);
        });

        function RevisaCarro(CarritoData) {
            var muestrame;
            var dataToSend = {
                cursoid: CarritoData.cursoid,
                usuarioid: CarritoData.usuarioid
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/getRevisaCarrito",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    muestrame = Object.keys(data).length; //Obtienes el numero de cursos
                    if (muestrame > 0) {
                        debugger
                        alert("Este curso ya esta en el carrito");
                    }
                },
                error: function() {
                    debugger
                    alert("Error revisando el Carrito");
                }
            });
            promise.then(() => {
                $.ajax({
                    url: urlglobal.url + "/RevisaEstaContratado",
                    async: true,
                    type: 'POST',
                    data: dataToSendJson,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(data) {
                        debugger
                        let numero = parseInt(data.resultado);
                        if (numero > 0) {
                            debugger
                            // alert("Este curso ya esta contratado");
                            getLeccionesCurso(idDelCurso);
                            $('#btn-Calificar').removeAttr("disabled");
                            $('#Input-Comentar').removeAttr("disabled");
                            $('#Input-Calificar').removeAttr("disabled");
                            $('#btn-Comentar').removeAttr("disabled");

                        } else {
                            if (muestrame == 0) {
                                debugger
                                $('#ComprarCurso').removeAttr("disabled");

                            }
                        }

                    },
                    error: function() {
                        debugger
                        alert("Error revisando Contratacion");
                    }
                });
            });
        };

        function AgregaEnCarrito(idDelCurso) {
            var dataToSend = {
                cursoid: idDelCurso,
                usuarioid: idactual
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            $.ajax({
                url: urlglobal.url + "/addCarrito",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    debugger
                    alert("Curso agregado al Carrito");
                    $('#ComprarCurso').attr("disabled", true);
                },
                error: function() {
                    debugger
                    alert("Error agregando al Carrito");
                }
            });

        };

        function getLeccionesCurso(idDelCurso) {
            var dataToSend = {
                cursoid: idDelCurso
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/getLeccionesCurso",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    for (let dato of datos) {
                        debugger
                        var html = '<button class="list-group-item botonLeccion" idLeccion="' + dato.id_leccion + '">' + dato.nombre + '</button>';
                        $('#laslecciones').append(html);
                    }
                },
                error: function() {
                    debugger
                    alert("Error trayendo lecciones");
                }
            });
            promise.then(() => {
                RevisaSiYaTienesLasLecciones(idDelCurso);
            });
        };

        function RevisaSiYaTienesLasLecciones(idDelCurso) {
            var dataToSend2 = {
                usuarioid: idactual, //IdDelUsuarioQueVasARevisar
                cursoid: idDelCurso //IdDelCursoARevisar
            };
            var dataToSendJson2 = JSON.stringify(dataToSend2);
            debugger
            var promise2 = $.ajax({
                url: urlglobal.url + "/RevisaSiYaTienesLasLecciones",
                async: true,
                type: 'POST',
                data: dataToSendJson2,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    let numero = parseInt(data.resultado);
                    if (numero > 0) {
                        LeccionesVistas = 1; //significa que ya completo el curso
                        $('#CursoCertificado').removeAttr("disabled");
                        debugger
                    } else {
                        LeccionesVistas = 20; //le faltan lecciones
                        // alert("Todavia no completa el curso")
                        debugger
                    }

                },
                error: function() {
                    alert("Error revisando");
                }
            });
            promise2.then(() => {
                debugger
                if (SeleccionoLeccion) { //Selecciono una leccion, vamos a darle la info
                    let cursitoData = document.getElementById('cursoData');
                    while (cursitoData.firstChild) {
                        cursitoData.removeChild(cursitoData.firstChild);
                    }
                    var dataToSend = {
                        leccionid: queLeccionEs
                    };
                    var dataToSendJson = JSON.stringify(dataToSend);
                    debugger
                    var promise3 = $.ajax({
                        url: urlglobal.url + "/getLeccionEspecifica",
                        async: true,
                        type: 'POST',
                        data: dataToSendJson,
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function(datos) {
                            debugger
                            var html = '<div class="embed-responsive embed-responsive-16by9">';
                            html += '<video controls><source src="' + datos.video + '" type="video/mp4"></video>';
                            html += '</div>';
                            html += '<div class="card-body">';
                            html += '<h3 class="card-title">' + datos.nombre + '</h3>';
                            html += '<p class="card-text">' + datos.extra + '</p>';
                            html += '<h2 class="udlite-heading-xl styles--audience__title--1Sob_">Archivo asociado</h2>';
                            html += '<ul class="styles--audience__list--3NCqY">';
                            html += '<li>';
                            html += '<a href="' + datos.archivo + '" download="Archivo">Prueba 1</a>';
                            html += '</li>';
                            html += '</ul>';
                            html += '</div>';
                            $('#cursoData').append(html);
                        },
                        error: function() {
                            debugger
                            alert("Error trayendo la leccion");
                        }
                    });
                    promise3.then(() => {
                        if (LeccionesVistas > 10) {
                            var dataToSend3 = {
                                usuarioid: idactual, //IdDelUsuarioQueVasARevisar
                                cursoid: idDelCurso //IdDelCursoARevisar
                            };
                            var dataToSendJson3 = JSON.stringify(dataToSend3);
                            debugger
                            var promise3 = $.ajax({
                                url: urlglobal.url + "/aumentaSuProgreso",
                                async: true,
                                type: 'POST',
                                data: dataToSendJson3,
                                dataType: 'json',
                                contentType: 'application/json; charset=utf-8',
                                success: function(data) {
                                    alert("ProgresoAumentado");
                                },
                                error: function() {
                                    alert("Error aumentando contador");
                                }
                            });
                        }

                    });

                }
            });

        }

        function getComentarios(idDelCurso) {
            var dataToSend2 = {
                cursoid: idDelCurso //IdDelCursoARevisar
            };
            var dataToSendJson2 = JSON.stringify(dataToSend2);
            debugger
            var promise2 = $.ajax({
                url: urlglobal.url + "/getComentarios",
                async: true,
                type: 'POST',
                data: dataToSendJson2,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    let comentarios = document.getElementById('LosComentarios'); //limpias el chat de con quien chateas
                    while (comentarios.firstChild) {
                        comentarios.removeChild(comentarios.firstChild);
                    }

                    for (let dato of datos) {
                        var html = '<p>' + dato.comentario + '</p>';
                        html += '<small class="text-muted">Posted by ' + dato.NombreUsuario + '</small>';
                        html += '<hr>';
                        $('#LosComentarios').append(html);
                    }
                },
                error: function() {
                    alert("Error revisando");
                }
            });
        }

        function CalificaCurso(CalificacionData) {
            var dataToSend2 = {
                usuarioid: CalificacionData.usuarioid, //IdDelUsuarioQueVasARevisar
                cursoid: CalificacionData.cursoid, //IdDelCursoARevisar
                calificacion: CalificacionData.calificacioncurso //elComentario
            };
            var dataToSendJson2 = JSON.stringify(dataToSend2);
            debugger
            $.ajax({
                url: urlglobal.url + "/CalificaCurso",
                async: true,
                type: 'POST',
                data: dataToSendJson2,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    alert("La calificacion " + CalificacionData.calificacioncurso + " fue ingresada");
                },
                error: function() {
                    alert("Error comentando");
                }
            });
        }

        function AgregaComentario(ComentarioData) {
            var dataToSend2 = {
                usuid: ComentarioData.usuid, //IdDelUsuarioQueVasARevisar
                cursoid: ComentarioData.cursoid, //IdDelCursoARevisar
                comentario: ComentarioData.comentario //elComentario
            };
            var dataToSendJson2 = JSON.stringify(dataToSend2);
            debugger
            $.ajax({
                url: urlglobal.url + "/addComentario",
                async: true,
                type: 'POST',
                data: dataToSendJson2,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    debugger
                    getComentarios(idDelCurso);
                },
                error: function() {
                    alert("Error comentando");
                }
            });
        }

        ///////////////////////////////////// FACEBOOK  ////////////////////////////////////
        window.fbAsyncInit = function() {
            FB.init({
                appId: '3496486320412131',
                xfbml: true,
                version: 'v9.0'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        ////Compartir Puntuacion
        function shareCourse() {
            FB.ui({
                method: 'share',
                href: 'http://157.245.215.151/Progra-Web-de-Capa-Intermedia/CurSOS/',
                hashtag: '#CurSOS',
                quote: "Soy " + nombreactual + " y me gusto este curso, esta padre!"
            }, function(response) {});
        }
        $('#CompartirCurso').on('click', (event) => {
            shareCourse();
        });

        ///////////////////////////////////// FACEBOOK  ////////////////////////////////////


    });
</script>

</html>