<?php 
session_unset($_SESSION['login']);
session_destroy($_SESSION['login']);
session_start();
session_regenerate_id(true);
header("Location: index.php?page=login");
?>