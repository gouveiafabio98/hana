fetch('data/noticias/noticias.json')
    .then(function (response) {
        return response.json();
    })
    .then(function (json) {
        faznoticia(json);
    });

var url_string = window.location.href
var url = new URL(url_string);
var c = url.searchParams.get("new");

function faznoticia(json) {
    var n;
    for (var i = 0; i < json.length; i++) {
        if (json[i].titulo == c) {
            n = i;
        }
    }
    document.getElementsByClassName("name")[0].innerHTML = json[n].titulo;
    document.getElementById("nota").innerHTML = json[n].data;
    document.getElementById("subtitulo").innerHTML = json[n].subtitulo;
    for (var i = 0; i < json[n].texto.length; i++) {
        console.log(json[n].texto[i]);
        var bloconoticias = document.createElement("div");
        var p = document.createElement("p");
        var media;
        var source= document.createElement("source");
        
        bloconoticias.classList.add("bloconoticias");

        if (i%2==0) {
            media = document.createElement("video");
            media.controls="controls";
            source.src= "data/noticias/" + json[n].titulo + "/" + json[n].video[0];
            media.appendChild(source);
        } else{
            media = document.createElement("img");
            media.src= "data/noticias/" + json[n].titulo + "/" + json[n].imagens[0];
        }
        
        p.appendChild(media);
        p.innerHTML=p.innerHTML+json[n].texto[i];
        bloconoticias.appendChild(p);
        document.getElementById("subtitulo").parentElement.appendChild(bloconoticias);
    }
}
