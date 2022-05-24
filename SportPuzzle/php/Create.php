<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportsPuzzle</title>
    <link rel="icon" href="../imagenes/Logo.png">
    <script type="text/javascript" src="../Js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/modsCreate.css">

</head>
<?php
include 'navbar.php';
?>

<body>

    <!-- Page Content -->
    <div class="noticiamarco">
        <h1 style="text-align: center;">Nuevo Producto</h1>

        <form>
            <h4>Nombre del Producto:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <input type="text" class="form-control" id="nombreProd" placeholder="Titulo">
            </div>
            <h4>Categoria:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <select class="form-control" id="categorias">

                </select>

            </div>
            <center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Crear Categoria
                </button></center>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Crear Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="NombreCategoria" class="form-label">Category name</label>
                                <input type="text" class="form-control" id="NombreCategoria">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="btn-crearcategoria" data-dismiss="modal">Agregar Categoria</button>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Precio:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <input type="number" class="form-control" id="precioProd" placeholder="Precio" min="0">
            </div>
            <h4>Descripcion:</h4>
            <div class="form-group" style="margin-right: 20px; margin-left: 5px;">
                <textarea class="form-control" id="descripcionProd" placeholder="Descripcion" rows="4"></textarea>
            </div>
        </form>

        <h4 style="margin-top: 10px;">Miniatura:</h4>
        <form style="margin-bottom: 50px;">
            <div class="form-group-imagen">
                <label for="imagenProd">Agregar miniatura</label>
                <input type="file" accept=".jpg,.png" class="form-control-file" name="imagenProd" id="imagenProd">
            </div>
        </form>

        <center>
            <button id="btn-crearProd" type="button" class="btn btn-success">Añadir Producto</button>
        </center>
        <br>
    </div>
    <!--Marco-->
    <?php
    include 'footer.php';
    ?>

</body>
<script type="module">
    import {
        urlglobal
    } from '../Js/urlglobal.js'

    $(document).ready(function() {
        getCategorias();
        //Obtenemos la información del curso
        $('#btn-crearProd').on('click', (event) => {
            event.preventDefault();
            if ($('#nombreProd').val() == "" || $('#descripcionProd').val() == "" ||
                $('#precioProd').val() == "" || $('input[name="imagenProd"]')[0].files[0] == null ||
                document.getElementById("categorias").selectedIndex == null) {
                alert("Asegurate que los campos este completos");
            } else {
                var categorie = document.getElementById("categorias").selectedIndex;
                let categoriavalue = document.getElementsByTagName("option")[categorie].value;

                var prodData = {
                    name: $('#nombreProd').val(),
                    description: $('#descripcionProd').val(),
                    price: $('#precioProd').val(),
                    category: categoriavalue,
                    image: "lol",
                    active: true
                };
                crearProd(prodData);
            }


        });
        $('#btn-crearcategoria').on('click', (event) => {
            event.preventDefault();
            var categoriaData = {
                name: $('#NombreCategoria').val()
            };
            addCategoria(categoriaData);

        });

        //Funcion CreamosCurso
        function crearProd(ElCurso) {

            //Agregamos la imagen del curso
            // Create an FormData object 
            var productId = "";
            var token = localStorage.getItem("token");
            var imageCourse = document.getElementById('imagenProd');
            var myFormData = new FormData();
            myFormData.append('image', imageCourse.files[0]);
            debugger
            var foto_path = ""
            var promise = $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "../Js/subir-imagen-prod.php",
                data: myFormData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function(data) {
                    debugger
                    ElCurso.image = data;
                    alert("Imagen agregada");
                },
                error: function(data) {
                    console.log(data);
                    debugger
                }
            });
            promise.then(() => {
                var dataToSendJson = JSON.stringify(ElCurso);
                $.ajax({
                    url: urlglobal.url + "/createProduct",
                    async: true,
                    type: 'POST',
                    data: dataToSendJson,
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    headers: {
                        'Authorization': token
                    },
                    success: function(data) {
                        console.log(data.message._id);
                        productId = data.message._id;
                        alert("Producto agregado correctamente");
                    },
                    error: function(data) {
                        console.log(data);
                        debugger
                        alert("Error agregando producto, posiblemente ya exista uno con el mismo nombre");
                    }
                });
            });
        }

        function getCategorias() {
            $.ajax({
                url: urlglobal.url + "/getAllCategories",
                async: true,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    for (let dato of datos.message) {
                        $('#categorias').append($('<option>', {
                            value: dato.name,
                            text: dato.name
                        }));
                    }
                },
                error: function(datos) {
                    if (datos.status === 404) {
                        alert(datos.responseJSON.message);
                    }
                }
            })
        }
        //funcion agregar categoria
        function addCategoria(laCategoria) {
            var token = localStorage.getItem("token");
            var categoryDataJson = JSON.stringify(laCategoria);
            debugger
            $.ajax({
                url: urlglobal.url + "/createCategory",
                async: true,
                type: 'POST',
                data: categoryDataJson,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'Authorization': token
                },
                success: function(data) {
                    console.log(data);
                    if (data.message === "Esta categoria ya existe.") {
                        alert(data.message);
                    } else {
                        alert("Categoria Agregada Exitosamente");
                        $('#categorias').empty();
                        getCategorias();
                    }
                },
                error: function(x, y, z) {
                    alert("Error en la api: " + x + y + z);
                }
            });
        }
    });
</script>

</html>