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


    <link rel="stylesheet" href="../css/modsMensajes.css" />
    <script type="text/javascript" src="../Js/modelosJS/message.js"></script>

</head>


<body>
    <?php
    include 'navbar.php';
    ?>
    <br>


    <div class="recuadro">
        <div id="chat-container">

            <div id="search-container">
                <!-- <input type="text" placeholder="Search" /> -->
            </div>
            <!-- PersonasConlasqueHasChateado -->
            <div id="conversation-list">
                <div class="conversation active">

                    <div class="title-text">Carlos</div>
                </div>
                <div class="conversation">

                    <div class="title-text">Rodrigo</div>
                </div>
            </div>
            <!-- PersonasConlasqueHasChateado -->
            <div id="new-message-container">
                <a id="nuevouser" href="">+</a>
            </div>

            <div id="chat-title"></div>
            <!-- Mensajes de la conversacion -->
            <div id="chat-message-list">
                <div class="message-row you-message">
                    <div class="message-text">Hola</div>

                </div>
                <div class="message-row other-message">
                    <div class="message-text">Hola</div>
                </div>
            </div>
            <!-- Mensajes de la conversacion -->
            <div id="chat-form">
                <img src="https://pic.onlinewebfonts.com/svg/img_375473.png" alt="Añadir Archivo" width="30px">
                <input id="MensajeAEnviar" type="text" placeholder="Escribe un mensaje">
            </div>


        </div>

    </div>
    <br>
</body>

