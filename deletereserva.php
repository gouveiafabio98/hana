<?php

session_start();

$login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'. $_SESSION["utilizador"] .'/'));

if($login){
    $reserva = $_GET["reserva"];
    
    unlink("data/contas/". $_SESSION["utilizador"] ."/reservas/". $reserva);
}else{
    session_destroy();
}
header("Location: ".$_SERVER["HTTP_REFERER"]);
?>