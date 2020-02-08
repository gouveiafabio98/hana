<?php
    session_start();
    
    function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);   
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

    $login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'.     $_SESSION["utilizador"] .'/'));
    if($login) {
        $utilizador = $_SESSION["utilizador"];
        
        $user = file_get_contents("data/contas/". $utilizador ."/info.txt");
        
        $user = str_replace("[nome]".get_string_between($user, "[nome]", "[/nome]")."[/nome]", "[nome]".$_POST["nome"]."[/nome]", $user);
        
        $user = str_replace("[email]".get_string_between($user, "[email]", "[/email]")."[/email]", "[email]".$_POST["email"]."[/email]", $user);
        
        $user = str_replace("[morada]".get_string_between($user, "[morada]", "[/morada]")."[/morada]", "[morada]".$_POST["morada"]."[/morada]", $user);
        
        $user = str_replace("[postal1]".get_string_between($user, "[postal1]", "[/postal1]")."[/postal1]", "[postal1]".$_POST["postal1"]."[/postal1]", $user);
        
        $user = str_replace("[postal2]".get_string_between($user, "[postal2]", "[/postal2]")."[/postal2]", "[postal2]".$_POST["postal2"]."[/postal2]", $user);
        
        $user = str_replace("[postal3]".get_string_between($user, "[postal3]", "[/postal3]")."[/postal3]", "[postal3]".$_POST["postal3"]."[/postal3]", $user);
        
        $user = str_replace("[telefone]".get_string_between($user, "[telefone]", "[/telefone]")."[/telefone]", "[telefone]".$_POST["telefone"]."[/telefone]", $user);
        
        $file = fopen('data/contas/'. $utilizador .'/info.txt', 'w+');
    
        ftruncate($file, 0);
        fwrite($file, $user);
        fclose($file);
    }else{
        session_destroy();
    }
    header("Location: ".$_SERVER["HTTP_REFERER"]);
?>
