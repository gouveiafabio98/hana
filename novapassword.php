<?php
session_start();

$login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'. $_SESSION["utilizador"] .'/'));

function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);   
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

if(!$login) {
    $passwordnew=$_POST["password"];
    $code=$_GET["recover"];
    $user=$_GET["user"];
    
    $code = explode("/", $code);
    
    if(file_exists('data/contas/'. $user .'/')){
        $content = file_get_contents("data/contas/". $user ."/info.txt");
        $email = get_string_between($content, "[email]", "[/email]");
        $password = get_string_between($content, "[password]", "[/password]");
        
        if($code[0]==md5($email) && $code[1]==md5($password)) {
            $content = str_replace($password, md5($passwordnew), $content);
            $file = fopen('data/contas/'. $user .'/info.txt', 'w+');
    
            ftruncate($file, 0);
            fwrite($file, $content);
            fclose($file);
        }
    }
}else{
    session_destroy();
}
header("Location: conta");
?>