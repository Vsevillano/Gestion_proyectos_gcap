<?php
    if (!isset($_GET['page'])) {
        include("php/pages/inicio.php");
    } else {
        include("php/pages/".$_GET['page'].".php");
    }
?>