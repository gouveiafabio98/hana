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
    
    function getSubDirectories($dir) {
        $subDir = array();
        $directories = array_filter(glob($dir), 'is_dir');
        $subDir = array_merge($subDir, $directories);
        foreach ($directories as $directory) $subDir = array_merge($subDir, getSubDirectories($directory.'/*'));
        return $subDir;
    }
    
    $pagina = @$_GET["book"];
    $search = @$_GET["search"];
    
    $livros = file_get_contents("data/livros/livros.txt");
    
    $categorias = get_string_between($livros, "[categorias]", "[/categorias]");
    $categorias = explode(".", $categorias);
    
    if($pagina!=null){
        $i = array_search($pagina, $categorias);
        if($categorias[$i] == $pagina) {
            $categoria = get_string_between($livros, "[". $categorias[$i] ."]", "[/". $categorias[$i] ."]");
            $livroscategoria = getSubDirectories("./data/livros/". $categorias[$i] ."");
        }else{
            $pagina=null;
        }
    }
    
    if($search!=null && $pagina==null) {
        $livrosSearch = array();
        
        for($i = 0; $i < sizeof($categorias); $i++) {
            $livrosCategoria = scandir("./data/livros/". $categorias[$i] ."");
           
            
            for($j = 0; $j < sizeof($livrosCategoria); $j++) {
                 
                if (strpos($livrosCategoria[$j], $search) !== false) {
                    array_push($livrosSearch, array(
                    "categoria" => $categorias[$i],
                    "nome"  => $livrosCategoria[$j]));
                }
            }
        }
    }
    
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
    
    <?php if($pagina == null && $search==null) { ?>
    <title>Livros</title>
    <?php } else if ($pagina==null){ ?>
    <title>Procura de Livros</title>
    <?php } else { ?>
    <title><?php echo $categoria; ?></title>
    <?php } ?>
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
            <input  onclick="pesquisa();" type="image" src="image/lupa.svg" alt="Lupa" />
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
                    <span><a href="livros" <?php if($pagina == null) { ?> id="activated" <?php } else { ?> class="link" <?php } ?>>Livros</a><?php if($pagina != null) { ?> / <?php } ?></span>
                </li>
                <?php
                if($pagina != null) {
                ?>
                <li>
                    <span><a href="livros?book=<?php echo $pagina; ?>" id="activated"><?php echo $categoria; ?></a></span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>


        <div class="title">
            <div>
                <?php if($pagina == null && $search==null) { ?>
                <span class="name">Categorias</span>
                <?php } else if ($pagina==null){ ?>
               <span class="name">Procura de '<?php echo $search; ?>'</span>
                <?php } else { ?>
                <span class="name"><?php echo $categoria; ?></span>
                <?php } ?>
            </div>
        </div>

        <div class="booklist">
            <ul>
                <?php if($pagina == null && $search==null) { 
                    for($i = 0; $i < sizeof($categorias); $i++){
                        $categoria = get_string_between($livros, "[". $categorias[$i] ."]", "[/". $categorias[$i] ."]");
                ?>
                <li>
                    <a href="livros?book=<?php echo $categorias[$i]; ?>">
                        <img src="data/livros/<?php echo $categorias[$i]; ?>/cover.png" alt="Arte & Fotografia">
                        <div class="book">
                            <span class="descricao"><?php echo $categoria; ?></span>
                        </div>
                    </a>
                </li>
                <?php }} else if ($pagina==null) {
                    for($i=0; $i<sizeof($livrosSearch); $i++) {
                        $livro = file_get_contents("data/livros/". $livrosSearch[$i]['categoria'] . "/". $livrosSearch[$i]['nome'] ."/info.txt");
                        $titulo = get_string_between($livro, "[titulo]", "[/titulo]");
                        $preco = get_string_between($livro, "[preco]", "[/preco]");
                        $desconto = get_string_between($livro, "[desconto]", "[/desconto]");
                        $capa = get_string_between($livro, "[capa]", "[/capa]");
                        $inside = get_string_between($livro, "[inside]", "[/inside]");
                
                ?>
                <li>
                    <a href="livro?book=<?php echo $livrosSearch[$i]['categoria']."/".$livrosSearch[$i]['nome']; ?>">
                        <img src="data/livros/<?php echo $livrosSearch[$i]['categoria']."/".$livrosSearch[$i]['nome']; ?>/<?php echo $inside; ?>" alt="Tokyo Ghoul 02 Inside" class="img_inside">
                        <img src="data/livros/<?php echo $livrosSearch[$i]['categoria']."/".$livrosSearch[$i]['nome']; ?>/<?php echo $capa; ?>" alt="Tokyo Ghoul 02" class="img_cover">
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
                <?php }} else {
                    for($i=1; $i<sizeof($livroscategoria); $i++) {
                        $livro = file_get_contents($livroscategoria[$i] ."/info.txt");
                        $titulo = get_string_between($livro, "[titulo]", "[/titulo]");
                        $preco = get_string_between($livro, "[preco]", "[/preco]");
                        $desconto = get_string_between($livro, "[desconto]", "[/desconto]");
                        $capa = get_string_between($livro, "[capa]", "[/capa]");
                        $inside = get_string_between($livro, "[inside]", "[/inside]");
                
                ?>
                <li>
                    <a href="livro?book=<?php echo $pagina ."/". str_replace("./data/livros/". $pagina ."/", "", $livroscategoria[$i]); ?>">
                        <img src="<?php echo $livroscategoria[$i] ?>/<?php echo $inside; ?>" alt="Tokyo Ghoul 02 Inside" class="img_inside">
                        <img src="<?php echo $livroscategoria[$i] ?>/<?php echo $capa; ?>" alt="Tokyo Ghoul 02" class="img_cover">
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
                <?php }} ?>
            </ul>
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
