    <?php session_start();
    if (isset($_SESSION['correo']) && isset($_SESSION['rol'])) {
        //  Si esta logeado 
        if ($_SESSION['rol'] == 0) { ?>
            <!-- Es alumno -->
            <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #7952b3;">
                <a class="navbar-brand" href="index.php">CurSOS</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="cursos.php">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mensajes.php">Mensajes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Perfil.php"> Mi Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="historial.php"> Historial</a>
                        </li>

                    </ul>
                    <form action="User.php" method="post" class="form-inline my-2 my-lg-0" style="padding-right: 15px;">
                        <input name="searchUser" class="form-control mr-sm-2" type="search" placeholder="Busca Usuario" aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                    </form>
                    <form action="busqueda.php" method="post" class="form-inline my-2 my-lg-0">
                        <input name="searchCourse" class="form-control mr-sm-2" type="search" placeholder="Busca Curso" aria-label="Search">
                        <button class="btn btn-success my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                    </form>
                    <a href="vendiendo.php"><img id="carrito" src="https://image.flaticon.com/icons/png/512/34/34568.png" alt=""></a>

                    <img id="imagenUser" src="<?php echo $_SESSION['avatar'] ?>" alt="ImagenPerfil" width="50" height="30" style="padding-left: 10px; padding-right: 10px;">
                    <a id="NombreUser" style="color: #ecfdf9"><?php echo $_SESSION['usuario'] ?></a>
                    <a id="LogOut" class="btn btn-outline-light" href="../Js/logout.php" role="button" style="margin-left: 10px;">Cerrar Sesion</a>
                </div>
            </nav>
        <?php } else { ?>
            <!-- Es maestro -->
            <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #7952b3;">
                <a class="navbar-brand" href="index.php">CurSOS</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="cursos.php">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mensajes.php">Mensajes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Perfil.php"> Mi Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Create.php"> Crear Curso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="historial.php"> Historial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="UserEscuela.php"> Tus ventas</a>
                        </li>
                    </ul>
                    <form action="User.php" method="post" class="form-inline my-2 my-lg-0" style="padding-right: 15px;">
                        <input name="searchUser" class="form-control mr-sm-2" type="search" placeholder="Busca Usuario" aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                    </form>
                    <form action="busqueda.php" method="post" class="form-inline my-2 my-lg-0">
                        <input name="searchCourse" class="form-control mr-sm-2" type="search" placeholder="Busca Curso" aria-label="Search">
                        <button class="btn btn-success my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                    </form>
                    <a href="vendiendo.php"><img id="carrito" src="https://image.flaticon.com/icons/png/512/34/34568.png" alt=""></a>

                    <img id="imagenUser" src="<?php echo $_SESSION['avatar'] ?>" alt="ImagenPerfil" width="50" height="30" style="padding-left: 10px; padding-right: 10px;">
                    <a id="NombreUser" style="color: #ecfdf9"><?php echo $_SESSION['usuario'] ?></a>
                    <a id="LogOut" class="btn btn-outline-light" href="../Js/logout.php" role="button" style="margin-left: 10px;">Cerrar Sesion</a>
                </div>
            </nav>
        <?php }
    } else { ?>
        <!-- No esta logueado -->
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #7952b3;">
            <a class="navbar-brand" href="index.php">CurSOS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="cursos.php">Categorias</a>
                    </li>

                </ul>
                <form action="User.php" method="post" class="form-inline my-2 my-lg-0" style="padding-right: 15px;">
                    <input name="searchUser" class="form-control mr-sm-2" type="search" placeholder="Busca Usuario" aria-label="Search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                </form>
                <form action="busqueda.php" method="post" class="form-inline my-2 my-lg-0">
                    <input name="searchCourse" class="form-control mr-sm-2" type="search" placeholder="Busca Curso" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" type="submit"><img src="https://www.seekpng.com/png/full/920-9209972_magnifying-glass-png-white-search-icon-white-png.png" width="20" height="20" alt=""></button>
                </form>
                <a id="Login" class="btn btn-outline-light" href="Login.php" role="button" style="margin-left: 10px;">Acceder</a>
            </div>
        </nav>
    <?php } ?>