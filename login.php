<?php
session_start();
$utilizador=$_POST["utilizador"];
$password=$_POST["password"];

function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);   
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

if (file_exists('data/contas/'. $utilizador .'/')) {
    $user = file_get_contents("data/contas/". $utilizador ."/info.txt");
    
    $estado = get_string_between($user, "[estado]", "[/estado]");
    $utilizadors = get_string_between($user, "[nome]", "[/nome]");
    $passwords = get_string_between($user, "[password]", "[/password]");
    
    if($estado=="1" && $utilizador==$utilizadors && md5($password)==$passwords) {
        $_SESSION["id_utilizador"] = $row[id_utilizador];
        $_SESSION["utilizador"] = $utilizador;
        $_SESSION["password"] = $password;
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }else {
        header("Location: ".$_SERVER["HTTP_REFERER"] ."?erro=1");
    }
    
} else {
    header("Location: ".$_SERVER["HTTP_REFERER"] ."?erro=0");
    session_destroy();
}
?>
