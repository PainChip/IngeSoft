<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/Logo.png">
    <title>Login</title>
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsLogin.css" />
    <script type="text/javascript" src="../Js/modelosJS/user.js"></script>
</head>

<body>
    <br>
    <div class="container" style="margin-top: 100px;">

        <div class="contenedortodo">

            <div class="cajatrasera">

                <div class="cajatrasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar sesión</button>
                </div>

                <div class="cajatrasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>

            </div>
            <div class="contenedor__login-register">
                <form action="" class="formulario__login">
                    <h2>Iniciar sesión</h2>
                    <input id="User" type="text" placeholder="Username">
                    <input id="Contra" type="password" placeholder="Contraseña">
                    <button id="btnentra">Entrar</button>

                </form>

                <form action="" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input id="User2" type="text" placeholder="Username">
                    <input id="Name" type="text" placeholder="Nombre">
                    <input id="Apellidos" type="text" placeholder="Apellidos">
                    <input id="Email" type="email" placeholder="Email">
                    <input id="Contra2" type="password" placeholder="Contraseña">

                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected>Elige el tipo de usuario.</option>
                        <option value="false">Alumno</option>
                        <option value="true">Escuela</option>
                    </select>

                    <button id="btnregistra">Registrarse</button>

                </form>

            </div>
        </div>

    </div>
    <script src="../Js/JsLogin.js"></script>
    <script type="module">
        import {
            urlglobal
        } from '../Js/urlglobal.js'

        $(document).ready(function() {
            var listProducts = [];
            var comosalio = 0;
            $(".formulario__register").submit(function(e) {
                e.preventDefault();
            });
            $(".formulario__login").submit(function(e) {
                e.preventDefault();
            });
            $('#btnentra').click(function() {
                //idUsuario, rolUsuario, nombreUsuario, nombreReal, apellidoUsuario, correoUsuario, contraUsuario, avatarUsuario, activoUsuario
                var usuario = new Usuario(null, null,$('#User').val(), null, null, null, $('#Contra').val(), null, null);
                
                getUser(usuario);
                
            });
            $('#btnregistra').click(function() {
                var usuario = new Usuario(null,  $('#inputGroupSelect01').val(), $('#User2').val(), $('#Name').val(), $('#Apellidos').val(), $('#Email').val(), $('#Contra2').val(),null,null);
                var contra = $('#Contra2').val();
                if(validar_clave(contra)){
                    sendUser(usuario);
                }else{
                    alert("La contraseña no aceptada");
                }            

            });

            function getUser(Usuario) {
                // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
                var dataToSend = {
                    usuario: Usuario.nombreUsuario,
                    contra: Usuario.contraUsuario,
                };
                var aver = JSON.stringify(dataToSend);
                debugger
                $.ajax({
                    url: urlglobal.url + "/getUserByUsuarioContra",
                    async: true,
                    type: 'POST',
                    data: aver,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function() {
                        alert("Logueado correctamente");
                        window.location.assign("index.php");
                    },
                    error: function(x, y, z) {
                        alert("Contraseña incorrecta");

                    }
                });
            }

            function sendUser(Usuario) {
                // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
                var dataToSend = {

                    usuario: Usuario.nombreUsuario,
                    nombre: Usuario.nombreReal,
                    apellidos: Usuario.apellidoUsuario,
                    correo: Usuario.correoUsuario,
                    contra: Usuario.contraUsuario,
                    rol: Usuario.rolUsuario

                };
                var aver = JSON.stringify(dataToSend);
                $.ajax({
                    url: urlglobal.url + "/addUser",
                    async: true,
                    type: 'POST',
                    data: aver,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function() {
                        alert("Se registro correctamente");
                        window.location.reload();
                    },
                    error: function(x, y, z) {
                        alert("Error en webservice: " + x + y + z);
                    }
                });
            }

            function validar_clave(contrasenna) {
                if (contrasenna.length >= 8) {
                    debugger
                    var mayuscula = false;
                    var minuscula = false;
                    var numero = false;
                    var caracter_raro = false;

                    for (var i = 0; i < contrasenna.length; i++) {
                        if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
                            mayuscula = true;
                        } else if (contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122) {
                            minuscula = true;
                        } else if (contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57) {
                            numero = true;
                        } else {
                            caracter_raro = true;
                        }
                    }
                    if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true) {
                        return true;
                    }
                }
                return false;
            }
        });
    </script>
</body>

</html>