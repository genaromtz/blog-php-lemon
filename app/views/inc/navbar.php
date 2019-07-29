<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?=URLROOT?>">Lemon</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?=URLROOT?>">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <?php if (tieneSesion()) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuarios
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Nuevo usuario</a>
                        <a class="dropdown-item" href="#">Listado de usuarios</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catálogos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?=URLROOT?>/perfiles/">Perfiles</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['usuario']->getNombre()?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mis artículos</a>
                        <a class="dropdown-item" href="#">Perfil</a>
                        <a class="dropdown-item" href="#">Imagen de perfil</a>
                        <a class="dropdown-item" href="#">Cuenta</a>
                        <a class="dropdown-item" href="<?=URLROOT?>/usuarios/logout">Cerrar sesión</a>
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=URLROOT?>/usuarios/registro">Registrate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=URLROOT?>/usuarios/login">Iniciar sesión</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>