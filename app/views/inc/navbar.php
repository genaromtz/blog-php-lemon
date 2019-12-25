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
            <?php if (tieneSesion()) {
                $perLecPer = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_LEC);
                $perLecUsu = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_LEC); ?>
                
                <?php if ($perLecPer || $perLecUsu) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catálogos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php if ($perLecPer) { ?>
                        <a class="dropdown-item" href="<?=URLROOT?>/perfiles/"><i class="fas fa-users-cog"></i> Perfiles</a>
                        <?php } ?>
                        <?php if ($perLecUsu) { ?>
                        <a class="dropdown-item" href="<?=URLROOT?>/usuarios/"><i class="fas fa-users"></i> Usuarios</a>
                        <?php } ?>
                    </div>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['usuario']->getNombre()?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?=URLROOT?>/usuarios/perfil"><i class="fas fa-user"></i> Mi perfil</a>
                        <a class="dropdown-item" href="<?=URLROOT?>/usuarios/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
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