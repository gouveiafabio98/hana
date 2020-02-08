<?php
session_start(); 
date_default_timezone_set('UTC');
$login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'. $_SESSION["utilizador"] .'/'));
if($login) {
    $utilizador = $_SESSION["utilizador"];
    $nome = $_GET["nome"];
    $livraria = $_GET["livraria"];
    if (!file_exists('data/contas/'. $utilizador .'/reservas')) {
        mkdir('data/contas/'. $utilizador .'/reservas', 0777, true);
    }
    
    $file = fopen('data/contas/'. $utilizador .'/reservas/'.date("d_m_Y-h_i_sa").'.txt', 'w+');
    
    ftruncate($file, 0);
    
    $content = "[nome]".$nome."[/nome]". PHP_EOL ."[livraria]".$livraria."[/livraria]". PHP_EOL ."[data]".date("d/m/Y")."[/data]". PHP_EOL ."[estado]Em processo...[/estado]";
    fwrite($file , $content);
    fclose($file);
}else{
    session_destroy();
}
header("Location: conta");
?>