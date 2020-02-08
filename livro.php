<?php
    function get_string_between($string, $start, $end){
	   $string = " ".$string;
	   $ini = strpos($string,$start);
	   if ($ini == 0) return "";
	   $ini += strlen($start);   
	   $len = strpos($string,$end,$ini) - $ini;
	   return substr($string,$ini,$len);
    }
    session_start(); 
    $login = (isset($_SESSION["utilizador"]) && file_exists('data/contas/'. $_SESSION["utilizador"] .'/'));
    
    if($login){
        $utilizador = $_SESSION["utilizador"];
    }else{
        session_destroy();
    }
    
    $pagina = $_GET["book"];
    
    if($pagina!=""){
        $livro = file_get_contents("data/livros/". $pagina ."/info.txt");
    }
    
    if($livro == null || !isset($livro)) {
        header("Location: livros");
    }
    
    $titulo = get_string_between($livro, "[titulo]", "[/titulo]");
    $autor = get_string_between($livro, "[autor]", "[/autor]");
    $genero = get_string_between($livro, "[genero]", "[/genero]");
    $sinopse = get_string_between($livro, "[sinopse]", "[/sinopse]");
    $paginas = get_string_between($livro, "[paginas]", "[/paginas]");
    $formato = get_string_between($livro, "[formato]", "[/formato]");
    $isbn = get_string_between($livro, "[isbn]", "[/isbn]");
    $copyright = get_string_between($livro, "[copyright]", "[/copyright]");
    $preco = get_string_between($livro, "[preco]", "[/preco]");
    $desconto = get_string_between($livro, "[desconto]", "[/desconto]");
    $capa = get_string_between($livro, "[capa]", "[/capa]");
    $inside = get_string_between($livro, "[inside]", "[/inside]");
    $parecidos = get_string_between($livro, "[parecidos]", "[/parecidos]");
    $parecidos = explode(".", $parecidos);
    
    // ----- Obter info do site goodreads com JSON ----- //
    $url = "https://www.goodreads.com/book/review_counts.json?key=0kHArUououJ6HcBjPrDfKA&isbns=". str_replace("-", "", $isbn) ."";
    $result = file_get_contents($url);
    $decode = json_decode($result);
    $nota = $decode->books[0]->average_rating;
    $n_nota = $decode->books[0]->work_ratings_count;

    $livrarias = file_get_contents("data/livrarias.txt");
    $locais = explode(".", get_string_between($livrarias, "[locais]", "[/locais]"));
    
    $livros = file_get_contents("data/livros/livros.txt");
    
    $generoDesc = get_string_between($livros, "[". $genero ."]", "[/". $genero ."]");
?>

<!DOCTYPE html>

<html lang="pt">

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <link rel="icon" type="image/png" href="image/favicon.png" sizes="16x16" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $titulo; ?></title>
    <script type="text/javascript" src="js/goodreads.js"></script>
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
    <main id="istonaoeoindex">
        <div id="pesquisaprincipal">
            <input onblur="blursearch();" type="text" placeholder="Pesquisar..." />
            <input onclick="pesquisa();" type="image" src="image/lupa.svg" alt="Lupa" />
        </div>
        <div class="navigation">
            <ul>
                <li>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 560.784 560.784" style="enable-background:new 0 0 560.784 560.784;" xml:space="preserve">
                        <g>
                            <path d="M314.784,71.801v417.18c0,4.953-4.02,8.966-8.967,8.966h-50.844c-4.959,0-8.979-4.013-8.979-8.966V71.801
		c0-4.953,4.019-8.963,8.979-8.963h50.844C310.771,62.837,314.784,66.848,314.784,71.801z M559.289,210.157l-43.739-39.262
		c-0.822-0.733-1.892-1.147-2.997-1.147H333.102c-2.477,0-4.485,2.004-4.485,4.492v70.285c0,2.474,2.009,4.483,4.485,4.483h179.445
		c0.934,0,1.838-0.29,2.601-0.821l43.74-31.035c1.11-0.792,1.803-2.045,1.891-3.399C560.85,212.397,560.306,211.076,559.289,210.157
		z M227.675,94.978H48.232c-1.108,0-2.172,0.398-3.002,1.144L1.487,135.383c-1.011,0.901-1.555,2.228-1.48,3.587
		c0.077,1.369,0.774,2.622,1.885,3.411l43.743,31.025c0.757,0.538,1.661,0.833,2.598,0.833h179.442c2.477,0,4.492-2.015,4.492-4.492
		V99.46C232.167,96.972,230.157,94.978,227.675,94.978z" />
                        </g>
                    </svg>

                </li>
                <li>
                    <span><a href="index" class="link">Inicio</a> /</span>
                </li>
                <li>
                    <span><a href="livros" class="link">Livros</a> /</span>
                </li>
                <li>
                    <span><a href="livros?book=<?php echo $genero; ?>" class="link"><?php echo $generoDesc; ?></a> /</span>
                </li>
                <li>
                    <span><a href="livro?book=<?php echo $pagina; ?>" id="activated"><?php echo $titulo; ?></a></span>
                </li>
            </ul>
        </div>


        <div class="title">
            <div>
                <span class="name"><?php echo $titulo; ?></span>
                <span id="autor">de <?php echo $autor; ?></span>
            </div>
            <span id="nota"><a href="https://www.goodreads.com/" target="_blank" title="Goodreads.com
