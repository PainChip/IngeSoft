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
                    <input id="Email" type="text" placeholder="Email">
                    <input id="Contra" type="password" placeholder="Contraseña">
                    <button id="btnentra">Entrar</button>

                </form>

                <form action="" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input id="User" type="text" placeholder="Username">
                    <input id="Name" type="text" placeholder="Nombre completo">
                    <input id="Email2" type="email" placeholder="Email">
                    <input id="Contra2" type="password" placeholder="Contraseña">

                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected>Elige el tipo de usuario.</option>
                        <option value="USER">Usuario</option>
                        <option value="ADMIN">Administrador</option>
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

            $(".formulario__register").submit(function(e) {
                e.preventDefault();
            });
            $(".formulario__login").submit(function(e) {
                e.preventDefault();
            });
            $('#btnentra').click(async function() {
                var emailData = $('#Email').val();
                var passwordData = $('#Contra').val();

                if (emailData == "" || passwordData == "") {
                    alert("Datos incompletos");
                } else {
                    var dataToSend = {
                        email: $('#Email').val(),
                        password: $('#Contra').val(),
                        "gettoken": true
                    };
                    var dataAjax = JSON.stringify(dataToSend);
                    var tokenData = "";
                    var usernameData = "";
                    var roleData = ""
                    var bandera = false;
                    var respuesta = $.ajax({
                        url: urlglobal.url + "/authUser",
                        async: true,
                        type: 'POST',
                        data: dataAjax,
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function(response) {
                            console.log(response);
                            if (response === undefined) {
                                alert("Este usuario no se pudo identificar.");
                            } else {
                                tokenData = response.token;
                                roleData = response.role;
                                usernameData = response.username;
                                bandera = true;
                            }
                        },
                        error: function(x, y, z) {
                            alert("Contraseña incorrecta");
                        }
                    });
                    debugger

                    respuesta.then(() => {
                        if (bandera) {
                            var parametros = {
                                "token": tokenData,
                                "correo": emailData,
                                "rol": roleData,
                                "username": usernameData
                            };
                            debugger
                            $.ajax({
                                type: "POST",
                                url: "SessionSet.php",
                                data: parametros,
                                cache: false,
                                success: function(data) {
                                    if (data === 'True') {
                                        alert("Accion Realizada correctamente");
                                        localStorage.setItem("token", tokenData);
                                        debugger
                                        window.location.assign("index.php");
                                    }
                                }
                            });

                        }
                    });


                }
            });

            $('#btnregistra').click(async function() {
                var roleData = $('#inputGroupSelect01').val();
                var nickData = $('#User').val();
                var nameData = $('#Name').val();
                var emailData = $('#Email2').val();
                var passwordData = $('#Contra2').val();
                if (roleData == "" ||roleData == "Elige el tipo de usuario." || nickData == "" || nameData == "" || emailData == "" || passwordData == "") {
                    alert("Datos incompletos");
                } else {
                    if (validar_clave(passwordData)) {
                        var userData = {
                            role: roleData,
                            nickName: nickData,
                            fullName: nameData,
                            email: emailData,
                            password: passwordData
                        };
                        await sendUser(userData);
                    } else {
                        alert("Contraseña no aceptada");
                    }
                }
            });

            function sendUser(Usuario) {
                var dataAjax = JSON.stringify(Usuario);
                $.ajax({

                    url: urlglobal.url + "/createUser",
                    async: true,
                    type: 'POST',
                    data: dataAjax,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(data) {
                        window.location.reload();
                    },
                    error: function(x, y, z) {
                        alert("Error en webservice: " + x + y + z);
                    }
                });
            }

            function validar_clave(contrasenna) {
                if (contrasenna.length >= 8) {
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