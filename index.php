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
    
    if($login){
        $utilizador = $_SESSION["utilizador"];
    }else{
        session_destroy();
    }
    
    $livros = file_get_contents("data/livros/livros.txt");

    $ultimos = get_string_between($livros, "[ultimos]", "[/ultimos]");
    $ultimos = explode(".", $ultimos);
?>

<!DOCTYPE html>

<html lang="pt">

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <link rel="icon" type="image/png" href="image/favicon.png" sizes="16x16" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hana</title>
</head>

<body>
    <header>
        <nav class="navbar" id="scrollnav">
            <ul>
                <li class="nav_title"><a href="index" class="nav_title">HANA.</a></li>
                <li><a class="link" href="livros">Livros</a></li>
                <li><a class="link" href="noticias">Notícias</a></li>
                <li><a class="link" href="contactos">Contactos</a></li>
            </ul>

            <div id="segundaul">
                <div id="search"><a onclick="fechamenu(); focussearch();" href="#" class="link">Procurar</a></div>
                <?php if(!$login) { ?>
                <div><a class="link" href="conta">Conta</a></div>
                <?php }else{ ?>
                <div><a class="link" href="conta"><?php echo $utilizador; ?></a></div>
                <div><a class="link" href="logout">Sair</a></div>
                <?php } ?>
            </div>

            <svg onclick="fechamenu();" version="1.1" id="xis" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 348.333 348.334" style="enable-background:new 0 0 348.333 348.334;" xml:space="preserve">
                <g>
                    <path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85
		c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563
		c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85
		l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554
		L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z" />
                </g>
            </svg>

            <svg onclick="abremenu();" id="hamburgeru" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 348.33 348.33">
                <title>Asset 1</title>
                <g id="Layer_2" data-name="Layer 2">
                    <g id="Capa_1" data-name="Capa 1">
                        <path d="M30.48,80.39C13.65,80.39,0,62.39,0,40.19S13.64,0,30.47,0H317.85c16.84,0,30.48,18,30.48,40.2,0,11.09-3.41,21.14-8.92,28.41s-13.14,11.78-21.55,11.77Z" />
                        <path d="M30.48,214.36c-16.83,0-30.48-18-30.48-40.2S13.64,134,30.47,134H317.85c16.84,0,30.48,18,30.48,40.2,0,11.1-3.41,21.14-8.92,28.41s-13.14,11.78-21.55,11.78Z" />
                        <path d="M30.48,348.33c-16.83,0-30.48-18-30.48-40.19S13.64,268,30.47,268H317.85c16.84,0,30.48,18,30.48,40.2,0,11.09-3.41,21.14-8.92,28.41s-13.14,11.78-21.55,11.77Z" />
                    </g>
                </g>
            </svg>

        </nav>
    </header>

    <main>

        <div id="hana">
            <h1>Editora Hana</h1>
        </div>
        <div id="pesquisaprincipal">
            <input  type="text" placeholder="Pesquisar..." />
            <input onclick="pesquisa();" type="image" src="image/lupa.svg" alt="Lupa" />
        </div>

    </main>


    <aside>
        <div class="title">
            <div>
                <span class="name">Ultimos lançamentos</span>
            </div>
        </div>

        <div class="booklist">
            <ul>
                <?php
                    for($i=0; $i<sizeof($ultimos); $i++) {
                        $livro = file_get_contents("data/livros/". $ultimos[$i] ."/info.txt");
                        $titulo = get_string_between($livro, "[titulo]", "[/titulo]");
                        $preco = get_string_between($livro, "[preco]", "[/preco]");
                        $desconto = get_string_between($livro, "[desconto]", "[/desconto]");
                        $capa = get_string_between($livro, "[capa]", "[/capa]");
                        $inside = get_string_between($livro, "[inside]", "[/inside]");
                ?>
                <li>
                    <a href="livro?book=<?php echo $ultimos[$i]; ?>">
                        <img src="data/livros/<?php echo $ultimos[$i]; ?>/<?php echo $inside; ?>" alt="Tokyo Ghoul 02 Inside" class="img_inside">
                        <img src="data/livros/<?php echo $ultimos[$i]; ?>/<?php echo $capa; ?>" alt="Tokyo Ghoul 02" class="img_cover">
                        <div class="book">
                            <span class="name"><?php echo $titulo; ?></span>
                            <?php
                                if($desconto!=null) {
                            ?>
                            <span class="preco"><span class="desconto"><?php echo $preco; ?></span> <?php echo $desconto; ?></span>
                            <?php
                                } else {
                            ?>
                            <span><?php echo $preco; ?></span>
                            <?php
                                }
                            ?>
                        </div>
                    </a>
                </li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </aside>

    <footer>
        <div>
            <div>
                <ul class="footer_content">
                    <li id="about">
                        <b>Sobre</b>
                        <span>Fundada em 2019, uma editora totalmente portuguesa que promete trazer os melhores exitos da literatura estrangeria para o português</span>
                    </li>
                    <li>
                        <b>Localização</b>
                        <span>Rua da Alegria Nº43</span>
                        <span>Coimbra - Portugal</span>
                        <span>3460-202</span>
                    </li>
                    <li>
                        <b>Contactos</b>
                        <span>hana-editora@uc.pt</span>
                        <span>(+315)944564565</span>
                    </li>
                    <li>
                        <b>Informação</b>
                        <span><a href="contactos.html" class="link">Contactos</a></span>
                        <span><a href="noticias.html" class="link">Notícias</a></span>
                    </li>
                    <li>
                        <b>Redes sociais</b>
                        <span><a href="https://www.facebook.com/" class="link">Facebook</a></span>
                        <span><a href="https://www.instagram.com/" class="link">Instagram</a></span>
                        <span><a href="https://twitter.com" class="link">Twitter</a></span>
                    </li>
                    <li>
                        <a href="#">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 451.847 451.846" style="enable-background:new 0 0 451.847 451.846;" xml:space="preserve">
                                <g>
                                    <path d="M248.292,106.406l194.281,194.29c12.365,12.359,12.365,32.391,0,44.744c-12.354,12.354-32.391,12.354-44.744,0
		L225.923,173.529L54.018,345.44c-12.36,12.354-32.395,12.354-44.748,0c-12.359-12.354-12.359-32.391,0-44.75L203.554,106.4
		c6.18-6.174,14.271-9.259,22.369-9.259C234.018,97.141,242.115,100.232,248.292,106.406z" />
                                </g>
                            </svg>
                        </a>
                        <span>© 2019 Hana Editora</span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

</body>
<script src="js/script.js" type="text/javascript"></script>
</html>
