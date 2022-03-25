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

            <div class="col-lg-6 border-right border-left">
                <h2>CURSOS COMPLETADOS</h2>
                <hr>
                <div class="cursos" id="izquierda">
                </div>
            </div>
            <div class="col-lg-6 border-right">
                <h2>CURSOS EN PROCESO</h2>
                <hr>
                <div class="cursos" id="derecha">
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
        var nombreactual = <?php echo json_encode($_POST["searchUser"]); ?>;
        var usuario = new Usuario(null, null, nombreactual, null, null, null, null, null, null);
        BuscaUser(usuario);
        function BuscaUser(Usuario) {
            // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
            var ExisteFlag = false;
            var idUsuarioBuscado;
            var dataToSend = {
                usuario: Usuario.nombreUsuario
            };
            var dataToSendJson = JSON.stringify(dataToSend);
            var promise = $.ajax({
                url: urlglobal.url + "/getUserByUsername",
                async: true,
                type: 'POST',
                data: dataToSendJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    debugger
                    let rolsito;
                    idUsuarioBuscado = data.id_usuario;
                    let rol = parseInt(data.rol);
                    if (rol > 0) {
                        rolsito = "Escuela";
                    } else {
                        rolsito = "Alumno";
                    }
                    var html = '<h1>' + data.usuario + '</h1>';
                    html += '<br>';
                    html += '<h1>' + data.nombre + ' ' + data.apellidos + '</h1>';
                    html += '<h2>' + rolsito + '</h2>';
                    html += '<br>';
                    html += '<hr>';
                    $('#Banner').append(html);
                },
                error: function() {
                    alert("El usuario que buscas no existe");
                    window.location.href = "index.php";
                }
            });
            promise.then(() => {
                var dataToSend2 = {
                    usuarioid: idUsuarioBuscado
                };
                var dataToSendJson2 = JSON.stringify(dataToSend2);
                var promise = $.ajax({
                    url: urlglobal.url + "/getCursosContratados",
                    async: true,
                    type: 'POST',
                    data: dataToSendJson2,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(datos) {
                        var muestrame = Object.keys(datos).length; //Obtienes el numero de cursos
                        if (muestrame > 0) {
                            for (let dato of datos) {
                                let suprogreso = parseInt(dato.progreso);
                                if (suprogreso >= 100) {
                                    debugger
                                    var html = '<div class="border-bottom text-center">';
                                    html += '<br>';
                                    html += '<h4>' + dato.Nombrecurso + '</h4>';
                                    html += '<br>';
                                    html += '<div class="progress" style="height: 20px;">';
                                    html += '<div class="progress-bar bg-success" role="progressbar" style="width: 100%;">100%</div>';
                                    html += '</div>';
                                    html += '<br>';
                                    html += '</div>';
                                    $('#izquierda').append(html);
                                } else {
                                    debugger
                                    var html = '<div class="border-bottom text-center">';
                                    html += '<br>';
                                    html += '<h4>' + dato.Nombrecurso + '</h4>';
                                    html += '<br>';
                                    html += '<div class="progress" style="height: 20px;">';
                                    html += '<div class="progress-bar" role="progressbar" style="width: '+suprogreso+'%;">'+suprogreso+'%</div>';
                                    html += '</div>';
                                    html += '<br>';
                                    html += '</div>';
                                    $('#derecha').append(html);
                                }
                            }
                        }
                    },
                    error: function() {                        
                    }
                });

            });
        }
    });
</script>

</html>