<script type="module">
    import {
        urlglobal
    } from '../Js/urlglobal.js'

    $(document).ready(function() {
        var banderaentro = false;
        var idactual = <?php echo $_SESSION['id_usuario'] ?>;
        var elusuario = "<?php echo $_SESSION['usuario'] ?>";
        var usuario = new Mensaje(null, idactual, null, null);
        var usuario2 = new Mensaje(null, null, null, null);
        var resultado;
        var nombrecito;
        //Prompt Nuevo Usuario
        $("body").on("click", "#nuevouser", function() {
            var retVal = prompt("Ingrese el nombre de usuario : ", "");
            if (retVal != null) {
                TraerIdUsuario(retVal);
                event.preventDefault();
                setTimeout(() => {
                    debugger
                    if (resultado != null) {
                        var retVal2 = prompt("Ingrese el mensaje : ", "your message");
                        if (retVal2 != null) {

                            usuario2.idUsuario = idactual;
                            usuario2.idUsuario2 = resultado;
                            usuario2.mensajito = retVal2
                            debugger
                            MandarMensaje(usuario2);
                            debugger
                            window.location.reload();
                        }

                    } else {
                        alert("Este Usuario no existe");
                    }

                }, 2000);
                banderaentro = true;
            }
        });
        //Buscas los chats que tienes
        function testCallBack() {
            BuscaChats(usuario);

            setTimeout(() => {
                nombrecito = $(".conversation.active").children("div").text(); //obtienes el username
                debugger
                testCallBack2();

            }, 2000);
        }
        $("body").on("click", ".conversation", function() {
            $('.conversation.active').attr("class", "conversation"); //eliminas chat activo
            let mensajes = document.getElementById('chat-message-list'); //limpias el chat de mensajes
            while (mensajes.firstChild) {
                mensajes.removeChild(mensajes.firstChild);
            }
            $(this).attr("class", "conversation active"); //conviertes activo el que seleccionaste
            nombrecito = $(this).children("div").text(); //obtienes el username del que seleccionaste
            testCallBack2();

        });
        $("body").on("click", "img", function() {
            usuario2.mensajito = document.getElementById("MensajeAEnviar").value;
            usuario2.idUsuario2 = resultado;
            debugger
            MandarMensaje(usuario2);
            $("#MensajeAEnviar").val('');
            let mensajes = document.getElementById('chat-message-list'); //limpias el chat de mensajes
            while (mensajes.firstChild) {
                mensajes.removeChild(mensajes.firstChild);
            }
            testCallBack2();
            debugger
        });

        function testCallBack2() {
            TraerIdUsuario(nombrecito);
            debugger
            setTimeout(() => {
                usuario2.idUsuario = idactual;
                usuario2.idUsuario2 = resultado;
                if (resultado != null) {
                    debugger
                    TraerMensajes(usuario2);
                }

            }, 2000);

        }

        debugger
        if (!banderaentro) {
            testCallBack();
        }




        //Pones los mensajes del chat activo
        function BuscaChats(Mensaje) {
            // Objeto en formato JSON el cual le enviaremos al webservice (PHP)
            var dataToSend = {
                idusuario: Mensaje.idUsuario
            };
            var aver = JSON.stringify(dataToSend);
            $.ajax({
                url: urlglobal.url + "/getPersonasChateas",
                async: true,
                type: 'POST',
                data: aver,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    let mensajes = document.getElementById('conversation-list'); //limpias el chat de con quien chateas
                    while (mensajes.firstChild) {
                        mensajes.removeChild(mensajes.firstChild);
                    }
                    let mensajes2 = document.getElementById('chat-message-list'); //limpias el chat de mensajes
                    while (mensajes2.firstChild) {
                        mensajes2.removeChild(mensajes2.firstChild);
                    }
                    var muestrame = Object.keys(data).length; //Obtienes el numero de chats
                    for (var i = 0; i < muestrame; i++) {
                        if (i == 0) { //el primero
                            // build the new query
                            var html = '<div class="conversation active">';
                            html += '<img src="" width="40px" alt="" style="opacity: 0;" />';
                            html += '<div class="title-text">' + data[i].usuario + '</div>';
                            html += '</div>';
                            $('#conversation-list').append(html);

                        } else {
                            var html = '<div class="conversation">';
                            html += '<img src="" width="40px" alt="" style="opacity: 0;" />';
                            html += '<div class="title-text">' + data[i].usuario + '</div>';
                            html += '</div>';
                            $('#conversation-list').append(html);
                        }

                    }
                },
                error: function(x, y, z) {
                    alert("Error en webservice: " + x + y + z);
                }
            });
        }

        function TraerMensajes(Mensaje) {
            var dataToSend = {
                idusuario: Mensaje.idUsuario,
                idusuario2: Mensaje.idUsuario2
            };
            var aver = JSON.stringify(dataToSend);
            $.ajax({
                url: urlglobal.url + "/getChatEntero",
                async: true,
                type: 'POST',
                data: aver,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    var muestrame = Object.keys(data).length; //Obtienes el numero de mensajes
                    for (var i = 0; i < muestrame; i++) {
                        if (data[i].usuario == elusuario) { //de ser iguales, el es quien envio el mensaje
                            // agrega el html del mensaje 
                            var html = '<div class="message-row you-message">';
                            html += '<div class="message-text">' + data[i].mensaje + '</div>';
                            html += '</div>';
                            $('#chat-message-list').append(html);

                        } else { //de no serlo, el es quien recibio el mensaje
                            // agrega el html del mensaje
                            var html = '<div class="message-row other-message">';
                            html += '<div class="message-text">' + data[i].mensaje + '</div>';
                            html += '</div>';
                            $('#chat-message-list').append(html);
                        }

                    }
                },
                error: function(x, y, z) {
                    alert("Error en webservice: " + x + y + z);
                }
            });
        }

        function TraerIdUsuario(nombreuser) {

            var dataToSend = {
                username: nombreuser
            };
            var aver = JSON.stringify(dataToSend);
            $.ajax({
                url: urlglobal.url + "/TraerIDPersonaChateas",
                async: true,
                type: 'POST',
                data: aver,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(data) {
                    if (data.resultado == null) {
                        resultado = data.resultado;
                    } else {
                        resultado = parseInt(data.resultado);
                    }

                    debugger
                },
                error: function(x, y, z) {
                    alert("Error en webservice: " + x + y + z);
                }
            });

        }

        function MandarMensaje(Mensaje) {
            var dataToSend = {
                idusuario: Mensaje.idUsuario,
                idusuario2: Mensaje.idUsuario2,
                mensaje: Mensaje.mensajito
            };
            var aver = JSON.stringify(dataToSend);
            debugger
            $.ajax({
                url: urlglobal.url + "/addMandarMensaje",
                async: true,
                type: 'POST',
                data: aver,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function() {
                    alert("Mensaje Enviado Correctamente");

                },
                error: function(x, y, z) {
                    alert("Error en webservice: " + x + y + z);
                }
            });
        }

    });
</script>

</html>