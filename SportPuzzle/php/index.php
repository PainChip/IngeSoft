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
    <link rel="stylesheet" href="../css/modsindex.css">

    <script type="text/javascript" src="../Js/modelosJS/curso.js"></script>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>

    <header class="py-5 mb-5" style="background-color: #eee;
     background-image: url(https://www.incimages.com/uploaded_files/image/1920x1080/getty_933383882_2000133420009280345_410292.jpg); 
     height: 500px;">

        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-12" style="background-color: rgba(255, 255, 255, 0.719); ">
                    <h1 class="display-4 text-black mt-5 mb-2" style="text-align: center;">CurSOS</h1>
                    <p class="lead mb-2 text-black-20" style="text-align: center;">Aprende nuevas habilidades o desafía tus limites con CurSOS.</p>
                    <p class="lead mb-4 text-black-20" style="text-align: center;">No dejes tus conocimientos obsoletos y rompe las barreras del conocimiento.</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-12 mb-5">
                <h2>Los cursos mas recientes</h2>
                <hr>
                <div class="row" id="CursosRecientes">
                </div>
            </div>
            <div class="col-md-12 mb-5">
                <h2>Cursos Mas Vendidos</h2>
                <hr>
                <div class="row" id="CursosMasVendidos">
                </div>
            </div>
        </div>
        <!-- /.row -->



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
        <?php
        if (isset($_SESSION['id_usuario'])) { ?>
            var idactual = <?php echo $_SESSION['id_usuario'] ?>;
        <?php } ?>

        getCursos();

        function getCursos() {
            debugger
            var promise = $.ajax({
                url: urlglobal.url + "/get3CursosRecientes",
                async: true,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(datos) {
                    for (let dato of datos) {
                        var html = '<div class="col-md-4 mb-5">';
                        html += '<div class="card h-100">';
                        html += '<img class="card-img-top" src="' + dato.foto + '" alt="">';
                        html += '<div class="card-body">';
                        html += '<h4 class="card-title">' + dato.nombre + '</h4>';
                        html += '<p class="card-text">' + dato.descripcion + '</p>';
                        html += '</div>';
                        html += '<div class="card-footer">';
                        html += '<a href="seleccionado.php?idcurso=' + dato.id_curso + '" class="btn btn-primary">Ver Curso</a>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        $('#CursosRecientes').append(html);
                    }
                },
                error: function() {
                    alert("Error con los cursos mas recientes, posiblemente no hay ni uno");
                }
            })
            promise.then(() => {
                $.ajax({
                    url: urlglobal.url + "/get3CursosMasVendidos",
                    async: true,
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(datos) {
                        for (let dato of datos) {
                            var html = '<div class="col-md-4 mb-5">';
                            html += '<div class="card h-100">';
                            html += '<img class="card-img-top" src="' + dato.foto + '" alt="">';
                            html += '<div class="card-body">';
                            html += '<h4 class="card-title">' + dato.nombre + '</h4>';
                            html += '<p class="card-text">' + dato.descripcion + '</p>';
                            html += '</div>';
                            html += '<div class="card-footer">';
                            html += '<a href="seleccionado.php?idcurso=' + dato.id_curso + '" class="btn btn-primary">Ver Curso</a>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            $('#CursosMasVendidos').append(html);
                        }
                    },
                    error: function() {
                        alert("Error con los cursos mas recientes, posiblemente no hay ni uno");
                    }
                })

            });
        }
    });
</script>

</html>