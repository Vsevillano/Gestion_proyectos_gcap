<?php 

    ob_start();

    session_start();

    // Controlamos el tiempo de actividad 
    include('php/includes/tiempo.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/main.js"></script>

    <title>Gestion de proyectos</title>
</head>
<body>
    <header>
        <div class="logoNav">
            <a href="index.php?page=inicio"><img src="images/logo_gcap.jpg" alt="Logo IES Gran Capitan"></a>
            <h1>Gestion de proyectos</h1>
            <h2>Departamento de informatica</h2>
        </div>
        <?php
            include('php/includes/nav.php');
        ?>
    </header>
    <main>

        <?php
        
            include('php/includes/main.php');
        ?>
    </main>
    <footer>
        <p>Aplicacion Gestión de proyectos del IES Gran Capitán. Diseñado por Victoriano Sevillano Vega</p>
    </footer>
</body>
</html>

<?php 
	ob_end_flush();
?>
