<?php
    date_default_timezone_set('UTC');
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    
    $file = fopen('data/contactos/'.$nome."_".$assunto.date("-d_m_Y-h_i_sa").'.txt', 'w+');
    
    ftruncate($file, 0);
    
    $content = "[nome]".$nome."[/nome]". PHP_EOL ."[email]".$email."[/email]". PHP_EOL ."[telefone]".$telefone."[/telefone]". PHP_EOL ."[assunto]".$assunto."[/assunto]". PHP_EOL ."[mensagem]".$mensagem."[/mensagem]". PHP_EOL ."[dia]". date("d/m/Y") ."[/dia]". PHP_EOL ."[hora]". date("h:i:sa") ."[/hora]";
    fwrite($file , $content);
    fclose($file );
    die(header("Location: ".$_SERVER["HTTP_REFERER"]));
?>
