var auxanim;
var auxanimdois;
var auxanimtres;

function fechamenu() {

    document.getElementById("xis").classList.add("nonolas");
    document.getElementById("xis").classList.remove("blockolas");

    document.getElementById("hamburgeru").classList.add("blockolas");
    document.getElementById("hamburgeru").classList.remove("nonolas");

    if (!document.getElementById("scrollnav").classList.contains("fechando")) {
        document.getElementById("scrollnav").classList.remove("abrindo");

        document.getElementById("scrollnav").childNodes[1].childNodes[3].classList.add("reduzopacidade");
        document.getElementById("scrollnav").childNodes[1].childNodes[5].classList.add("reduzopacidade");
        document.getElementById("scrollnav").childNodes[1].childNodes[7].classList.add("reduzopacidade");
        document.getElementById("scrollnav").childNodes[3].childNodes[1].classList.add("reduzopacidade");
        document.getElementById("scrollnav").childNodes[3].childNodes[3].classList.add("reduzopacidade");

        document.getElementById("scrollnav").childNodes[1].childNodes[3].classList.remove("aumentaopacidade");
        document.getElementById("scrollnav").childNodes[1].childNodes[5].classList.remove("aumentaopacidade");
        document.getElementById("scrollnav").childNodes[1].childNodes[7].classList.remove("aumentaopacidade");
        document.getElementById("scrollnav").childNodes[3].childNodes[1].classList.remove("aumentaopacidade");
        document.getElementById("scrollnav").childNodes[3].childNodes[3].classList.remove("aumentaopacidade");

        auxanimdois = setInterval(function () {
            auxiliar_animacaodois();
        }, 200);

    }
}

function abremenu() {
    document.getElementById("xis").classList.add("blockolas");
    document.getElementById("xis").classList.remove("nonolas");

    document.getElementById("hamburgeru").classList.add("nonolas");
    document.getElementById("hamburgeru").classList.remove("blockolas");

    if (!document.getElementById("scrollnav").classList.contains("abrindo")) {
        document.getElementById("scrollnav").classList.add("abrindo");
        document.getElementById("scrollnav").classList.remove("fechando");
        auxanim = setInterval(function () {
            auxiliar_animacao();
        }, 200);
    }
}

function auxiliar_animacao() {
    document.getElementById("scrollnav").classList.remove("abrindo");
    document.getElementById("scrollnav").classList.add("fim");
    document.getElementById("scrollnav").childNodes[1].childNodes[3].classList.add("aumentaopacidade");
    document.getElementById("scrollnav").childNodes[1].childNodes[5].classList.add("aumentaopacidade");
    document.getElementById("scrollnav").childNodes[1].childNodes[7].classList.add("aumentaopacidade");
    document.getElementById("scrollnav").childNodes[3].childNodes[1].classList.add("aumentaopacidade");
    document.getElementById("scrollnav").childNodes[3].childNodes[3].classList.add("aumentaopacidade");
    clearInterval(auxanim);
}

function auxiliar_animacaodois() {
    document.getElementById("scrollnav").classList.remove("fim");
    document.getElementById("scrollnav").classList.add("fechando");
    document.getElementById("scrollnav").classList.remove("abrindo");
    clearInterval(auxanimdois);
}

function focussearch() {
    if (!document.getElementById("pesquisaprincipal").style.display || document.getElementById("pesquisaprincipal").style.display == "none") {
        document.getElementById("pesquisaprincipal").style.display = "flex";
        document.getElementById("pesquisaprincipal").classList.remove("oppenos");
        document.getElementById("pesquisaprincipal").classList.add("oppmais");
        document.getElementById("pesquisaprincipal").childNodes[1].focus();
    }
}

function blursearch() {
    document.getElementById("pesquisaprincipal").classList.remove("oppmais");
    document.getElementById("pesquisaprincipal").classList.add("oppmenos");
    auxanimtres = setInterval(function () {
        auxiliar_animacaotres();
    }, 300);
}

function auxiliar_animacaotres() {
 document.getElementById("pesquisaprincipal").style.display = "none";
    clearInterval(auxanimtres);
}


function opcem() {
    console.log(document.getElementById("recup").style.opacity);
    if (!document.getElementById("recup").style.opacity || document.getElementById("recup").style.opacity === "0") {
        document.getElementById("recup").style.opacity = "1";
    } else {
        document.getElementById("recup").style.opacity = "0";
    }
}


function pesquisa() {
    window.location.href = "livros?search=" + document.getElementById("pesquisaprincipal").childNodes[1].value;
}


/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------

/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------

/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------/*-------**/
