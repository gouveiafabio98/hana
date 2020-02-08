<?php
session_set_cookie_params(0);
session_start();

$login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'. $_SESSION["utilizador"] .'/'));

if(!$login){
    
    function get_string_between($string, $start, $end){
	   $string = " ".$string;
	   $ini = strpos($string,$start);
	   if ($ini == 0) return "";
	   $ini += strlen($start);   
	   $len = strpos($string,$end,$ini) - $ini;
	   return substr($string,$ini,$len);
    }
    
    $mail=$_POST["email"];
    
    $contas = scandir("./data/contas");
    
    for($i=2; $i<sizeof($contas); $i++) {
        $user = file_get_contents("data/contas/". $contas[$i] ."/info.txt");
        $email = get_string_between($user, "[email]", "[/email]");
        $password = get_string_between($user, "[password]", "[/password]");
        if($email==$mail){
            $utilizador = $contas[$i];
            $i=sizeof($contas);
        }
    }
    
    if(isset($utilizador)) {
    $subject = 'Recuperar password - Editora Hana';
    
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    
    $message = '
    <head><meta charset="UTF-8"></head>
    <body>
    <div style="background-color:#fff;margin:0 auto 0 auto;padding:30px 0 30px 0;color:#4f565d;font-size:13px;line-height:20px;font-family:\'Helvetica Neue\',Arial,sans-serif;text-align:left;">
        <center>
        <table style="width:550px;text-align:center">
            <tbody>
            <tr>
                <td style="padding:0 0 20px 0;border-bottom:1px solid #e9edee;">
                    <a href="https://student.dei.uc.pt/~fqbio/Hana/" style="display:block; margin:0 auto;" target="_blank">
                        <img src="https://student.dei.uc.pt/~fqbio/Hana/image/logo.png" width="300" height="150" alt="Hana." style="border: 0px;">
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:30px 0;"><p style="color:#1d2227;line-height:28px;font-size:22px;margin:12px 10px 20px 10px;font-weight:400;">Olá '.$utilizador.'!</p>
                <p style="margin:0 10px 10px 10px;padding:0;">Clique no botão abaixo para recuperar a sua password.</p>
                <p><a style="display:inline-block;text-decoration:none;padding:15px 20px;background-color:#2baaed;border:1px solid #2baaed;border-radius:3px;color:#FFF;font-weight:bold;" href="https://student.dei.uc.pt/~fqbio/Hana/conta?recover='.md5($mail).'/'.md5($password).'&user='.$utilizador.'" target="_blank">Recuperar password</a></p>
                <p style="margin:0 10px 10px 10px;padding:0;">Se não fez este pedido ignore o email.</p>
                <p style="margin:0 10px 10px 10px;padding:0;">Obrigado. A equipa Hana.</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:30px 0 0 0;border-top:1px solid #e9edee;color:#9b9fa5">
                Se tiver alguma questão pode contactar-nos por <a style="color:#666d74;text-decoration:none;" href="mailto:editora.hana@gmail.com" target="_blank">editora.hana@gmail.com</a>
                </td>
            </tr>
            </tbody>
        </table>
        </center>
    </div>
    </body>
    ';

    mail($mail,$subject,$message,implode("\r\n", $headers));
    }
}else{
    session_destroy();
}
header("Location: ".$_SERVER["HTTP_REFERER"]);
?>