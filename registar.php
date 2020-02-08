<?php
$utilizador=$_POST["utilizador"];
$email=$_POST["email"];
$password=$_POST["password"];

$link=md5($_POST["email"]);


if (!file_exists('data/contas/'. $utilizador .'/')) {
    mkdir('data/contas/'. $utilizador .'/', 0777, true);
    $file = fopen('data/contas/'. $utilizador .'/info.txt', 'w+');
    
    ftruncate($file, 0);
    
    $content = "[nome]".$utilizador."[/nome][email]".$email."[/email][password]".md5($password)."[/password][estado]0[/estado][morada][/morada][postal1][/postal1][postal2][/postal2][postal3][/postal3][telefone][/telefone]";
    fwrite($file, $content);
    fclose($file);
    
    $subject = 'Confirmar registo - Editora Hana';
    
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
                <td colspan="2" style="padding:30px 0;"><p style="color:#1d2227;line-height:28px;font-size:22px;margin:12px 10px 20px 10px;font-weight:400;">Olá '.$_POST["utilizador"].', seja bem vindo à Hana!</p>
                <p style="margin:0 10px 10px 10px;padding:0;">Já temos tudo pronto para o receber. Reserve já os seus livros.</p>
                <p style="margin:0 10px 10px 10px;padding:0;">Confirme o seu email clicando no botão para começar.</p>
                <p><a style="display:inline-block;text-decoration:none;padding:15px 20px;background-color:#2baaed;border:1px solid #2baaed;border-radius:3px;color:#FFF;font-weight:bold;" href="https://student.dei.uc.pt/~fqbio/Hana/conta?url='.$link.'&name='.$_POST["utilizador"].'" target="_blank">Confirmar email</a></p>
                <p style="margin:0 10px 10px 10px;padding:0;">Se não efetuou este registo ignore o email.</p>
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

    mail($email,$subject,$message,implode("\r\n", $headers));
    header("Location: ".$_SERVER["HTTP_REFERER"]);
} else {
    header("Location: ".$_SERVER["HTTP_REFERER"] ."?erro=true");
}
?>
