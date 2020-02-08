fetch('data/noticias/noticias.json')
    .then(function (response) {
        return response.json();
    })
    .then(function (json) {
        faznoticias(json);
    });

var contentor = document.getElementById("noticias");

function faznoticias(json) {

    for (var i = 0; i < json.length; i++) {

        var main = document.createElement("div");
        var image = document.createElement("div");
        var a = document.createElement("a");
        var img = document.createElement("img");

        var conteudo = document.createElement("div");
        var aa = document.createElement("a");
        var span = document.createElement("span");

        var p = document.createElement("p");

        var aaa = document.createElement("a");

        main.classList.add("main");
        image.classList.add("image");
        a.href = "noticia?new=" + json[i].titulo;
        img.src = "data/noticias/" + json[i].titulo + "/" + json[i].cover;
        a.appendChild(img);
        image.appendChild(a);
        conteudo.classList.add("conteudo");
        aa.href = "noticia?new=" + json[i].titulo;
        span.classList.add("titlen");
        span.innerHTML = json[i].titulo;
        aa.appendChild(span);
        conteudo.appendChild(aa);
        p.innerHTML = json[i].texto[0];
        conteudo.appendChild(p);
        main.appendChild(image);
        main.appendChild(conteudo);
        aaa.href = "noticia?new=" + json[i].titulo;
        aaa.innerHTML = "Ler mais...";
        conteudo.appendChild(aaa);
        contentor.appendChild(main);
    }
}
/*
     console.log(JSON.stringify(noticias));
     console.log(JSON.parse(JSON.stringify(noticias)));*/
