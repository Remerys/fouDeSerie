/* lesLiens contient la liste des éléments <a> correspond au lien avec le pouce, le nombre de like et le j'aime */
var lesLiens = document.getElementsByClassName('likes')
/* on parcourt les éléments que l'on vient de récupérer et pour chacun d'entre eux on écoute l'événement click et on appelle la fonction majLike lorsque l'événement se produit */
for (var i = 0; i < lesLiens.length; i++) {
    addEventListener('click', majLike)
}

function majLike(event) {
    /* On annule l'action par défaut correspondant à l'événement. Normalement quand on clique sur un lien, cela entraîne directement une nouvelle requête  http. Or dans notre cas, on ne veut pas que la requête s'exécute pour afficher  une page contenant le json*/
    event.preventDefault()
    /* On récupère l'URL du lien. Attention l'élément sur lequel se produit l'événement ne correspond pas à la balise <a> mais à la balise <i> ou une des balises <span> */
    /* utiliser la propriété parentNode pour récupérer le parent de l'élément sur lequel s'est produit l'événement c’est-à-dire la balise <a> */
    let xhr = new XMLHttpRequest();
    /* On récupère l'URL du lien. Attention l'élément sur lequel se produit l'événement ne correspond pas à la balise <a> mais à la balise <i> ou une des balises <span> */
    /* utiliser la propriété parentNode pour récupérer le parent de l'élément sur lequel s'est produit l'événement c’est-à-dire la balise <a> */
    let baliseA = event.target.parentNode
    //On récupère la valeur de l'attribut href
    let url = baliseA.getAttribute('href')
    //On initialise notre requête avec open()
    xhr.open("GET", url);
    //On indique le format de la réponse
    xhr.responseType = "json"
    //On envoie la requête
    xhr.send();
    //Dès que la réponse est reçue...
    xhr.onload = function () {
        //Si le statut HTTP n'est pas 200...
        if (xhr.status != 200) {
            //...On affiche le statut et le message correspondant
            alert("Erreur " + xhr.status + " : " + xhr.statusText)
            //Si le statut HTTP est 200
        } else {
            baliseA.children[1].textContent = xhr.response.likes
        }
    }
    //Si la requête n'a pas pu aboutir...
    xhr.onerror = function () {
        alert("La requête a échoué")
    }
}