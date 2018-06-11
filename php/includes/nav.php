<?php
// Si esta la sesion activa
if(isset($_SESSION['login'])) {
    // Si el perfil es admin
?> 
    <nav>
        <ul>
            <li><a href="index.php?page=inicio">Inicio</a></li>
            <li><a href="index.php?page=gestion">Gestión</a></li>
            <li><a href="index.php?page=altas">Altas</a></li>
            <li><a href="index.php?page=logout">Log out</a></li>
        </ul>
        <p>Bienvenido, <?php echo $_SESSION['login']['Usuario'];?></p>

    </nav>
        
<?php
    // Si no hay sesion activa    
} else {
    
?>
    <nav>
        <ul>
            <li><a href="index.php?page=inicio">Inicio</a></li>
            <li><a href="index.php?page=login">Login</a></li>
        </ul>
        <p><a href="index.php?page=cambiarPass">¿Olvidó su contraseña?</a></p>

    </nav>
<?php
}
?>