<?php echo $n_nota; ?> votos">Nota <?php echo $nota; ?></a></span>
        </div>

        <div>
            <div class="artucle">
                <div id="content">
                    <div id="cover">
                        <img src="data/livros/<?php echo $pagina; ?>/<?php echo $capa; ?>" alt="capa">
                    </div>
                    <div id="sinopse">
                        <span class="articletitle">Sinopse</span>
                        <p><?php echo $sinopse; ?></p>
                    </div>
                </div>

                <div>
                    <span id="preco">
                        <?php if($desconto!=null){ ?>
                        <span class="desconto"><?php echo $preco; ?> </span> <?php echo $desconto; ?>
                        <?php }else{
                            echo $preco;
                        } ?>
                    </span>

                    <form method="get" action="reservar">
                        <div id="reserva">
                            <select name="livraria">
                                <?php
                                for($i=0 ; $i < sizeof($locais); $i++) {
                                ?>
                                <option disabled><?php echo $locais[$i]; ?></option>
                                <?php $lojas = explode(".", get_string_between($livrarias, "[". strtolower($locais[$i]) ."]", "[/". strtolower($locais[$i]) ."]"));
                                for($j=0; $j < sizeof($lojas); $j++) { ?>
                                <option value="<?php echo $lojas[$j]; ?>"><?php echo $lojas[$j];?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <input type="text" name="nome" value="<?php echo $titulo; ?>" style="display: none;">
                        <button type="submit" id="reservar">
                            Reservar
                        </button>
                    </form>
                    <div id="infobutton">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 496.304 496.303" style="enable-background:new 0 0 496.304 496.303;" xml:space="preserve">
                            <g>
                                <path d="M248.146,0C111.314,0,0,111.321,0,248.152c0,136.829,111.314,248.151,248.146,248.151
		c136.835,0,248.158-111.322,248.158-248.151C496.304,111.321,384.98,0,248.146,0z M248.146,472.093
		c-123.473,0-223.935-100.459-223.935-223.941c0-123.479,100.462-223.941,223.935-223.941
		c123.488,0,223.947,100.462,223.947,223.941C472.093,371.634,371.634,472.093,248.146,472.093z M319.536,383.42v32.852
		c0,1.383-1.123,2.494-2.482,2.494H196.45c-1.374,0-2.482-1.117-2.482-2.494V383.42c0-1.372,1.114-2.482,2.482-2.482h34.744V205.831
		h-35.101c-1.375,0-2.468-1.111-2.468-2.474v-33.6c0-1.38,1.1-2.479,2.468-2.479h82.293c1.371,0,2.482,1.105,2.482,2.479v211.181
		h36.186C318.413,380.938,319.536,382.048,319.536,383.42z M209.93,105.927c0-20.895,16.929-37.829,37.829-37.829
		c20.886,0,37.826,16.935,37.826,37.829s-16.94,37.829-37.826,37.829C226.853,143.756,209.93,126.822,209.93,105.927z" />
                            </g>
                        </svg>
                        <div id="info">
                            <table>
                                <tr>
                                    <th class="infotitle">Páginas</th>
                                    <td><?php echo $paginas; ?></td>
                                </tr>
                                <tr>
                                    <th class="infotitle">Formato</th>
                                    <td><?php echo $formato; ?></td>
                                </tr>
                                <tr>
                                    <th class="infotitle">ISBN</th>
                                    <td><?php echo $isbn; ?></td>
                                </tr>
                                <tr>
                                    <th class="infotitle">Copyright</th>
                                    <td><?php echo $copyright; ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <aside>
        <div class="title">
            <div>
                <span class="name">Outros livros do autor</span>
            </div>
        </div>

        <div class="booklist">
            <ul>
                <?php
                    for($i=0; $i<sizeof($parecidos); $i++) {
                        $livro = file_get_contents("data/livros/". $parecidos[$i] ."/info.txt");
                        $titulo = get_string_between($livro, "[titulo]", "[/titulo]");
                        $preco = get_string_between($livro, "[preco]", "[/preco]");
                        $desconto = get_string_between($livro, "[desconto]", "[/desconto]");
                        $capa = get_string_between($livro, "[capa]", "[/capa]");
                        $inside = get_string_between($livro, "[inside]", "[/inside]");
                ?>
                <li>
                    <a href="livro?book=<?php echo $parecidos[$i]; ?>">
                        <img src="data/livros/<?php echo $parecidos[$i]; ?>/<?php echo $inside; ?>" alt="Tokyo Ghoul 02 Inside" class="img_inside">
                        <img src="data/livros/<?php echo $parecidos[$i]; ?>/<?php echo $capa; ?>" alt="Tokyo Ghoul 02" class="img_cover">
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
